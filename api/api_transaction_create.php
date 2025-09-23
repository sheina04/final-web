<?php
// /api/api_transaction_create.php
require __DIR__.'/_bootstrap.php';
require __DIR__.'/api_db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') { json_err('POST only', 405); exit; }

try {
  // Common fields
  $service_type = $_POST['service_type'] ?? '';
  $deceased     = trim($_POST['deceased_name'] ?? '');
  $plot_code    = trim($_POST['plot_code'] ?? '');
  $amount       = (float)($_POST['amount'] ?? 0);
  $payment_date = $_POST['payment_date'] ?? date('Y-m-d');
  $method       = $_POST['method'] ?? '';
  $method_type  = $_POST['method_type'] ?? '';
  if (!$service_type || !$deceased || !$plot_code || !$amount || !$payment_date || !$method || !$method_type) {
    json_err('Missing required fields', 422); exit;
  }

  // Either existing customer_id or create new customer (for burial)
  $customer_id = (int)($_POST['customer_id'] ?? 0);
  if ($customer_id <= 0 && $service_type === 'burial') {
    $name    = trim($_POST['new_customer_name'] ?? '');
    if (!$name) { json_err('Customer name required for burial', 422); exit; }
    $email   = trim($_POST['new_customer_email'] ?? '');
    $phone   = trim($_POST['new_customer_phone'] ?? '');
    $address = trim($_POST['new_customer_address'] ?? '');

    $pdo->beginTransaction();
    $st = $pdo->prepare("INSERT INTO customers(name,email,phone,address) VALUES(?,?,?,?)");
    $st->execute([$name,$email,$phone,$address]);
    $customer_id = (int)$pdo->lastInsertId();
    $pdo->commit();
  }

  // Optional: handle receipt upload (stores filename only)
  $receipt_path = null;
  if (!empty($_FILES['receipt']['name'])) {
    $fn = date('Ymd_His_').preg_replace('/[^a-zA-Z0-9._-]/','_', $_FILES['receipt']['name']);
    $dir = __DIR__.'/../uploads';
    if (!is_dir($dir)) @mkdir($dir,0775,true);
    $dest = $dir.'/'.$fn;
    if (move_uploaded_file($_FILES['receipt']['tmp_name'],$dest)) {
      $receipt_path = 'uploads/'.$fn;
    }
  }

  // Create a txn_id if not provided
  $txn_id = 'TXN-'.date('Ymd-His').'-'.substr(md5(uniqid('',true)),0,6);

  $st = $pdo->prepare("
    INSERT INTO transactions
      (txn_id, customer_id, customer_name, deceased_name, plot_code,
       service_type, amount, method, method_type, payment_date, status, receipt_path)
    VALUES
      (:txn_id, :customer_id, NULL, :deceased, :plot_code,
       :service_type, :amount, :method, :method_type, :payment_date, :status, :receipt)
  ");
  $st->execute([
    ':txn_id'       => $txn_id,
    ':customer_id'  => $customer_id ?: null,
    ':deceased'     => $deceased,
    ':plot_code'    => $plot_code,
    ':service_type' => $service_type,
    ':amount'       => $amount,
    ':method'       => $method,
    ':method_type'  => $method_type,
    ':payment_date' => $payment_date,
    ':status'       => 'paid',
    ':receipt'      => $receipt_path
  ]);

  json_ok(['ok'=>true,'id'=>$pdo->lastInsertId(),'txn_id'=>$txn_id]);
} catch (Throwable $e) {
  if ($pdo->inTransaction()) $pdo->rollBack();
  json_err($e->getMessage(), 500);
}

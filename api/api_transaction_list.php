<?php
// api/api_transaction_list.php
// Optional search: ?q=term (matches txn_id, customer_name, deceased_name, plot_code)
require __DIR__ . '/api_db.php';

$pdo = pdo_conn();

$q = isset($_GET['q']) ? trim((string)$_GET['q']) : '';

$sql = "
  SELECT
    t.txn_id,
    t.customer_id,
    COALESCE(c.name, t.customer_name)    AS customer_name,
    t.deceased_name,
    t.plot_code,
    t.service_type,
    t.amount,
    t.method,
    t.method_type,
    t.payment_date,
    t.status
  FROM transactions t
  LEFT JOIN customers c ON c.id = t.customer_id
";
$params = [];

if ($q !== '') {
  $sql .= "
    WHERE
      t.txn_id       LIKE :kw OR
      COALESCE(c.name, t.customer_name) LIKE :kw OR
      t.deceased_name LIKE :kw OR
      t.plot_code     LIKE :kw
  ";
  $params[':kw'] = '%'.$q.'%';
}

$sql .= " ORDER BY t.payment_date DESC, t.id DESC";

try {
  $stmt = $pdo->prepare($sql);
  $stmt->execute($params);
  $rows = $stmt->fetchAll() ?: [];
  // normalize types where helpful
  foreach ($rows as &$r) {
    // Ensure consistent field names your JS expects
    $r['method_display'] = $r['method']; // your JS already handles labels
  }
  json_ok($rows);
} catch (Throwable $e) {
  json_err('DB error: '.$e->getMessage(), 500);
}

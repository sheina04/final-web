<?php
// api/api_plot_create.php
require __DIR__.'/_bootstrap.php';
require __DIR__.'/api_db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') { json_err('POST only', 405); exit; }

$input = json_decode(file_get_contents('php://input'), true) ?: [];

$plot_code    = trim($input['plot_code'] ?? '');
$section      = trim($input['section'] ?? '');
$lot          = trim($input['lot'] ?? '');
$grave        = trim($input['grave'] ?? '');
$status       = trim($input['status'] ?? 'available');
$res_for      = trim($input['reserved_for'] ?? '');
$expiry       = $input['expiry'] ?? null;

$owner_name   = trim($input['owner_name'] ?? '');
$owner_contact= trim($input['owner_contact'] ?? '');
$owner_email  = trim($input['owner_email'] ?? '');
$owner_address= trim($input['owner_address'] ?? '');
$purchase_date= $input['purchase_date'] ?? null;

$deceased_name= trim($input['deceased_name'] ?? '');
$birth_date   = $input['birth_date'] ?? null;
$death_date   = $input['death_date'] ?? null;
$burial_date  = $input['burial_date'] ?? null;
$unique_code  = trim($input['unique_code'] ?? '');

if ($plot_code === '') { json_err('plot_code is required', 422); exit; }

try {
  $pdo = pdo_conn();
  $pdo->beginTransaction();

  // Create/attach owner (optional)
  $owner_id = null;
  if ($owner_name !== '') {
    // find existing (by name+email) or insert
    $chk = $pdo->prepare("SELECT id FROM owners WHERE name=:n AND (email=:e OR :e='') LIMIT 1");
    $chk->execute([':n'=>$owner_name, ':e'=>$owner_email]);
    $owner_id = $chk->fetchColumn();

    if (!$owner_id) {
      $ins = $pdo->prepare("
        INSERT INTO owners (name, contact, email, address, purchase_date)
        VALUES (:n,:c,:e,:a,:p)
      ");
      $ins->execute([
        ':n'=>$owner_name, ':c'=>$owner_contact, ':e'=>$owner_email,
        ':a'=>$owner_address, ':p'=>$purchase_date ?: null
      ]);
      $owner_id = (int)$pdo->lastInsertId();
    }
  }

  // Insert/replace plot
  $up = $pdo->prepare("
    INSERT INTO plots (plot_code, section, lot, grave, status, reserved_for, reservation_expiry, owner_id)
    VALUES (:code,:sec,:lot,:grv,:st,:rf,:exp,:oid)
    ON DUPLICATE KEY UPDATE
      section=VALUES(section), lot=VALUES(lot), grave=VALUES(grave),
      status=VALUES(status), reserved_for=VALUES(reserved_for),
      reservation_expiry=VALUES(reservation_expiry),
      owner_id=VALUES(owner_id)
  ");
  $up->execute([
    ':code'=>$plot_code, ':sec'=>$section ?: null, ':lot'=>$lot ?: null, ':grv'=>$grave ?: null,
    ':st'=>($status ?: 'available'), ':rf'=>$res_for ?: null, ':exp'=>$expiry ?: null,
    ':oid'=>$owner_id ?: null
  ]);

  // Optional burial
  if ($deceased_name !== '') {
    $upb = $pdo->prepare("
      INSERT INTO burials (plot_code, deceased_name, birth_date, death_date, burial_date, unique_code)
      VALUES (:code,:name,:bd,:dd,:bur,:uniq)
      ON DUPLICATE KEY UPDATE
        deceased_name=VALUES(deceased_name),
        birth_date=VALUES(birth_date),
        death_date=VALUES(death_date),
        burial_date=VALUES(burial_date)
    ");
    $upb->execute([
      ':code'=>$plot_code, ':name'=>$deceased_name,
      ':bd'=>$birth_date ?: null, ':dd'=>$death_date ?: null, ':bur'=>$burial_date ?: null,
      ':uniq'=>$unique_code ?: null
    ]);
  }

  $pdo->commit();
  json_ok(['ok'=>true, 'plot_code'=>$plot_code]);
} catch (Throwable $e) {
  if ($pdo?->inTransaction()) $pdo->rollBack();
  json_err('Save failed: '.$e->getMessage(), 500);
}

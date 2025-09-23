<?php
// api/api_plot.php?id=A/101/1
require __DIR__.'/_bootstrap.php';
require __DIR__.'/api_db.php';

$code = $_GET['id'] ?? '';
if ($code === '') { json_err('Missing id', 400); exit; }

try {
  $pdo = pdo_conn();
  $stmt = $pdo->prepare("
    SELECT
      p.plot_code, p.section, p.lot, p.grave, p.status,
      p.reserved_for, p.reservation_expiry, p.notes,

      o.name        AS owner_name,
      o.contact     AS owner_contact,
      o.email       AS owner_email,
      o.address     AS owner_address,
      DATE_FORMAT(o.purchase_date, '%Y-%m-%d') AS purchase_date,

      b.deceased_name,
      DATE_FORMAT(b.birth_date,  '%Y-%m-%d') AS birth_date,
      DATE_FORMAT(b.death_date,  '%Y-%m-%d') AS death_date,
      DATE_FORMAT(b.burial_date, '%Y-%m-%d') AS burial_date,
      b.unique_code AS burial_id,

      pay.status          AS payment_status,
      pay.amount_paid,
      DATE_FORMAT(pay.next_payment_due, '%Y-%m-%d') AS next_payment_due,
      pay.plan            AS payment_plan
    FROM plots p
    LEFT JOIN owners  o  ON o.id = p.owner_id
    LEFT JOIN burials b  ON b.plot_code = p.plot_code
    LEFT JOIN payments pay ON pay.plot_code = p.plot_code
    WHERE p.plot_code = :code
    LIMIT 1
  ");
  $stmt->execute([':code'=>$code]);
  $row = $stmt->fetch() ?: [];
  if (!$row) { json_err('Not found', 404); exit; }
  json_ok($row);
} catch (Throwable $e) {
  json_err('API error: '.$e->getMessage(), 500);
}

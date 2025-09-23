<?php
require_once __DIR__ . '/_bootstrap.php';
require_once __DIR__ . '/db.php';

try {
  $stmt = $pdo->query("SELECT t.id, t.txn_id, t.customer_id, c.name AS customer_name,
                              t.deceased_name, t.plot_code, t.service_type, t.amount,
                              t.method, t.method_type, t.payment_date, t.status, t.created_at
                         FROM transactions t
                    LEFT JOIN customers c ON c.id = t.customer_id
                     ORDER BY t.created_at DESC");
  json_ok($stmt->fetchAll());
} catch (Throwable $e) {
  json_err($e->getMessage());
}

<?php
// api/api_customers.php
require __DIR__ . '/api_db.php';

$pdo = pdo_conn();

try {
  $stmt = $pdo->query("
    SELECT id, name, email, phone, address
    FROM customers
    ORDER BY id DESC
  ");
  $rows = $stmt->fetchAll();
  json_ok($rows);
} catch (Throwable $e) {
  json_err('DB error: '.$e->getMessage(), 500);
}

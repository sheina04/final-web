<?php
declare(strict_types=1); // <-- MUST be the first statement

// api/api_customer.php?id=123
require __DIR__ . '/api_db.php';

$pdo = pdo_conn();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) { json_err('Invalid id', 422); exit; }

try {
  $stmt = $pdo->prepare("
    SELECT id, name, email, phone, address
    FROM customers
    WHERE id = :id
    LIMIT 1
  ");
  $stmt->execute([':id' => $id]);
  $row = $stmt->fetch();
  if (!$row) { json_err('Not found', 404); exit; }
  json_ok($row);
} catch (Throwable $e) {
  json_err('DB error: '.$e->getMessage(), 500);
}

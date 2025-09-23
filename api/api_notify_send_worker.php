<?php
// /api/api_notify_send_worker.php
require __DIR__.'/_bootstrap.php';
require __DIR__.'/api_db.php';

try {
  if ($_SERVER['REQUEST_METHOD'] !== 'POST') { json_err('POST only', 405); exit; }

  $payload = json_decode(file_get_contents('php://input'), true) ?: $_POST;
  $id = isset($payload['id']) ? (int)$payload['id'] : 0;
  if ($id <= 0) { json_err('Invalid id', 422); exit; }

  $pdo = pdo_conn();

  // pretend we sent an email/SMS successfully
  $st = $pdo->prepare("UPDATE notification_queue SET status='sent', sent_at=NOW(), error_msg=NULL WHERE id=:id");
  $st->execute([':id'=>$id]);

  json_ok(['ok'=>true, 'id'=>$id]);
} catch (Throwable $e) {
  json_err('Send error: '.$e->getMessage(), 500);
}

<?php
// final web/api/notify_daily_cron.php
require_once __DIR__.'/api_bootstrap.php';
require_once __DIR__.'/api_db.php';

try {
  // In this simple setup, nothing to update — the sender will pick where send_on <= NOW().
  // We just report how many are ready.
  $count = (int)$pdo->query("
     SELECT COUNT(*) FROM notification_queue 
     WHERE status='queued' AND send_on <= NOW()
  ")->fetchColumn();

  json_ok(['ready_to_send'=>$count]);
} catch (Throwable $e) {
  json_err('Cron error: '.$e->getMessage(), 500);
}

<?php
// final web/api/api_notifications_stats.php
require_once __DIR__.'/api_bootstrap.php';
require_once __DIR__.'/api_db.php';

try {
  $total = (int)$pdo->query("SELECT COUNT(*) FROM notification_queue")->fetchColumn();
  $sentToday = (int)$pdo->query("SELECT COUNT(*) FROM notification_queue WHERE DATE(sent_at)=CURDATE()")->fetchColumn();
  $pending = (int)$pdo->query("SELECT COUNT(*) FROM notification_queue WHERE status IN ('queued')")->fetchColumn();
  // urgent = renewals with <=3 days left
  $urgent = (int)$pdo->query("
    SELECT COUNT(*) 
    FROM payments 
    WHERE next_payment_due IS NOT NULL 
      AND DATEDIFF(next_payment_due, CURDATE()) <= 3
  ")->fetchColumn();

  json_ok([
    'total' => $total,
    'sent_today' => $sentToday,
    'pending' => $pending,
    'urgent' => $urgent
  ]);
} catch (Throwable $e) {
  json_err('DB error: '.$e->getMessage(), 500);
}

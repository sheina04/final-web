<?php
// /api/api_notifications_renewal.php
require __DIR__.'/_bootstrap.php';
require __DIR__.'/api_db.php';

try {
  $pdo = pdo_conn();

  $sql = "
    SELECT
      COALESCE(o.name,'')                 AS customer,
      p.plot_code                         AS plot,
      pay.next_payment_due                AS expiry,
      DATEDIFF(pay.next_payment_due, CURDATE()) AS days_left,
      pay.status,
      (
        SELECT MAX(q.sent_at)
        FROM notification_queue q
        WHERE q.plot_code = p.plot_code
          AND q.rule_type = 'RENEWAL'
      ) AS sent_at,
      p.plot_code                         AS id
    FROM payments pay
    JOIN plots p       ON p.plot_code = pay.plot_code
    LEFT JOIN owners o ON o.id = p.owner_id
    WHERE pay.next_payment_due IS NOT NULL
    ORDER BY pay.next_payment_due ASC
  ";
  $rows = $pdo->query($sql)->fetchAll() ?: [];
  foreach ($rows as &$r) {
    $r['expiry']   = $r['expiry'] ? date('Y-m-d', strtotime($r['expiry'])) : null;
    $r['days_left']= is_null($r['days_left']) ? null : (int)$r['days_left'];
    $r['sent_at']  = $r['sent_at'] ? date('Y-m-d H:i:s', strtotime($r['sent_at'])) : null;
  }
  json_ok($rows);
} catch (Throwable $e) {
  json_err('API error: '.$e->getMessage(), 500);
}

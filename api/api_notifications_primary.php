<?php
// /api/api_notifications_primary.php
require __DIR__.'/_bootstrap.php';
require __DIR__.'/api_db.php';

try {
  $pdo = pdo_conn();

  $sql = "
    SELECT
      q.id,
      q.rule_type           AS type,
      q.recipient_name      AS recipient,
      COALESCE(o.contact, JSON_UNQUOTE(JSON_EXTRACT(q.payload_json,'$.contact')), '') AS contact,
      q.status,
      q.sent_at
    FROM notification_queue q
    LEFT JOIN owners o
      ON o.email = q.recipient_email
    ORDER BY COALESCE(q.sent_at, q.created_at) DESC
    LIMIT 100
  ";
  $rows = $pdo->query($sql)->fetchAll() ?: [];
  // Normalize for UI
  foreach ($rows as &$r) {
    $r['type']    = $r['type'] ?? '';
    $r['contact'] = $r['contact'] ?? '';
    $r['sent_at'] = $r['sent_at'] ? date('Y-m-d H:i:s', strtotime($r['sent_at'])) : null;
  }
  json_ok($rows);
} catch (Throwable $e) {
  json_err('API error: '.$e->getMessage(), 500);
}

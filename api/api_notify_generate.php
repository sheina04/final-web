<?php
require_once __DIR__ . '/_bootstrap.php';
require_once __DIR__ . '/db.php';

$mode = $_GET['mode'] ?? 'today';

try {
  // Example: generate renewal reminders
  $stmt = $pdo->query("SELECT pay.plot_code, pay.next_payment_due, o.name, o.email
                         FROM payments pay
                   INNER JOIN plots p ON pay.plot_code = p.plot_code
                   INNER JOIN owners o ON p.owner_id = o.id
                        WHERE pay.next_payment_due IS NOT NULL");
  $rows = $stmt->fetchAll();

  foreach ($rows as $r) {
    $sendDate = date('Y-m-d H:i:s', strtotime($r['next_payment_due'] . " -30 days"));
    $pdo->prepare("INSERT IGNORE INTO notification_queue
                     (rule_type, template_code, recipient_name, recipient_email,
                      plot_code, deceased_name, event_date, send_on)
                   VALUES
                     ('RENEWAL','TPL_RENEWAL',:name,:email,:plot,NULL,:due,:send)")
        ->execute([
          ':name'  => $r['name'],
          ':email' => $r['email'],
          ':plot'  => $r['plot_code'],
          ':due'   => $r['next_payment_due'],
          ':send'  => $sendDate
        ]);
  }

  json_ok(['generated' => count($rows)]);
} catch (Throwable $e) {
  json_err($e->getMessage());
}

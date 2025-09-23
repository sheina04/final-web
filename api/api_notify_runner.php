<?php
require __DIR__.'/api_bootstrap.php';
require __DIR__.'/api_db.php';

$st = $pdo->query("
  SELECT q.*, t.subject, t.body
  FROM notification_queue q
  JOIN email_templates t ON t.code=q.template_code
  WHERE q.status='queued' AND q.send_on <= NOW()
  ORDER BY q.id ASC
  LIMIT 50
");
$rows = $st->fetchAll();

function fill_tpl($tpl, $r){
  return strtr($tpl, [
    '{{owner_name}}'    => $r['recipient_name'] ?? '',
    '{{deceased_name}}' => $r['deceased_name'] ?? '',
    '{{plot_code}}'     => $r['plot_code'] ?? '',
    '{{event_date}}'    => $r['event_date'] ?? '',
  ]);
}

// TODO: replace with PHPMailer/SMTP
function send_mail_dummy($to,$subj,$body){
  return filter_var($to, FILTER_VALIDATE_EMAIL) ? true : false;
}

$ok=0; $fail=0;
foreach($rows as $r){
  $subject = fill_tpl($r['subject'], $r);
  $body    = fill_tpl($r['body'], $r);
  if (send_mail_dummy($r['recipient_email'], $subject, $body)) {
    $pdo->prepare("UPDATE notification_queue SET status='sent', sent_at=NOW() WHERE id=?")->execute([$r['id']]);
    $ok++;
  } else {
    $pdo->prepare("UPDATE notification_queue SET status='failed', error_msg=? WHERE id=?")->execute(['SEND_FAILED',$r['id']]);
    $fail++;
  }
}

json_ok(['ok'=>true,'sent'=>$ok,'failed'=>$fail]); exit;

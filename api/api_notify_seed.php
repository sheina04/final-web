<?php
require __DIR__.'/api_bootstrap.php';
require __DIR__.'/api_db.php';

/*
 Seeds notification_queue based on rules:
  - RENEWAL: payments.next_payment_due - days_before == today
  - BIRTHDAY / DEATH_ANNIV / BURIAL_ANNIV: month-day match; send_on = event - days_before @ 08:00
  - ALL_SOULS: Nov 2; send_on = Nov 2 - days_before @ 08:00
*/

$today = new DateTime('today');
$y = (int)$today->format('Y');

function upsert_queue(PDO $pdo, array $rows): int {
  if(!$rows) return 0;
  $sql = "INSERT IGNORE INTO notification_queue
    (rule_type, template_code, recipient_name, recipient_email, plot_code, deceased_name, event_date, send_on, status, payload_json)
    VALUES (:rule_type,:template_code,:recipient_name,:recipient_email,:plot_code,:deceased_name,:event_date,:send_on,'queued',:payload_json)";
  $st = $pdo->prepare($sql);
  $n=0;
  foreach($rows as $r){ $st->execute($r); $n += $st->rowCount(); }
  return $n;
}

$rules = $pdo->query("SELECT * FROM notification_rules WHERE is_active=1")->fetchAll();
$byType = [];
foreach($rules as $r){ $byType[$r['rule_type']] = $r; }

$inserted = 0;

/* RENEWAL */
if(isset($byType['RENEWAL'])){
  $days = (int)$byType['RENEWAL']['days_before'];
  $target = (clone $today)->modify("+{$days} days")->format('Y-m-d');
  $q = $pdo->prepare("
    SELECT p.plot_code, pay.next_payment_due AS event_dt,
           o.name AS owner_name, o.email AS owner_email,
           (SELECT deceased_name FROM burials b WHERE b.plot_code=p.plot_code ORDER BY b.id DESC LIMIT 1) AS deceased_name
    FROM payments pay
    JOIN plots p ON p.plot_code=pay.plot_code
    LEFT JOIN owners o ON o.id=p.owner_id
    WHERE pay.next_payment_due = :target
  ");
  $q->execute([':target'=>$target]);
  $rows=[];
  foreach($q as $r){
    if(empty($r['owner_email'])) continue;
    $sendOn = (new DateTime($r['event_dt']))->modify("-{$days} days")->setTime(8,0,0);
    $rows[] = [
      ':rule_type'=>'RENEWAL',
      ':template_code'=>$byType['RENEWAL']['template_code'],
      ':recipient_name'=>$r['owner_name'] ?: 'Customer',
      ':recipient_email'=>$r['owner_email'],
      ':plot_code'=>$r['plot_code'],
      ':deceased_name'=>$r['deceased_name'] ?: '',
      ':event_date'=>$r['event_dt'],
      ':send_on'=>$sendOn->format('Y-m-d H:i:s'),
      ':payload_json'=>json_encode(['owner_name'=>$r['owner_name'],'plot_code'=>$r['plot_code']])
    ];
  }
  $inserted += upsert_queue($pdo,$rows);
}

/* Helper for anniv */
function anniv_rows(PDO $pdo, string $rule, string $col, array $byType, DateTime $today, int $y){
  $days = (int)$byType[$rule]['days_before'];
  $st = $pdo->query("
    SELECT b.deceased_name, b.$col AS base_date, p.plot_code, o.name AS owner_name, o.email AS owner_email
    FROM burials b
    JOIN plots p ON p.plot_code=b.plot_code
    LEFT JOIN owners o ON o.id=p.owner_id
    WHERE b.$col IS NOT NULL
  ");
  $rows=[];
  foreach($st as $r){
    if(empty($r['owner_email'])) continue;
    $base = new DateTime($r['base_date']);
    $event = new DateTime($y.'-'.$base->format('m-d'));
    $sendOn = (clone $event)->modify("-{$days} days")->setTime(8,0,0);
    if($sendOn->format('Y-m-d') !== $today->format('Y-m-d')) continue;
    $rows[] = [
      ':rule_type'=>$rule,
      ':template_code'=>$byType[$rule]['template_code'],
      ':recipient_name'=>$r['owner_name'] ?: 'Customer',
      ':recipient_email'=>$r['owner_email'],
      ':plot_code'=>$r['plot_code'],
      ':deceased_name'=>$r['deceased_name'],
      ':event_date'=>$event->format('Y-m-d'),
      ':send_on'=>$sendOn->format('Y-m-d H:i:s'),
      ':payload_json'=>json_encode(['owner_name'=>$r['owner_name'],'plot_code'=>$r['plot_code']])
    ];
  }
  return $rows;
}

/* BIRTHDAY / DEATH_ANNIV / BURIAL_ANNIV */
foreach ([['BIRTHDAY','birth_date'], ['DEATH_ANNIV','death_date'], ['BURIAL_ANNIV','burial_date']] as [$rt,$col]) {
  if(isset($byType[$rt])) $inserted += upsert_queue($pdo, anniv_rows($pdo,$rt,$col,$byType,$today,$y));
}

/* ALL_SOULS */
if(isset($byType['ALL_SOULS'])){
  $days = (int)$byType['ALL_SOULS']['days_before'];
  $nov2 = new DateTime("$y-11-02");
  $sendOn = (clone $nov2)->modify("-{$days} days")->setTime(8,0,0);
  if($sendOn->format('Y-m-d') === $today->format('Y-m-d')){
    $st = $pdo->query("
      SELECT DISTINCT o.name AS owner_name, o.email AS owner_email, p.plot_code,
             (SELECT deceased_name FROM burials b WHERE b.plot_code=p.plot_code ORDER BY b.id DESC LIMIT 1) AS deceased_name
      FROM plots p
      LEFT JOIN owners o ON o.id=p.owner_id
      WHERE o.email IS NOT NULL AND o.email <> ''
    ");
    $rows=[];
    foreach($st as $r){
      $rows[] = [
        ':rule_type'=>'ALL_SOULS',
        ':template_code'=>$byType['ALL_SOULS']['template_code'],
        ':recipient_name'=>$r['owner_name'] ?: 'Customer',
        ':recipient_email'=>$r['owner_email'],
        ':plot_code'=>$r['plot_code'],
        ':deceased_name'=>$r['deceased_name'] ?: '',
        ':event_date'=>$nov2->format('Y-m-d'),
        ':send_on'=>$sendOn->format('Y-m-d H:i:s'),
        ':payload_json'=>json_encode(['owner_name'=>$r['owner_name'],'plot_code'=>$r['plot_code']])
      ];
    }
    $inserted += upsert_queue($pdo,$rows);
  }
}

json_ok(['ok'=>true,'inserted'=>$inserted,'date'=>$today->format('Y-m-d')]); exit;

<?php
// api/notify_cron.php
require_once __DIR__ . '/api_bootstrap.php';
require_once __DIR__ . '/api_db.php'; // must provide $pdo (PDO MySQL)

// ---- small helpers ----
function today() { return (new DateTimeImmutable('today'))->format('Y-m-d'); }
function dmy($d) { return (new DateTimeImmutable($d))->format('Y-m-d'); }
function safe_int($x,$def=0){ return is_numeric($x)?(int)$x:$def; }

try {
  $windowDays = safe_int($_GET['window'] ?? 60, 60);   // how far to look ahead
  $now = new DateTimeImmutable('now');
  $today = new DateTimeImmutable('today');
  $upper = $today->modify("+{$windowDays} days");

  // load active rules
  $rules = $pdo->query("SELECT rule_type, template_code, days_before
                        FROM notification_rules WHERE is_active=1")->fetchAll(PDO::FETCH_ASSOC);

  // prep stmt for insert (idempotent via UNIQUE surrogate columns in your schema)
  $ins = $pdo->prepare("
    INSERT IGNORE INTO notification_queue
      (rule_type, template_code, recipient_name, recipient_email, plot_code, deceased_name,
       event_date, send_on, sent_on_date, plot_code_norm, event_date_norm, status, payload_json)
    VALUES
      (:rule_type, :template_code, :recipient_name, :recipient_email, :plot_code, :deceased_name,
       :event_date, :send_on, :sent_on_date, :plot_code_norm, :event_date_norm, 'queued', :payload_json)
  ");

  $queued = 0;

  foreach ($rules as $r) {
    $type = $r['rule_type'];
    $tpl  = $r['template_code'];
    $days = (int)$r['days_before'];

    // === RENEWAL: from payments.next_payment_due + owners (recipient) + plots
    if ($type === 'RENEWAL') {
      $q = $pdo->prepare("
        SELECT p.plot_code, o.name AS owner_name, o.email AS owner_email, pay.next_payment_due AS due_date
        FROM payments pay
        JOIN plots p  ON p.plot_code = pay.plot_code
        JOIN owners o ON o.id = p.owner_id OR o.id = p.owner_id OR p.owner_id = o.id
        WHERE pay.next_payment_due IS NOT NULL
          AND pay.next_payment_due BETWEEN :from AND :to
      ");
      $q->execute([':from'=>$today->format('Y-m-d'), ':to'=>$upper->format('Y-m-d')]);

      while ($row = $q->fetch(PDO::FETCH_ASSOC)) {
        if (empty($row['owner_email'])) continue; // skip if no email
        $event   = new DateTimeImmutable($row['due_date']);
        $sendOn  = $event->modify("-{$days} days")->setTime(8,0,0);
        if ($sendOn < $now) $sendOn = $now->modify('+1 minute'); // late? send asap

        $payload = [
          'event' => 'renewal',
          'plot_code' => $row['plot_code'],
          'event_date' => $event->format('Y-m-d'),
          'days_before' => $days
        ];

        $ok = $ins->execute([
          ':rule_type'      => 'RENEWAL',
          ':template_code'  => $tpl,
          ':recipient_name' => $row['owner_name'],
          ':recipient_email'=> $row['owner_email'],
          ':plot_code'      => $row['plot_code'],
          ':deceased_name'  => null,
          ':event_date'     => $event->format('Y-m-d'),
          ':send_on'        => $sendOn->format('Y-m-d H:i:s'),
          ':sent_on_date'   => $sendOn->format('Y-m-d'),
          ':plot_code_norm' => $row['plot_code'] ?: '',
          ':event_date_norm'=> $event->format('Y-m-d'),
          ':payload_json'   => json_encode($payload, JSON_UNESCAPED_UNICODE),
        ]);
        if ($ok && $ins->rowCount() > 0) $queued++;
      }
    }

    // === BIRTHDAY / DEATH_ANNIV / BURIAL_ANNIV from burials table
    if (in_array($type, ['BIRTHDAY','DEATH_ANNIV','BURIAL_ANNIV'], true)) {
      // choose which date column to use
      $col = $type==='BIRTHDAY' ? 'birth_date' : ($type==='DEATH_ANNIV' ? 'death_date' : 'burial_date');

      $q = $pdo->prepare("
        SELECT b.deceased_name, b.plot_code, b.$col AS base_date,
               o.name AS owner_name, o.email AS owner_email, p.owner_id
        FROM burials b
        JOIN plots p  ON p.plot_code = b.plot_code
        LEFT JOIN owners o ON o.id = p.owner_id
        WHERE b.$col IS NOT NULL
      ");
      $q->execute();

      while ($row = $q->fetch(PDO::FETCH_ASSOC)) {
        if (empty($row['base_date']) || empty($row['owner_email'])) continue;

        // Compute the upcoming anniversary date within [today, upper]
        $base = new DateTimeImmutable($row['base_date']);
        $year = (int)$today->format('Y');
        $anniv = $base->setDate($year, (int)$base->format('m'), (int)$base->format('d'));
        if ($anniv < $today) $anniv = $anniv->modify('+1 year');
        if ($anniv > $upper) continue;

        $sendOn = $anniv->modify("-{$days} days")->setTime(8,0,0);
        if ($sendOn < $now) $sendOn = $now->modify('+1 minute');

        $payload = [
          'event' => strtolower($type),
          'plot_code' => $row['plot_code'],
          'deceased_name' => $row['deceased_name'],
          'event_date' => $anniv->format('Y-m-d'),
          'days_before' => $days
        ];

        $ok = $ins->execute([
          ':rule_type'      => $type,
          ':template_code'  => $tpl,
          ':recipient_name' => $row['owner_name'] ?: 'Owner',
          ':recipient_email'=> $row['owner_email'],
          ':plot_code'      => $row['plot_code'],
          ':deceased_name'  => $row['deceased_name'],
          ':event_date'     => $anniv->format('Y-m-d'),
          ':send_on'        => $sendOn->format('Y-m-d H:i:s'),
          ':sent_on_date'   => $sendOn->format('Y-m-d'),
          ':plot_code_norm' => $row['plot_code'] ?: '',
          ':event_date_norm'=> $anniv->format('Y-m-d'),
          ':payload_json'   => json_encode($payload, JSON_UNESCAPED_UNICODE),
        ]);
        if ($ok && $ins->rowCount() > 0) $queued++;
      }
    }

    // === ALL_SOULS: Nov 2 every year for all owners with a burial
    if ($type === 'ALL_SOULS') {
      $year = (int)$today->format('Y');
      $allsouls = (new DateTimeImmutable("$year-11-02"))->setTime(9,0,0);
      if ($allsouls < $today) $allsouls = $allsouls->modify('+1 year');
      if ($allsouls > $upper) {
        // outside window — skip for now
      } else {
        $sendOn = $allsouls->modify("-{$days} days")->setTime(8,0,0);
        if ($sendOn < $now) $sendOn = $now->modify('+1 minute');

        // target owners that have at least one burial
        $q = $pdo->query("
          SELECT DISTINCT o.name AS owner_name, o.email AS owner_email, p.plot_code, b.deceased_name
          FROM plots p
          JOIN owners o ON o.id = p.owner_id
          JOIN burials b ON b.plot_code = p.plot_code
          WHERE o.email IS NOT NULL AND o.email <> ''
        ");
        while ($row = $q->fetch(PDO::FETCH_ASSOC)) {
          if (empty($row['owner_email'])) continue;
          $payload = [
            'event' => 'all_souls',
            'plot_code' => $row['plot_code'],
            'deceased_name' => $row['deceased_name'],
            'event_date' => $allsouls->format('Y-m-d'),
            'days_before' => $days
          ];
          $ok = $ins->execute([
            ':rule_type'      => 'ALL_SOULS',
            ':template_code'  => $tpl,
            ':recipient_name' => $row['owner_name'],
            ':recipient_email'=> $row['owner_email'],
            ':plot_code'      => $row['plot_code'],
            ':deceased_name'  => $row['deceased_name'],
            ':event_date'     => $allsouls->format('Y-m-d'),
            ':send_on'        => $sendOn->format('Y-m-d H:i:s'),
            ':sent_on_date'   => $sendOn->format('Y-m-d'),
            ':plot_code_norm' => $row['plot_code'] ?: '',
            ':event_date_norm'=> $allsouls->format('Y-m-d'),
            ':payload_json'   => json_encode($payload, JSON_UNESCAPED_UNICODE),
          ]);
          if ($ok && $ins->rowCount() > 0) $queued++;
        }
      }
    }
  }

  json_ok(['ok'=>true, 'queued_now'=>$queued, 'window_days'=>$windowDays]);
} catch (Throwable $e) {
  json_err($e->getMessage(), 500);
}

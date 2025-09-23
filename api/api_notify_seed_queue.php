<?php
// /api/api_notify_seed_queue.php
require __DIR__.'/_bootstrap.php';
require __DIR__.'/api_db.php';

function upsert($pdo,$sql,$params){ $st=$pdo->prepare($sql); $st->execute($params); }

try {
  $pdo = pdo_conn();
  $pdo->beginTransaction();

  // Load rules into an array: rule_type => [template_code, days_before]
  $rules = [];
  $st = $pdo->query("SELECT rule_type, template_code, days_before FROM notification_rules WHERE is_active=1");
  foreach ($st->fetchAll() as $r) $rules[$r['rule_type']] = $r;

  // === RENEWAL ===
  if (!empty($rules['RENEWAL'])) {
    $r = $rules['RENEWAL'];
    $sql = "
      INSERT IGNORE INTO notification_queue
        (rule_type, template_code, recipient_name, recipient_email, plot_code, deceased_name, event_date, send_on, status, payload_json)
      SELECT
        'RENEWAL',
        :tpl,
        COALESCE(o.name,'')                                   AS recipient_name,
        COALESCE(o.email,'')                                  AS recipient_email,
        p.plot_code,
        b.deceased_name,
        pay.next_payment_due                                  AS event_date,
        DATE_SUB(pay.next_payment_due, INTERVAL :d DAY)       AS send_on,
        'queued',
        JSON_OBJECT('contact', o.contact)
      FROM payments pay
      JOIN plots p ON p.plot_code = pay.plot_code
      LEFT JOIN owners o ON o.id = p.owner_id
      LEFT JOIN burials b ON b.plot_code = p.plot_code
      WHERE pay.next_payment_due IS NOT NULL
    ";
    upsert($pdo, $sql, [':tpl'=>$r['template_code'], ':d'=>$r['days_before']]);
  }

  // Helper to compute next YYYY-mm-dd from a stored date (same month-day)
  $nextDateSQL = function($col){
    return "DATE_FORMAT(
              IF(
                STR_TO_DATE(CONCAT(YEAR(CURDATE()), DATE_FORMAT($col,'-%m-%d')), '%Y-%m-%d') >= CURDATE(),
                STR_TO_DATE(CONCAT(YEAR(CURDATE()), DATE_FORMAT($col,'-%m-%d')), '%Y-%m-%d'),
                STR_TO_DATE(CONCAT(YEAR(CURDATE())+1, DATE_FORMAT($col,'-%m-%d')), '%Y-%m-%d')
              ),
              '%Y-%m-%d'
            )";
  };

  // === BIRTHDAY / DEATH_ANNIV / BURIAL_ANNIV ===
  $map = [
    'BIRTHDAY'     => ['col'=>'birth_date',  'tpl'=>'TPL_BIRTHDAY'],
    'DEATH_ANNIV'  => ['col'=>'death_date',  'tpl'=>'TPL_DEATH_ANNIV'],
    'BURIAL_ANNIV' => ['col'=>'burial_date', 'tpl'=>'TPL_BURIAL_ANNIV'],
  ];
  foreach ($map as $ruleType => $def) {
    if (empty($rules[$ruleType])) continue;
    $r = $rules[$ruleType];
    $col = $def['col'];
    $nx  = $nextDateSQL($col);
    $sql = "
      INSERT IGNORE INTO notification_queue
        (rule_type, template_code, recipient_name, recipient_email, plot_code, deceased_name, event_date, send_on, status, payload_json)
      SELECT
        '$ruleType',
        :tpl,
        COALESCE(o.name,'')                       AS recipient_name,
        COALESCE(o.email,'')                      AS recipient_email,
        b.plot_code,
        b.deceased_name,
        $nx                                      AS event_date,
        DATE_SUB($nx, INTERVAL :d DAY)           AS send_on,
        'queued',
        JSON_OBJECT('contact', o.contact)
      FROM burials b
      LEFT JOIN plots p  ON p.plot_code = b.plot_code
      LEFT JOIN owners o ON o.id = p.owner_id
      WHERE b.$col IS NOT NULL
    ";
    upsert($pdo, $sql, [':tpl'=>$r['template_code'], ':d'=>$r['days_before']]);
  }

  // === ALL_SOULS === (Nov 2)
  if (!empty($rules['ALL_SOULS'])) {
    $r = $rules['ALL_SOULS'];
    $sql = "
      INSERT IGNORE INTO notification_queue
        (rule_type, template_code, recipient_name, recipient_email, plot_code, deceased_name, event_date, send_on, status, payload_json)
      SELECT
        'ALL_SOULS',
        :tpl,
        COALESCE(o.name,'')                           AS recipient_name,
        COALESCE(o.email,'')                          AS recipient_email,
        b.plot_code,
        b.deceased_name,
        IF(
          STR_TO_DATE(CONCAT(YEAR(CURDATE()),'-11-02'), '%Y-%m-%d') >= CURDATE(),
          STR_TO_DATE(CONCAT(YEAR(CURDATE()),'-11-02'), '%Y-%m-%d'),
          STR_TO_DATE(CONCAT(YEAR(CURDATE())+1,'-11-02'), '%Y-%m-%d')
        ) AS event_date,
        DATE_SUB(
          IF(
            STR_TO_DATE(CONCAT(YEAR(CURDATE()),'-11-02'), '%Y-%m-%d') >= CURDATE(),
            STR_TO_DATE(CONCAT(YEAR(CURDATE()),'-11-02'), '%Y-%m-%d'),
            STR_TO_DATE(CONCAT(YEAR(CURDATE())+1,'-11-02'), '%Y-%m-%d')
          ),
          INTERVAL :d DAY
        ) AS send_on,
        'queued',
        JSON_OBJECT('contact', o.contact)
      FROM burials b
      LEFT JOIN plots p  ON p.plot_code = b.plot_code
      LEFT JOIN owners o ON o.id = p.owner_id
    ";
    upsert($pdo, $sql, [':tpl'=>$r['template_code'], ':d'=>$r['days_before']]);
  }

  $pdo->commit();
  json_ok(['ok'=>true, 'message'=>'Queue seeded/updated']);
} catch (Throwable $e) {
  if ($pdo && $pdo->inTransaction()) $pdo->rollBack();
  json_err('Seed error: '.$e->getMessage(), 500);
}

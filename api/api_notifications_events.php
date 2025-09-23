<?php
// /api/api_notifications_events.php
require __DIR__.'/_bootstrap.php';
require __DIR__.'/api_db.php';

function next_yyyymmdd_for_monthday(?string $origDate): ?string {
  if (!$origDate) return null;
  $md = date('m-d', strtotime($origDate));
  $y  = (int)date('Y');
  $thisYear = "$y-$md";
  if (strtotime($thisYear) >= strtotime('today')) return $thisYear;
  return ($y+1)."-".$md;
}

try {
  $pdo = pdo_conn();

  $sql = "
    SELECT
      b.id            AS burial_id,
      b.deceased_name AS deceased,
      b.birth_date,
      b.death_date,
      b.burial_date,
      b.plot_code,
      COALESCE(o.name,'')   AS contact_name,
      COALESCE(o.contact,'')AS contact_phone
    FROM burials b
    LEFT JOIN plots p  ON p.plot_code = b.plot_code
    LEFT JOIN owners o ON o.id = p.owner_id
    ORDER BY b.deceased_name
  ";
  $rows = $pdo->query($sql)->fetchAll() ?: [];
  $out = [];

  foreach ($rows as $r) {
    // Birthday
    $nb = next_yyyymmdd_for_monthday($r['birth_date']);
    if ($nb) {
      $out[] = [
        'id'            => 'BIRTHDAY-'.$r['burial_id'],
        'deceased'      => $r['deceased'],
        'occasion'      => 'Birthday',
        'plot'          => $r['plot_code'],
        'contact_name'  => $r['contact_name'],
        'contact_phone' => $r['contact_phone'],
        'renewal_due'   => $nb,
        'status'        => 'queued',
      ];
    }
    // Death Anniv
    $nd = next_yyyymmdd_for_monthday($r['death_date']);
    if ($nd) {
      $out[] = [
        'id'            => 'DEATH-'.$r['burial_id'],
        'deceased'      => $r['deceased'],
        'occasion'      => 'Death Anniversary',
        'plot'          => $r['plot_code'],
        'contact_name'  => $r['contact_name'],
        'contact_phone' => $r['contact_phone'],
        'renewal_due'   => $nd,
        'status'        => 'queued',
      ];
    }
    // Burial Anniv
    $nbu = next_yyyymmdd_for_monthday($r['burial_date']);
    if ($nbu) {
      $out[] = [
        'id'            => 'BURIAL-'.$r['burial_id'],
        'deceased'      => $r['deceased'],
        'occasion'      => 'Burial Anniversary',
        'plot'          => $r['plot_code'],
        'contact_name'  => $r['contact_name'],
        'contact_phone' => $r['contact_phone'],
        'renewal_due'   => $nbu,
        'status'        => 'queued',
      ];
    }
  }

  // (optional) show only events close to today
  $windowDays = 30;
  $today = strtotime('today');
  $filtered = array_values(array_filter($out, function($e) use ($today,$windowDays){
    $d = strtotime($e['renewal_due']);
    $diff = (int)round(($d - $today)/86400);
    return abs($diff) <= $windowDays;
  }));

  json_ok($filtered);
} catch (Throwable $e) {
  json_err('API error: '.$e->getMessage(), 500);
}

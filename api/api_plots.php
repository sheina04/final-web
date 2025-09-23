<?php
// api/api_plots.php
require __DIR__.'/_bootstrap.php';
require __DIR__.'/api_db.php';

try {
  $pdo = pdo_conn();
  // One row per plot (show owner & one burial name if exists)
  $sql = "
    SELECT
      p.plot_code,
      p.status,
      o.name     AS owner_name,
      b.deceased_name
    FROM plots p
    LEFT JOIN owners  o ON o.id = p.owner_id
    LEFT JOIN burials b ON b.plot_code = p.plot_code
    ORDER BY p.plot_code ASC
  ";
  $rows = $pdo->query($sql)->fetchAll() ?: [];
  json_ok($rows);
} catch (Throwable $e) {
  json_err('API error: '.$e->getMessage(), 500);
}

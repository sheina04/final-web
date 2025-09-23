<?php
// api/api_map_plots.php
require __DIR__.'/_bootstrap.php';
require __DIR__.'/api_db.php';

try {
  $pdo = pdo_conn();
  $sql = "
    SELECT
      p.plot_code, p.section, p.lot, p.grave, p.status,
      o.name AS owner_name,
      b.deceased_name,
      b.unique_code AS burial_id
    FROM plots p
    LEFT JOIN owners  o ON o.id = p.owner_id
    LEFT JOIN burials b ON b.plot_code = p.plot_code
    ORDER BY p.section, p.lot, p.grave
  ";
  $rows = $pdo->query($sql)->fetchAll() ?: [];
  json_ok($rows);
} catch (Throwable $e) {
  json_err('API error: '.$e->getMessage(), 500);
}

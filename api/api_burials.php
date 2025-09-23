<?php
// api/api_burials.php
require __DIR__.'/_bootstrap.php';
require __DIR__.'/api_db.php';

try {
  $pdo = pdo_conn();
  $sql = "
    SELECT
      b.id, b.deceased_name, b.plot_code, b.unique_code,
      DATE_FORMAT(b.death_date,'%Y-%m-%d')  AS death_date,
      DATE_FORMAT(b.burial_date,'%Y-%m-%d') AS burial_date
    FROM burials b
    ORDER BY b.burial_date DESC, b.id DESC
    LIMIT 50
  ";
  $rows = $pdo->query($sql)->fetchAll() ?: [];
  json_ok($rows);
} catch (Throwable $e) {
  json_err('API error: '.$e->getMessage(), 500);
}

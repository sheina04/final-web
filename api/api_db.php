<?php
if (!defined('DB_HOST'))    define('DB_HOST','127.0.0.1');
if (!defined('DB_PORT'))    define('DB_PORT','3306');
if (!defined('DB_NAME'))    define('DB_NAME','rest_assured');
if (!defined('DB_USER'))    define('DB_USER','root');
if (!defined('DB_PASS'))    define('DB_PASS','Bag-ongStrongPass!123'); // adjust if needed
if (!defined('DB_CHARSET')) define('DB_CHARSET','utf8mb4');

require_once __DIR__.'/_bootstrap.php';

function pdo_conn() {
  static $pdo;
  if ($pdo) return $pdo;
  try {
    $pdo = new PDO(
      "mysql:host=".DB_HOST.";port=".DB_PORT.";dbname=".DB_NAME.";charset=".DB_CHARSET,
      DB_USER, DB_PASS,
      [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      ]
    );
    return $pdo;
  } catch (Throwable $e) {
    json_err('DB connect failed: '.$e->getMessage(), 500);
    exit;
  }
}

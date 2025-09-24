<?php
// Common headers (CORS for local dev)
$origin = $_SERVER['HTTP_ORIGIN'] ?? '';
if ($origin) { header("Access-Control-Allow-Origin: $origin"); header("Vary: Origin"); }
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(204); exit; }

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');

// 🔒 EDIT THIS ONLY IF YOUR DB CREDENTIALS DIFFER
$DB_HOST = '127.0.0.1';
$DB_NAME = 'rest_assured';
$DB_USER = 'root';
$DB_PASS = 'Bag-ongStrongPass!123';

try {
  $pdo = new PDO(
    "mysql:host=$DB_HOST;dbname=$DB_NAME;charset=utf8mb4",
    $DB_USER, $DB_PASS,
    [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]
  );
} catch (Throwable $e) {
  http_response_code(500);
  echo json_encode(['error'=>'DB connection failed','detail'=>$e->getMessage()]);
  exit;
}

function json_ok($data){ echo json_encode($data, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES); exit; }
function json_err($code,$msg){ http_response_code($code); echo json_encode(['error'=>$msg]); exit; }

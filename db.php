<?php
// db.php
function db(): PDO {
  static $pdo = null;
  if ($pdo) return $pdo;

  // DEFAULT (XAMPP/WAMP)
  $dsn  = 'mysql:host=127.0.0.1;dbname=rest_assured;charset=utf8mb4';
  $user = 'root';
  $pass = 'Janelle12345';

  // ---- If MAMP (MySQL usually port 8889), uncomment:
  // $dsn  = 'mysql:host=127.0.0.1;port=8889;dbname=rest_assured;charset=utf8mb4';
  // $user = 'root';
  // $pass = 'root';

  $pdo = new PDO($dsn, $user, $pass, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  ]);
  return $pdo;
}

function h(?string $s): string {
  return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');
}

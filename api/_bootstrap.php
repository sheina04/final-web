<?php
header('Content-Type: application/json; charset=utf-8');
$origin = $_SERVER['HTTP_ORIGIN'] ?? '';
if ($origin) { header("Access-Control-Allow-Origin: $origin"); header("Vary: Origin"); }
else { header("Access-Control-Allow-Origin: *"); }
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(204); exit; }

function json_ok($data = []) { echo json_encode($data); }
function json_err($msg, $code = 500) { http_response_code($code); echo json_encode(['error'=>$msg]); }

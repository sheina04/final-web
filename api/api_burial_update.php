<?php
// api_burial_update.php
$origin = $_SERVER['HTTP_ORIGIN'] ?? '';
if ($origin) { header("Access-Control-Allow-Origin: $origin"); header("Vary: Origin"); }
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header('Content-Type: application/json; charset=utf-8');
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(204); exit; }

$DB_HOST='127.0.0.1';
$DB_NAME='rest_assured';
$DB_USER='root';
$DB_PASS='Janelle12345';

try {
  $pdo = new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME;charset=utf8mb4",$DB_USER,$DB_PASS,[
    PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC
  ]);
} catch (Throwable $e) {
  http_response_code(500); echo json_encode(['error'=>'DB error','detail'=>$e->getMessage()]); exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') { http_response_code(405); echo json_encode(['error'=>'Use POST']); exit; }
$data = json_decode(file_get_contents('php://input'), true);
if (!is_array($data)) { http_response_code(400); echo json_encode(['error'=>'Invalid JSON']); exit; }

$id          = isset($data['id']) && ctype_digit((string)$data['id']) ? (int)$data['id'] : null;
$unique_code = trim($data['unique_code'] ?? '');
$deceased    = isset($data['deceased_name']) ? trim($data['deceased_name']) : '';
$birth       = $data['birth_date']  ?: null;   // 'YYYY-MM-DD' or null
$death       = $data['death_date']  ?: null;
$burial      = $data['burial_date'] ?: null;
$plot_code   = isset($data['plot_code']) ? trim($data['plot_code']) : '';

if (!$id && $unique_code===''){ http_response_code(400); echo json_encode(['error'=>'Provide id or unique_code']); exit; }

$fields = [];
$params = [];

if ($deceased!==''){ $fields[]='deceased_name = :deceased_name'; $params[':deceased_name']=$deceased; }
$fields[]='birth_date  = :birth_date';  $params[':birth_date']=$birth;
$fields[]='death_date  = :death_date';  $params[':death_date']=$death;
$fields[]='burial_date = :burial_date'; $params[':burial_date']=$burial;
if ($plot_code!==''){ $fields[]='plot_code = :plot_code'; $params[':plot_code']=$plot_code; }

if (!$fields){ echo json_encode(['ok'=>true,'note'=>'nothing to update']); exit; }

$where = $id ? 'id = :val' : 'unique_code = :val';
$params[':val'] = $id ?: $unique_code;

$sql = "UPDATE burials SET ".implode(', ',$fields)." WHERE $where LIMIT 1";
$st  = $pdo->prepare($sql);
$st->execute($params);

echo json_encode(['ok'=>true,'updated'=>$st->rowCount()]);

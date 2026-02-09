<?php
session_start();

require_once '../../config/config.php';
require_once ROOT_PATH . 'config/database.php';

// 🔴 LEER JSON DEL BODY
$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    http_response_code(400);
    echo "No llegó data";
    exit;
}

$id_potrero = (int) ($data['id_potrero'] ?? 0);
$x = (int) ($data['x'] ?? 0);
$y = (int) ($data['y'] ?? 0);

if ($id_potrero <= 0) {
    http_response_code(400);
    echo "ID inválido";
    exit;
}

// ✅ GUARDAR EN BD
$sql = "UPDATE potrero SET x = ?, y = ? WHERE id_potrero = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$x, $y, $id_potrero]);

echo "OK";

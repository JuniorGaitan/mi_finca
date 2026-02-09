<?php
session_start();

require_once '../../config/config.php';
require_once ROOT_PATH . 'config/database.php';
require_once MODELS_PATH . 'Ubicacion.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php");
    exit;
}

if (empty($_POST['ganados']) || empty($_POST['id_potrero'])) {
    header("Location: index.php?error=1");
    exit;
}

$ganados = $_POST['ganados'];
$id_potrero = $_POST['id_potrero'];

$modelo = new Ubicacion($pdo);

if ($modelo->moverGanadoLote($ganados, $id_potrero)) {
    header("Location: index.php?success=1");
} else {
    header("Location: index.php?error=2");
}

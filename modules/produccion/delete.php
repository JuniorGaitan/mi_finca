<?php
session_start();
require_once '../../config/database.php';
require_once '../../app/models/Produccion.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$model = new Produccion($pdo);
$model->eliminar($_GET['id']);

header("Location: index.php");
exit;

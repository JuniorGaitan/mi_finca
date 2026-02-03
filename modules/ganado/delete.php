<?php
session_start();
require_once '../../config/database.php';
require_once '../../app/models/Ganado.php';

if (isset($_GET['id'])) {
    $ganado = new Ganado($pdo);
    $ganado->eliminar($_GET['id']);
}

header("Location: index.php");
exit;


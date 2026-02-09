<?php
session_start();

require_once 'config/config.php';
require_once ROOT_PATH . 'config/database.php';
require_once ROOT_PATH . 'app/models/Potrero.php';

if (!isset($_SESSION['id_finca'])) {
    header("Location: dashboard.php");
    exit;
}

$modelo = new Potrero($pdo);

// ✅ USAR id_finca CORRECTO
$terrenos = $modelo->listarTerrenosPorFinca($_SESSION['id_finca']);

// Procesar selección de terreno
if (isset($_GET['id_terreno'])) {
    $_SESSION['id_terreno'] = (int) $_GET['id_terreno'];
    header("Location: modules/potrero/cardPotrero.php");
    exit;
}

// Cargar vista
require_once 'views/finca/seleccionar_terreno.php';

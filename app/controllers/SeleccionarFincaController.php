<?php
session_start();

if (isset($_GET['id_terreno'])) {
    $_SESSION['id_terreno'] = (int) $_GET['id_terreno'];
    header("Location: dashboard.php");
    exit;
}


if (isset($_GET['id_finca'])) {
    $_SESSION['id_finca'] = (int) $_GET['id_finca'];

    // ya no necesitamos esta lista
    unset($_SESSION['fincas_disponibles']);

    header("Location: seleccionar_terreno.php");
    exit;
}

require_once 'modules/finca/seleccionar_finca.php';

<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!isset($_POST['id_finca'])) {
        die("Debe seleccionar una finca");
    }

    $_SESSION['id_finca'] = $_POST['id_finca'];

    unset($_SESSION['fincas_disponibles']);

    header("Location: ../../dashboard.php");
    exit;
}

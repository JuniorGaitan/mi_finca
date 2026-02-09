<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: /login.php");
    exit;
}

if (!isset($_SESSION['id_finca'])) {
    header("Location: /views/finca/seleccionar.php");
    exit;
}

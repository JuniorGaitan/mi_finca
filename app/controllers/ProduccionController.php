<?php
session_start();
require_once '../../config/database.php';
require_once '../models/Produccion.php';

$model = new Produccion($pdo);


// 🔥 ELIMINAR
if (isset($_GET['delete'])) {
    $model->eliminar($_GET['delete']);
    header("Location: ../../modules/produccion/index.php");
    exit;
}

// 🔥 GUARDAR (crear o actualizar)
if ($_POST) {

    // SI existe id_produccion → ACTUALIZAR
    if (!empty($_POST['id_produccion'])) {

        $model->actualizar($_POST);
    } else {

        // SI NO existe → CREAR
        $_POST['id_finca'] = $_SESSION['id_finca'];
        $model->crear($_POST);
    }

    header("Location: ../../modules/produccion/index.php");
    exit;
}

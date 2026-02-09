<?php
session_start();
require_once '../../config/database.php';
require_once '../models/Reproduccion.php';

$model = new Reproduccion($pdo);

/* =========================
   🟢 CREAR REPRODUCCIÓN
========================= */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($_POST['id_reproduccion'])) {

    // 🚫 Validar que no esté preñada
    if ($model->hembraPreñada($_POST['id_hembra']) > 0) {
        $_SESSION['error'] = "⚠️ Esta vaca ya está preñada.";
        header("Location: ../../modules/reproduccion/create.php");
        exit;
    }

    $model->crear($_POST);

    header("Location: ../../modules/reproduccion/index.php");
    exit;
}

/* =========================
   ✏️ ACTUALIZAR
========================= */
if (isset($_POST['id_reproduccion'])) {

    $reproduccion = $model->obtener($_POST['id_reproduccion']);

    $model->actualizar($_POST);

    /* 🐮 SI CAMBIA A PARIDA → CREAR CRÍA */
    if ($_POST['estado'] === 'parida' && $reproduccion['estado'] !== 'parida') {

        require_once '../models/Ganado.php';
        $ganadoModel = new Ganado($pdo);

        $codigo = 'CRIA-' . date('YmdHis');

        $ganadoModel->crear([
            'codigo_arete'     => $codigo,
            'nombre'           => 'Cría',
            'sexo'             => 'Hembra',
            'raza'             => 'Por definir',
            'fecha_nacimiento' => date('Y-m-d'),
            'id_madre'         => $reproduccion['id_hembra'],
            'id_padre'         => $reproduccion['id_macho'],
            'origen'           => 'nacido'
        ]);
    }

    header("Location: ../../modules/reproduccion/index.php");
    exit;
}
/* =========================
   🗑️ ELIMINAR
========================= */
if (isset($_GET['delete'])) {
    $model->eliminar($_GET['delete']);
    header("Location: ../../modules/reproduccion/index.php");
    exit;
}

<?php
session_start();

require_once '../../config/database.php';
require_once '../models/Ubicacion.php';
require_once '../models/Potrero.php';

/* =========================
   SEGURIDAD
========================= */
if (!isset($_SESSION['usuario'])) {
    header('Location: ../../index.php');
    exit;
}

/* =========================
   MODELOS
========================= */
$ubicacionModel = new Ubicacion($pdo);
$potreroModel   = new Potrero($pdo);

/* =========================
   ACCIÓN
========================= */
$action = $_POST['action'] ?? $_GET['action'] ?? null;

/* =========================
   CREAR - MOVIMIENTO POR LOTE
========================= */
if ($action === 'crear' && $_SERVER['REQUEST_METHOD'] === 'POST') {

    if (empty($_POST['id_ganado']) || empty($_POST['id_potrero'])) {
        header('Location: ../../modules/ubicacion/create.php?error=1');
        exit;
    }

    $ganados           = $_POST['id_ganado']; // array
    $id_potrero_nuevo  = (int) $_POST['id_potrero'];

    foreach ($ganados as $id_ganado) {

        // 1️⃣ obtener potrero anterior
        $id_potrero_anterior = $potreroModel->obtenerPotreroActivo($id_ganado);

        // 2️⃣ cerrar ubicación anterior
        $ubicacionModel->cerrarUbicacionActiva($id_ganado);

        // 3️⃣ si tenía potrero anterior → descanso
        if ($id_potrero_anterior) {
            $potreroModel->enviarADescanso($id_potrero_anterior);
            $potreroModel->calcularDiasDescanso($id_potrero_anterior);
        }

        // 4️⃣ registrar nueva entrada
        $ubicacionModel->registrarEntrada($id_ganado, $id_potrero_nuevo);
    }

    // 5️⃣ marcar potrero nuevo como en uso
    $potreroModel->cambiarEstado($id_potrero_nuevo, 'en uso');

    header('Location: ../../modules/ubicacion/index.php?success=1');
    exit;
}


/* =========================
   EDITAR UBICACIÓN
========================= */
if ($action === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {

    $ubicacionModel->actualizar(
        $_POST['id_ubicacion'],
        $_POST['id_ganado'],
        $_POST['id_potrero'],
        $_POST['fecha_entrada'],
        $_POST['fecha_salida'] ?? null
    );

    header('Location: ../../modules/ubicacion/index.php?updated=1');
    exit;
}

/* =========================
   ELIMINAR
========================= */
if ($action === 'delete' && isset($_GET['id'])) {

    $ubicacionModel->eliminar((int) $_GET['id']);

    header('Location: ../../modules/ubicacion/index.php?deleted=1');
    exit;
}

/* =========================
   SI NO HAY ACCIÓN
========================= */
header('Location: ../../modules/ubicacion/index.php');
exit;

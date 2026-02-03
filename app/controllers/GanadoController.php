<?php
session_start();

require '../../config/database.php';
require '../models/Ganado.php';

$ganadoModel = new Ganado($pdo);

/* =========================
   CREAR GANADO
========================= */
if (isset($_POST['action']) && $_POST['action'] === 'create') {

    $data = [
        'codigo_arete' => $_POST['codigo_arete'],
        'nombre'       => $_POST['nombre'],
        'sexo'         => $_POST['sexo'],
        'raza'         => $_POST['raza'],
        'peso_actual'  => $_POST['peso_actual'],
        'estado'       => $_POST['estado']
    ];

    $ganadoModel->crear($data);

    header('Location: ../../views/ganado/index.php');
    exit;
}

/* =========================
   ACTUALIZAR GANADO
========================= */
if (isset($_POST['action']) && $_POST['action'] === 'update') {

    $id = (int) $_POST['id_ganado'];

    $data = [
        'codigo_arete' => $_POST['codigo_arete'],
        'nombre'       => $_POST['nombre'],
        'sexo'         => $_POST['sexo'],
        'raza'         => $_POST['raza'],
        'peso_actual'  => $_POST['peso_actual'],
        'estado'       => $_POST['estado']
    ];

    $ganadoModel->actualizar($id, $data);

    header('Location: ../../views/ganado/index.php');
    exit;
}

/* =========================
   ELIMINAR GANADO (GET)
   👉 compatible con tu index
========================= */
if (isset($_GET['delete'])) {

    $id = (int) $_GET['delete'];
    $ganadoModel->eliminar($id);

    header('Location: ../../views/ganado/index.php');
    exit;
}

/* =========================
   ELIMINAR GANADO (POST)
   👉 por si luego migrás
========================= */
if (isset($_POST['action']) && $_POST['action'] === 'delete') {

    $id = (int) $_POST['id'];
    $ganadoModel->eliminar($id);

    header('Location: ../../views/ganado/index.php');
    exit;
}

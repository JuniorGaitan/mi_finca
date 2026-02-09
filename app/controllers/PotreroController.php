<?php
session_start();

require_once '../../config/database.php';
require_once '../models/Ubicacion.php';
require_once '../models/Potrero.php';

// 🔐 Protección básica
if (!isset($_SESSION['usuario'])) {
    header('Location: ../../index.php');
    exit;
}

$ubicacionModel = new Ubicacion($pdo);
$potreroModel   = new Potrero($pdo);


require_once '../../config/database.php';
require_once '../models/Potrero.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

// ✅ ESTA ES LA VARIABLE CORRECTA
$potreroModel = new Potrero($pdo);

/*
|--------------------------------------------------------------------------
| AJAX: Terrenos por finca
|--------------------------------------------------------------------------
*/
if (isset($_GET['action']) && $_GET['action'] === 'terrenosPorFinca') {

    $id_finca = (int) $_GET['id_finca'];

    // ✅ USA LA VARIABLE CORRECTA
    $terrenos = $potreroModel->listarTerrenosPorFinca($id_finca);

    header('Content-Type: application/json');
    echo json_encode($terrenos);
    exit;
}





/*
|--------------------------------------------------------------------------
| CREAR POTRERO
|--------------------------------------------------------------------------
*/
if (isset($_GET['action']) && $_GET['action'] === 'crear' && $_SERVER['REQUEST_METHOD'] === 'POST') {

    if (empty($_POST['id_terreno']) || empty($_POST['nombre'])) {
        header('Location: ../../modules/potrero/create.php?error=1');
        exit;
    }

    $data = [
        'id_terreno'        => $_POST['id_terreno'],
        'nombre'            => $_POST['nombre'],
        'area'              => $_POST['area'],
        'capacidad_animales' => $_POST['capacidad_animales'],
        'estado'            => 'disponible',
        'fecha_ultimo_uso'  => null,
        'dias_descanso'     => null
    ];

    $potreroModel->crear($data);

    header('Location: ../../modules/potrero/index.php?success=1');
    exit;
}
/*
|--------------------------------------------------------------------------
| EDITAR POTRERO
|--------------------------------------------------------------------------
*/
if (isset($_GET['action']) && $_GET['action'] === 'editar' && $_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = (int) $_POST['id_potrero'];

    $potreroActual = $potreroModel->obtenerPorId($id);

    // 🔒 BLOQUEO
    if ($potreroActual['estado'] === 'en uso') {
        header('Location: ../../modules/potrero/index.php?bloqueado=1');
        exit;
    }

    $data = [
        'id_terreno'         => $_POST['id_terreno'],
        'nombre'             => $_POST['nombre'],
        'area'               => $_POST['area'],
        'capacidad_animales' => $_POST['capacidad_animales'],
        'estado'             => $_POST['estado']
    ];

    $potreroModel->actualizar($id, $data);

    header('Location: ../../modules/potrero/index.php?updated=1');
    exit;
}



/*
|--------------------------------------------------------------------------
| ELIMINAR (si lo usas desde listado)
|--------------------------------------------------------------------------
*/
if (isset($_GET['delete'])) {
    $ubicacionModel->eliminar((int)$_GET['delete']);
    header('Location: ../../modules/ubicacion/index.php');
    exit;
}

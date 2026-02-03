<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/Potrero.php';

class PotreroController
{
    private $modelo;

    public function __construct($pdo)
    {
        $this->modelo = new Potrero($pdo);
    }

    public function crear()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id_terreno = $_POST['id_terreno'];
            $nombre = $_POST['nombre'];
            $area = $_POST['area'];
            $capacidad = $_POST['capacidad'];

            if ($this->modelo->guardar($id_terreno, $nombre, $area, $capacidad)) {
                header("Location: ../../modules/potrero/index.php?success=1");
            } else {
                header("Location: ../../modules/potrero/index.php?error=1");
            }
            exit;
        }
    }

    public function editar()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id = $_POST['id_potrero'];
        
        // Empaquetamos los datos como los espera el modelo
        $data = [
            'nombre' => $_POST['nombre'],
            'area' => $_POST['area'],
            'capacidad' => $_POST['capacidad'],
            'estado' => $_POST['estado'],
            'dias_descanso' => 30 // Valor por defecto o puedes añadir un input para esto
        ];

        if ($this->modelo->actualizar($id, $data)) {
            header("Location: ../../modules/potrero/index.php?success=editado");
        } else {
            header("Location: ../../modules/potrero/index.php?error=1");
        }
        exit;
    }

    }

    public function eliminar()
    {
        $id = $_GET['id'] ?? null;
        if ($id && $this->modelo->eliminar($id)) {
            header("Location: ../../modules/potrero/index.php?success=eliminado");
        }
        exit;
    }

    public function obtenerTerrenosPorFinca()
    {
        // Limpiar basura del buffer
        if (ob_get_level()) ob_end_clean();

        header('Content-Type: application/json; charset=utf-8');

        $id_finca = isset($_GET['id_finca']) ? (int)$_GET['id_finca'] : 0;

        // ESTA ES LA ÚNICA LÍNEA QUE NECESITAS. 
        // No definas la función, solo úsala:
        $datos = $this->modelo->listarTerrenosPorFinca($id_finca);
        echo json_encode($datos ? $datos : []);

        exit;
    }
}

// --- INICIALIZACIÓN ---
$controller = new PotreroController($pdo);

if (isset($_GET['action'])) {
    $action = $_GET['action'];

    if ($action == 'crear') {
        $controller->crear();
    } elseif ($action == 'editar') {
        $controller->editar();
    } elseif ($action == 'eliminar') {
        $controller->eliminar();
    } elseif ($action == 'terrenosPorFinca') {
        $controller->obtenerTerrenosPorFinca();
    }
}

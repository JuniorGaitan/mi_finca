<?php
session_start();


require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../models/Finca.php';

class AuthController
{
    private $Usuario;
    private $Finca;

    public function __construct($pdo)
    {
        $this->Usuario = new Usuario($pdo);
        $this->Finca   = new Finca($pdo);
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: ../../index.php");
            exit;
        }

        $usuario  = trim($_POST['usuario'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($usuario === '' || $password === '') {
            $_SESSION['error_login'] = "Complete todos los campos";
            header("Location: ../../index.php");
            exit;
        }

        $user = $this->Usuario->obtenerUsuarioActivo($usuario);

        if ($user && password_verify($password, $user['password'])) {

            $_SESSION['usuario'] = [
                'id'     => $user['id_usuario'],
                'nombre' => $user['nombre'],
                'rol'    => $user['rol']
            ];

            // 🔹 OBTENER FINCAS DEL USUARIO
            $fincas = $this->Finca->obtenerFincasPorUsuario($user['id_usuario']);

            if (count($fincas) === 0) {
                $_SESSION['error_login'] = "Este usuario no tiene finca asignada.";
                header("Location: ../../index.php");
                exit;
            }

           

            // ✅ SI SOLO TIENE UNA FINCA → SELECCIÓN AUTOMÁTICA
            if (count($fincas) === 1) {
                $_SESSION['id_finca'] = $fincas[0]['id_finca'];
                header("Location: ../../dashboard.php");
                exit;
            }

            // ✅ SI TIENE VARIAS → MOSTRAR SELECTOR
            $_SESSION['fincas_disponibles'] = $fincas;
            header("Location: ../../seleccionar.php");
            exit;
        } else {
            $_SESSION['error_login'] = "Usuario o contraseña incorrectos";
            header("Location: ../../index.php");
            exit;
        }
    }
}

$auth = new AuthController($pdo);
$auth->login();

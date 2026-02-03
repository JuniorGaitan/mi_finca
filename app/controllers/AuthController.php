<?php
session_start();

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/Usuario.php';

class AuthController
{
    private $Usuario;

    public function __construct($pdo)
    {
        $this->Usuario = new Usuario($pdo);
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

            header("Location: ../../dashboard.php");
            exit;

        } else {
            $_SESSION['error_login'] = "Usuario o contraseña incorrectos";
            header("Location: ../../index.php");
            exit;
        }
    }
}

// Ejecutar controlador
$auth = new AuthController($pdo);
$auth->login();

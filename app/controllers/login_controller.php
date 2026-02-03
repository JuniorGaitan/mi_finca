<?php
session_start();
require_once '../config/database.php';
require_once '../app/models/Usuario.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['usuario'] ?? '');
    $password = $_POST['password'] ?? '';

    $userModel = new Usuario($pdo);
    $user = $userModel->buscarPorNombre($username);

    // Verificación
    if ($user && password_verify($password, $user['password'])) {
        // Éxito: Regeneramos sesión por seguridad
        session_regenerate_id(true);

        $_SESSION['usuario'] = [
            'id'     => $user['id_usuario'],
            'nombre' => $user['nombre'],
            'rol'    => $user['rol']
        ];

        header("Location: ../dashboard.php");
        exit;
    } else {
        // Fallo
        $_SESSION['error_login'] = "Usuario o contraseña incorrectos.";
        header("Location: ../index.php");
        exit;
    }
}
<?php
session_start();
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $usuario  = trim($_POST['usuario']);
    $password = $_POST['password'];

    // 1️⃣ Buscar usuario activo
    $sql = "SELECT u.*, r.nombre AS rol
            FROM usuarios u
            JOIN roles r ON u.id_rol = r.id_rol
            WHERE u.usuario = ? AND u.estado = 'activo'
            LIMIT 1";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$usuario]);
    $user = $stmt->fetch();

    // 2️⃣ Verificar contraseña
    if ($user && password_verify($password, $user['password'])) {

        // 3️⃣ Guardar sesión
        $_SESSION['usuario'] = [
            'id'     => $user['id_usuario'],
            'nombre' => $user['nombre'],
            'rol'    => $user['rol']
        ];

        header("Location: ../dashboard.php");
        exit;

    } else {
        $_SESSION['error_login'] = "Usuario o contraseña incorrectos";
        header("Location: ../index.php");
        exit;
    }
}

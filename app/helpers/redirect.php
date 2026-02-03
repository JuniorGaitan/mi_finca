<?php

/**
 * Redirige a una URL específica y detiene la ejecución del script.
 * * @param string $path Ruta a la que se desea redirigir.
 */
function redirect($path) {
    header("Location: " . $path);
    exit(); // Fundamental para evitar que el código siga ejecutándose
}

/**
 * Redirige con un mensaje flash (usando sesiones).
 * * @param string $path
 * @param string $message
 * @param string $type (success, error, info)
 */
function redirectWith($path, $message, $type = 'error') {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    $_SESSION['flash_message'] = [
        'text' => $message,
        'type' => $type
    ];
    
    header("Location: " . $path);
    exit();
}
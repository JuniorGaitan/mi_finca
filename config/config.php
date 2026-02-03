<?php
// 1. Detectar la raíz del proyecto de forma dinámica
// Esto evita que tengas que cambiar la ruta si mueves la carpeta
if (!defined('BASE_URL')) {
    // Si estás en localhost, esto devolverá "/mi_finca/"
    define('BASE_URL', '/mi_finca/');
}

// 2. Rutas absolutas para el sistema de archivos (servidor)
// Útiles para los require_once
define('ROOT_PATH', dirname(__DIR__) . '/');
define('MODELS_PATH', ROOT_PATH . 'app/models/');
define('CONTROLLERS_PATH', ROOT_PATH . 'app/controllers/');
define('HELPERS_PATH', ROOT_PATH . 'helpers/');

// 3. Configuración de la Base de Datos
define('DB_HOST', 'localhost');
define('DB_NAME', 'tu_base_de_datos'); // CAMBIA ESTO
define('DB_USER', 'root');
define('DB_PASS', '');

// 4. Configuración de Errores (Activar en desarrollo)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 5. Función para ayudar con las URLs en las vistas
function url($path) {
    return BASE_URL . ltrim($path, '/');
}
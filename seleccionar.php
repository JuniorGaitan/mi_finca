<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit;
}

// 🔹 CUANDO SELECCIONA UN TERRENO
if (isset($_GET['id_terreno'])) {
    $_SESSION['id_terreno'] = (int) $_GET['id_terreno'];
    header("Location: dashboard.php");
    exit;
}


require_once 'config/config.php';
require_once ROOT_PATH . 'config/database.php';
require_once MODELS_PATH . 'Terreno.php';

$modeloTerreno = new Terreno($pdo);

// 🔹 USAMOS LA FINCA YA SELECCIONADA
$id_finca = $_SESSION['id_finca'];

$terrenos = $modeloTerreno->obtenerTerrenosPorFinca($id_finca);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Seleccionar terreno</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h4 class="mb-4">🌱 Seleccionar terreno</h4>

    <?php if (empty($terrenos)): ?>
        <div class="alert alert-warning">
            No hay terrenos registrados para esta finca.
        </div>
    <?php else: ?>
        <div class="list-group">
            <?php foreach ($terrenos as $t): ?>
                <a href="seleccionar.php?id_terreno=<?= $t['id_terreno'] ?>"
                   class="list-group-item list-group-item-action">
                    🌾 <?= htmlspecialchars($t['nombre']) ?>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

</body>
</html>

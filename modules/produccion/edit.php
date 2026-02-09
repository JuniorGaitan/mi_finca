<?php
session_start();
require_once '../../config/database.php';
require_once '../../app/models/Produccion.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$model = new Produccion($pdo);
$produccion = $model->obtener($_GET['id']);

if (!$produccion) {
    header("Location: index.php");
    exit;
}

$stmt = $pdo->prepare("
    SELECT DISTINCT g.id_ganado, g.codigo_arete, g.nombre
    FROM ganado g
    INNER JOIN ubicacion_ganado ug ON g.id_ganado = ug.id_ganado
    INNER JOIN potrero p ON ug.id_potrero = p.id_potrero
    INNER JOIN terreno t ON p.id_terreno = t.id_terreno
    WHERE t.id_finca = ?
      AND ug.fecha_salida IS NULL
");

$stmt->execute([$_SESSION['id_finca']]);
$ganado = $stmt->fetchAll();
include '../../includes/header.php';
?>

<div class="container mt-4">
    <h3>✏️ Editar Producción</h3>

    <form method="POST" action="../../app/controllers/ProduccionController.php"
        class="card card-body shadow">

        <input type="hidden" name="id_produccion"
            value="<?= $produccion['id_produccion'] ?>">

        <label class="form-label">Ganado</label>
        <select name="id_ganado" class="form-select mb-3" required>
            <?php foreach ($ganado as $g): ?>
                <option value="<?= $g['id_ganado'] ?>"
                    <?= $g['id_ganado'] == $produccion['id_ganado'] ? 'selected' : '' ?>>
                    <?= $g['codigo_arete'] ?> - <?= $g['nombre'] ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label class="form-label">Tipo</label>
        <select name="tipo" class="form-select mb-3" required>
            <option value="leche" <?= $produccion['tipo'] == 'leche' ? 'selected' : '' ?>>Leche</option>
            <option value="peso" <?= $produccion['tipo'] == 'peso' ? 'selected' : '' ?>>Peso</option>
            <option value="cria" <?= $produccion['tipo'] == 'cria' ? 'selected' : '' ?>>Cría</option>
        </select>

        <label class="form-label">Cantidad</label>
        <input type="number" step="0.01" name="cantidad"
            class="form-control mb-3"
            value="<?= $produccion['cantidad'] ?>" required>

        <label class="form-label">Fecha</label>
        <input type="date" name="fecha"
            class="form-control mb-3"
            value="<?= $produccion['fecha'] ?>" required>

        <div class="d-flex gap-2">
            <button class="btn btn-primary">
                <i class="bi bi-save"></i> Actualizar
            </button>
            <a href="index.php" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>

<?php include '../../includes/footer.php'; ?>
<?php
session_start();
require_once '../../config/database.php';

$ganado = $pdo->prepare("
    SELECT DISTINCT g.id_ganado, g.codigo_arete, g.nombre
    FROM ganado g
    INNER JOIN ubicacion_ganado ug ON g.id_ganado = ug.id_ganado
    INNER JOIN potrero p ON ug.id_potrero = p.id_potrero
    INNER JOIN terreno t ON p.id_terreno = t.id_terreno
    WHERE t.id_finca = ?
      AND ug.fecha_salida IS NULL
");

$ganado->execute([$_SESSION['id_finca']]);
$ganado = $ganado->fetchAll();

include '../../includes/header.php';
?>

<div class="container mt-4">
    <h3>➕ Registrar Producción</h3>

    <form method="POST" action="../../app/controllers/ProduccionController.php" class="card card-body shadow">

        <label class="form-label">Ganado</label>
        <select name="id_ganado" class="form-select mb-3" required>
            <?php foreach ($ganado as $g): ?>
                <option value="<?= $g['id_ganado'] ?>">
                    <?= $g['codigo_arete'] ?> - <?= $g['nombre'] ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label class="form-label">Tipo</label>
        <select name="tipo" class="form-select mb-3" required>
            <option value="leche">Leche</option>
            <option value="peso">Peso</option>
            <option value="cria">Cría</option>
        </select>

        <label class="form-label">Cantidad</label>
        <input type="number" step="0.01" name="cantidad" class="form-control mb-3" required>

        <label class="form-label">Fecha</label>
        <input type="date" name="fecha" class="form-control mb-3" required>

        <button class="btn btn-success">Guardar</button>
        <a href="index.php" class="btn btn-secondary">Cancelar</a>

    </form>
</div>

<?php include '../../includes/footer.php'; ?>
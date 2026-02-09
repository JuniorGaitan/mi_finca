<?php
session_start();

require_once '../../config/config.php';
require_once ROOT_PATH . 'config/database.php';
require_once ROOT_PATH . 'app/controllers/VacunacionController.php';

// Datos para los combos (pueden ir luego a controladores propios)
$ganado = $pdo->query("SELECT id_ganado, codigo_arete FROM ganado")->fetchAll(PDO::FETCH_ASSOC);
$vacunas = $pdo->query("SELECT id_vacuna, nombre FROM vacunas")->fetchAll(PDO::FETCH_ASSOC);

$controller = new VacunacionController($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->store($_POST);
}

include ROOT_PATH . 'includes/header.php';
?>

<h4>💉 Aplicar Vacuna</h4>

<form method="POST" class="card p-3 shadow-sm">

    <label class="fw-bold">Ganado</label>
    <select name="ganado" class="form-select mb-2" required>
        <?php foreach ($ganado as $g): ?>
            <option value="<?= $g['id_ganado'] ?>">
                Arete <?= htmlspecialchars($g['codigo_arete']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label class="fw-bold">Vacuna</label>
    <select name="vacuna" class="form-select mb-2" required>
        <?php foreach ($vacunas as $v): ?>
            <option value="<?= $v['id_vacuna'] ?>">
                <?= htmlspecialchars($v['nombre']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label class="fw-bold">Fecha de aplicación</label>
    <input type="date" name="fecha" class="form-control mb-2" required>

    <label class="fw-bold">Próxima aplicación</label>
    <input type="date" name="proxima" class="form-control mb-2">

    <label class="fw-bold">Observaciones</label>
    <textarea name="obs" class="form-control mb-3"></textarea>

    <button class="btn btn-success">💾 Guardar</button>
</form>

<?php include ROOT_PATH . 'includes/footer.php'; ?>
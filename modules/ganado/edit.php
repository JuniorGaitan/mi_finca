<?php
session_start();
require '../../config/database.php';
require '../../app/models/Ganado.php';

$ganadoModel = new Ganado($pdo);

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$g = $ganadoModel->obtenerPorId($_GET['id']);

include '../../includes/header.php';
include '../../includes/sidebar.php';
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
<h2 class="mt-4">✏️ Editar Ganado</h2>

<form method="POST" action="../../app/controllers/GanadoController.php" class="mt-3">
    <input type="hidden" name="action" value="actualizar">
    <input type="hidden" name="id_ganado" value="<?= $g['id_ganado'] ?>">

    <div class="row">
        <div class="col-md-4">
            <label>Arete</label>
            <input type="text" name="codigo_arete" class="form-control" required value="<?= $g['codigo_arete'] ?>">
        </div>
        <div class="col-md-4">
            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control" value="<?= $g['nombre'] ?>">
        </div>
        <div class="col-md-4">
            <label>Sexo</label>
            <select name="sexo" class="form-control">
                <option value="macho" <?= $g['sexo']=='macho'?'selected':'' ?>>Macho</option>
                <option value="hembra" <?= $g['sexo']=='hembra'?'selected':'' ?>>Hembra</option>
            </select>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-4">
            <label>Raza</label>
            <input type="text" name="raza" class="form-control" value="<?= $g['raza'] ?>">
        </div>
        <div class="col-md-4">
            <label>Fecha Nacimiento</label>
            <input type="date" name="fecha_nacimiento" class="form-control" value="<?= $g['fecha_nacimiento'] ?>">
        </div>
        <div class="col-md-4">
            <label>Peso (kg)</label>
            <input type="number" step="0.01" name="peso_actual" class="form-control" value="<?= $g['peso_actual'] ?>">
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-4">
            <label>Estado</label>
            <select name="estado" class="form-control">
                <option value="activo" <?= $g['estado']=='activo'?'selected':'' ?>>Activo</option>
                <option value="vendido" <?= $g['estado']=='vendido'?'selected':'' ?>>Vendido</option>
                <option value="muerto" <?= $g['estado']=='muerto'?'selected':'' ?>>Muerto</option>
            </select>
        </div>
    </div>

    <button class="btn btn-success mt-4">Actualizar</button>
    <a href="index.php" class="btn btn-secondary mt-4">Cancelar</a>
</form>
</main>

<?php include '../../includes/footer.php'; ?>

<?php
session_start();
require_once '../../config/database.php';
require_once '../../app/models/Reproduccion.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$model = new Reproduccion($pdo);
$r = $model->obtener($_GET['id']);

include '../../includes/header.php';
?>

<div class="container mt-4">
    <h3>✏️ Editar Reproducción</h3>

    <form method="POST" action="../../app/controllers/ReproduccionController.php"
        class="card card-body shadow">

        <input type="hidden" name="id_reproduccion" value="<?= $r['id_reproduccion'] ?>">

        <label class="form-label">Hembra</label>
        <label class="form-label">Hembra</label>

        <input type="hidden" name="id_hembra"
            value="<?= $r['id_hembra'] ?>">

        <input type="text" class="form-control mb-3"
            value="ID <?= $r['id_hembra'] ?>" readonly>
        <input type="hidden" name="id_macho" value="<?= $r['id_macho'] ?>">

        <label class="form-label">Macho</label>
        <select name="id_macho" class="form-select mb-3">
            <option value="">— Inseminación —</option>
            <?php foreach ($machos as $m): ?>
                <option value="<?= $m['id_ganado'] ?>"
                    <?= $m['id_ganado'] == $r['id_macho'] ? 'selected' : '' ?>>
                    <?= $m['codigo_arete'] ?> - <?= $m['nombre'] ?>
                </option>
            <?php endforeach; ?>
        </select>


        <label class="form-label">Método</label>
        <select name="metodo" class="form-select mb-3">
            <option value="monta natural" <?= $r['metodo'] == 'monta natural' ? 'selected' : '' ?>>Monta natural</option>
            <option value="inseminacion" <?= $r['metodo'] == 'inseminacion' ? 'selected' : '' ?>>Inseminación</option>
        </select>

        <label class="form-label">Fecha de monta</label>
        <input type="date" name="fecha_monta" id="fecha_monta"
            class="form-control mb-3"
            value="<?= $r['fecha_monta'] ?>">

        <label class="form-label">Fecha probable de parto</label>
        <input type="date" name="fecha_probable_parto" id="fecha_parto"
            class="form-control mb-3"
            value="<?= $r['fecha_probable_parto'] ?>">

        <label class="form-label">Estado</label>
        <select name="estado" class="form-select mb-3">
            <option value="preñada" <?= $r['estado'] == 'preñada' ? 'selected' : '' ?>>Preñada</option>
            <option value="parida" <?= $r['estado'] == 'parida' ? 'selected' : '' ?>>Parida</option>
            <option value="fallida" <?= $r['estado'] == 'fallida' ? 'selected' : '' ?>>Fallida</option>
        </select>

        <div class="d-flex gap-2">
            <button class="btn btn-primary">Actualizar</button>
            <a href="index.php" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>

<script>
    document.getElementById('fecha_monta').addEventListener('change', function() {
        let fecha = new Date(this.value);
        fecha.setDate(fecha.getDate() + 280);
        document.getElementById('fecha_parto').value = fecha.toISOString().split('T')[0];
    });
</script>

<?php include '../../includes/footer.php'; ?>
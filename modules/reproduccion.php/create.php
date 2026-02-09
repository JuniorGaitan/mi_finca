<?php
session_start();
require_once '../../config/database.php';

if (!isset($_SESSION['id_finca'])) {
    header("Location: ../../seleccionar.php");
    exit;
}

// HEMBRAS
$stmt = $pdo->prepare("
    SELECT DISTINCT g.id_ganado, g.codigo_arete, g.nombre
    FROM ganado g
    INNER JOIN ubicacion_ganado ug ON g.id_ganado = ug.id_ganado
    INNER JOIN potrero p ON ug.id_potrero = p.id_potrero
    INNER JOIN terreno t ON p.id_terreno = t.id_terreno
    WHERE g.sexo='Hembra'
    AND t.id_finca=?
    AND ug.fecha_salida IS NULL
");
$stmt->execute([$_SESSION['id_finca']]);
$hembras = $stmt->fetchAll();

// MACHOS
$stmt = $pdo->prepare("
    SELECT DISTINCT g.id_ganado, g.codigo_arete, g.nombre
    FROM ganado g
    INNER JOIN ubicacion_ganado ug ON g.id_ganado = ug.id_ganado
    INNER JOIN potrero p ON ug.id_potrero = p.id_potrero
    INNER JOIN terreno t ON p.id_terreno = t.id_terreno
    WHERE g.sexo='Macho'
    AND t.id_finca=?
    AND ug.fecha_salida IS NULL
");
$stmt->execute([$_SESSION['id_finca']]);
$machos = $stmt->fetchAll();

include '../../includes/header.php';
?>

<div class="container mt-4">
    <h3>🐄 Nueva Reproducción</h3>
    
    <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?= $_SESSION['error'];
            unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>


    <form method="POST" action="../../app/controllers/ReproduccionController.php"
        class="card card-body shadow">

        <label class="form-label">Hembra</label>
        <select name="id_hembra" class="form-select mb-3" required>
            <option value="">Seleccione hembra</option>
            <?php foreach ($hembras as $h): ?>
                <option value="<?= $h['id_ganado'] ?>">
                    <?= $h['codigo_arete'] ?> - <?= $h['nombre'] ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label class="form-label">Método</label>
        <select name="metodo" id="metodo" class="form-select mb-3" required>
            <option value="monta natural">Monta natural</option>
            <option value="inseminacion">Inseminación</option>
        </select>

        <label class="form-label">Macho</label>
        <select name="id_macho" id="macho" class="form-select mb-3">
            <option value="">— Inseminación —</option>
            <?php foreach ($machos as $m): ?>
                <option value="<?= $m['id_ganado'] ?>">
                    <?= $m['codigo_arete'] ?> - <?= $m['nombre'] ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label class="form-label">Fecha de monta / inseminación</label>
        <input type="date" name="fecha_monta" id="fecha_monta"
            class="form-control mb-3" required>

        <label class="form-label">Fecha probable de parto</label>
        <input type="date" name="fecha_probable_parto" id="fecha_parto"
            class="form-control mb-3" readonly>

        <label class="form-label">Estado</label>
        <select name="estado" class="form-select mb-3">
            <option value="preñada">Preñada</option>
            <option value="fallida">Fallida</option>
        </select>

        <div class="d-flex gap-2">
            <button class="btn btn-success">💾 Guardar</button>
            <a href="index.php" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>

<script>
    // 🔹 Cálculo automático +280 días
    document.getElementById('fecha_monta').addEventListener('change', function() {
        let fecha = new Date(this.value);
        fecha.setDate(fecha.getDate() + 280);
        document.getElementById('fecha_parto').value = fecha.toISOString().split('T')[0];
    });

    // 🔹 Inseminación desactiva macho
    document.getElementById('metodo').addEventListener('change', function() {
        document.getElementById('macho').disabled = this.value === 'inseminacion';
    });
</script>

<?php include '../../includes/footer.php'; ?>
<?php
session_start();
require '../../config/database.php';

if ($_POST) {
    $sql = "INSERT INTO ganado 
    (codigo_arete, nombre, sexo, raza, fecha_nacimiento, peso_actual)
    VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $_POST['codigo_arete'],
        $_POST['nombre'],
        $_POST['sexo'],
        $_POST['raza'],
        $_POST['fecha_nacimiento'],
        $_POST['peso_actual']
    ]);

    header("Location: index.php");
    exit;
}

include '../../includes/header.php';
include '../../includes/sidebar.php';
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
<h2 class="mt-4">➕ Nuevo Ganado</h2>

<form method="POST" class="mt-3">
    <div class="row">
        <div class="col-md-4">
            <label>Arete</label>
            <input type="text" name="codigo_arete" class="form-control" required>
        </div>

        <div class="col-md-4">
            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control">
        </div>

        <div class="col-md-4">
            <label>Sexo</label>
            <select name="sexo" class="form-control">
                <option value="macho">Macho</option>
                <option value="hembra">Hembra</option>
            </select>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-4">
            <label>Raza</label>
            <input type="text" name="raza" class="form-control">
        </div>

        <div class="col-md-4">
            <label>Fecha Nacimiento</label>
            <input type="date" name="fecha_nacimiento" class="form-control">
        </div>

        <div class="col-md-4">
            <label>Peso (kg)</label>
            <input type="number" step="0.01" name="peso_actual" class="form-control">
        </div>
    </div>

    <button class="btn btn-success mt-4">Guardar</button>
    <a href="index.php" class="btn btn-secondary mt-4">Cancelar</a>
</form>
</main>

<?php include '../../includes/footer.php'; ?>

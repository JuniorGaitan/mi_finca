<?php
session_start();
require '../../config/database.php';

$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM ganado WHERE id_ganado = ?");
$stmt->execute([$id]);
$g = $stmt->fetch();

if ($_POST) {
    $sql = "UPDATE ganado SET
        nombre = ?, sexo = ?, raza = ?, peso_actual = ?, estado = ?
        WHERE id_ganado = ?";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $_POST['nombre'],
        $_POST['sexo'],
        $_POST['raza'],
        $_POST['peso_actual'],
        $_POST['estado'],
        $id
    ]);

    header("Location: index.php");
    exit;
}

include '../../includes/header.php';
include '../../includes/sidebar.php';
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
<h2 class="mt-4">✏️ Editar Ganado</h2>

<form method="POST">
    <div class="row">
        <div class="col-md-4">
            <label>Nombre</label>
            <input name="nombre" class="form-control" value="<?= $g['nombre'] ?>">
        </div>

        <div class="col-md-4">
            <label>Sexo</label>
            <select name="sexo" class="form-control">
                <option value="macho" <?= $g['sexo']=='macho'?'selected':'' ?>>Macho</option>
                <option value="hembra" <?= $g['sexo']=='hembra'?'selected':'' ?>>Hembra</option>
            </select>
        </div>

        <div class="col-md-4">
            <label>Estado</label>
            <select name="estado" class="form-control">
                <option value="activo">Activo</option>
                <option value="vendido">Vendido</option>
                <option value="muerto">Muerto</option>
            </select>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-4">
            <label>Raza</label>
            <input name="raza" class="form-control" value="<?= $g['raza'] ?>">
        </div>

        <div class="col-md-4">
            <label>Peso</label>
            <input name="peso_actual" class="form-control" value="<?= $g['peso_actual'] ?>">
        </div>
    </div>

    <button class="btn btn-warning mt-4">Actualizar</button>
</form>
</main>

<?php include '../../includes/footer.php'; ?>

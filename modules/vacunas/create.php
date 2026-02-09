<?php
require '../../config/database.php';

if ($_POST) {
    $sql = "INSERT INTO vacunas (nombre, descripcion, frecuencia_dias)
            VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $_POST['nombre'],
        $_POST['descripcion'],
        $_POST['frecuencia_dias']
    ]);
    header("Location: index.php");
}
include '../../includes/header.php';
?>

<h4>➕ Nueva Vacuna</h4>

<form method="POST" class="card p-3">
    <input class="form-control mb-2" name="nombre" placeholder="Nombre" required>
    <textarea class="form-control mb-2" name="descripcion" placeholder="Descripción"></textarea>
    <input class="form-control mb-2" type="number" name="frecuencia_dias" placeholder="Frecuencia (días)">
    <button class="btn btn-success">Guardar</button>
</form>

<?php include '../../includes/footer.php'; ?>
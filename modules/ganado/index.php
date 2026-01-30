<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../../index.php");
    exit;
}

require_once '../../config/database.php';
include '../../includes/header.php';
include '../../includes/sidebar.php';

$sql = "SELECT * FROM ganado ORDER BY id_ganado DESC";
$stmt = $pdo->query($sql);
$ganado = $stmt->fetchAll();
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between mt-4">
        <h2>🐄 Ganado</h2>
        <a href="create.php" class="btn btn-success">+ Nuevo</a>
    </div>

    <table class="table table-bordered table-hover mt-3">
        <thead class="table-dark">
            <tr>
                <th>Arete</th>
                <th>Nombre</th>
                <th>Sexo</th>
                <th>Raza</th>
                <th>Peso</th>
                <th>Estado</th>
                <th width="160">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($ganado as $g): ?>
            <tr>
                <td><?= $g['codigo_arete'] ?></td>
                <td><?= $g['nombre'] ?></td>
                <td><?= ucfirst($g['sexo']) ?></td>
                <td><?= $g['raza'] ?></td>
                <td><?= $g['peso_actual'] ?> kg</td>
                <td><?= $g['estado'] ?></td>
                <td>
                    <a href="edit.php?id=<?= $g['id_ganado'] ?>" class="btn btn-sm btn-warning">Editar</a>
                    <a href="delete.php?id=<?= $g['id_ganado'] ?>" 
                       class="btn btn-sm btn-danger"
                       onclick="return confirm('¿Eliminar ganado?')">
                       Eliminar
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>

<?php include '../../includes/footer.php'; ?>

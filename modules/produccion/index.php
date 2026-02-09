<?php
session_start();
require_once '../../config/database.php';
require_once '../../app/models/Produccion.php';

if (!isset($_SESSION['usuario'])) {
    header("Location: ../../index.php");
    exit;
}

if (!isset($_SESSION['id_finca'])) {
    header("Location: ../../seleccionar.php");
    exit;
}

$model = new Produccion($pdo);
$producciones = $model->listarPorFinca($_SESSION['id_finca']);

include '../../includes/header.php';
?>

<div class="container-fluid">
    <div class="row">

        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 p-0">
            <?php include '../../includes/sidebar.php'; ?>
        </div>

        <!-- Contenido -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

            <div class="d-flex justify-content-between align-items-center mt-4">
                <h2>🥛 Control de Producción</h2>
                <a href="create.php" class="btn btn-success">
                    <i class="bi bi-plus-circle"></i> Nuevo Registro
                </a>
            </div>

            <?php if (empty($producciones)): ?>
                <div class="alert alert-info mt-4">
                    No hay registros de producción todavía.
                </div>
            <?php else: ?>

                <div class="card shadow mt-3">
                    <div class="card-body table-responsive">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-dark text-center">
                                <tr>
                                    <th>Arete</th>
                                    <th>Nombre</th>
                                    <th>Tipo</th>
                                    <th>Cantidad</th>
                                    <th>Fecha</th>
                                    <th style="width:160px">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($producciones as $p): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($p['codigo_arete']) ?></td>
                                        <td><?= htmlspecialchars($p['nombre']) ?></td>

                                        <td class="text-center">
                                            <span class="badge bg-<?=
                                                                    $p['tipo'] == 'leche' ? 'primary' : ($p['tipo'] == 'peso' ? 'warning' : 'info')
                                                                    ?>">
                                                <?= ucfirst($p['tipo']) ?>
                                            </span>
                                        </td>

                                        <td class="text-end">
                                            <?= number_format($p['cantidad'], 2) ?>
                                            <?= $p['tipo'] == 'leche' ? 'L' : ($p['tipo'] == 'peso' ? 'kg' : '') ?>
                                        </td>

                                        <td class="text-center">
                                            <?= date('d/m/Y', strtotime($p['fecha'])) ?>
                                        </td>

                                        <td class="text-center">
                                            <a href="edit.php?id=<?= $p['id_produccion'] ?>"
                                                class="btn btn-warning btn-sm">
                                                Editar
                                            </a>

                                            <a href="../../app/controllers/ProduccionController.php?delete=<?= $p['id_produccion'] ?>"
                                                class="btn btn-danger btn-sm"
                                                onclick="return confirm('¿Eliminar este registro?')">
                                                Eliminar
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            <?php endif; ?>

        </main>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
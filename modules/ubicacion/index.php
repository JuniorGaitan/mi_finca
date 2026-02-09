<?php
session_start();
require '../../config/database.php';
require '../../app/models/Ubicacion.php';

$model = new Ubicacion($pdo);
$ubicaciones = $model->listar();

include '../../includes/header.php';
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-3 col-lg-2 p-0">
            <?php include '../../includes/sidebar.php'; ?>
        </div>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <h2 class="mt-4">📍 Historial de Ubicación del Ganado</h2>

            <a href="crear.php" class="btn btn-success mb-3">
                + Registrar Ubicación
            </a>

            <table class="table table-bordered table-hover">
                <thead class="table-dark text-center">
                    <tr>
                        <th>Arete</th>
                        <th>Nombre</th>
                        <th>Potrero</th>
                        <th>Entrada</th>
                        <th>Salida</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ubicaciones as $u): ?>
                        <tr>
                            <td><?= $u['codigo_arete'] ?></td>
                            <td><?= $u['nombre'] ?></td>
                            <td><?= $u['potrero'] ?></td>
                            <td><?= $u['fecha_entrada'] ?></td>
                            <td><?= $u['fecha_salida'] ?? 'Actual' ?></td>
                            <td class="text-center">
                                <a href="edit.php?id=<?= $u['id_ubicacion'] ?>"
                                    class="btn btn-warning btn-sm">Editar</a>

                                <a href="../../app/controllers/UbicacionGanadoController.php?delete=<?= $u['id_ubicacion'] ?>"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('¿Eliminar registro?')">
                                    Eliminar
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        </main>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
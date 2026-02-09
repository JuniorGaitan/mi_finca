<?php
session_start();

require_once '../../config/config.php';
require_once ROOT_PATH . 'config/database.php';
require_once MODELS_PATH . 'Vacuna.php';

$modelo = new Vacuna($pdo);
$vacunas = $modelo->all();

include ROOT_PATH . 'includes/header.php';
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-3 col-lg-2 p-0">
            <?php include '../../includes/sidebar.php'; ?>
        </div>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="card shadow">
                <div class="card-header bg-success text-white d-flex justify-content-between">
                    <span>💉 Vacunas registradas</span>

                    <a href="create.php" class="btn btn-light btn-sm">➕ Nueva</a>

                </div>





                <div class="card-body">



                    <a href="../vacunacion/index.php" class="btn btn-success">
                        <i class="bi bi-eye-fill"></i>Historial Vacunación
                    </a>

                    <table class="table table-bordered table-hover">
                        <thead class="table-success">
                            <tr>
                                <th>Nombre</th>
                                <th>Frecuencia (días)</th>
                                <th>Descripción</th>
                                <th width="120">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($vacunas as $v): ?>
                                <tr>
                                    <td><?= htmlspecialchars($v['nombre']) ?></td>
                                    <td class="text-center"><?= $v['frecuencia_dias'] ?></td>
                                    <td><?= htmlspecialchars($v['descripcion']) ?></td>
                                    <td class="text-center">
                                        <a href="edit.php?id=<?= $v['id_vacuna'] ?>" class="btn btn-warning btn-sm">
                                            ✏️
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                        </tbody>
                    </table>
        </main>
    </div>
</div>
</div>
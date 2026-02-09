<?php
session_start();

require_once '../../config/database.php';
require_once '../../app/models/Ganado.php';

/* 🔐 Protección básica de sesión */

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit;
}

$ganadoModel = new Ganado($pdo);
$ganado = $ganadoModel->listar();

include '../../includes/header.php';
?>


<div class="container-fluid">
    <div class="row">
        <div class="col-md-3 col-lg-2 p-0">
            <?php include '../../includes/sidebar.php'; ?>
        </div>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

            <div class="d-flex justify-content-between align-items-center mt-4">
                <h2 class="mb-0">🐄 Gestión de Ganado</h2>
                <a href="create.php" class="btn btn-success">
                    <i class="bi bi-plus-circle"></i> Nuevo
                </a>


            </div>

            <?php if (empty($ganado)): ?>
                <div class="alert alert-info mt-4">
                    No hay registros de ganado todavía.
                </div>
            <?php else: ?>
                <div class="table-responsive mt-3">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-dark text-center">
                            <tr>
                                <th>Arete</th>
                                <th>Nombre</th>
                                <th>Sexo</th>
                                <th>Raza</th>
                                <th>Peso</th>
                                <th>Estado</th>
                                <th style="width:160px">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($ganado as $g): ?>
                                <tr>
                                    <td><?= htmlspecialchars($g['codigo_arete']) ?></td>
                                    <td><?= htmlspecialchars($g['nombre']) ?></td>
                                    <td class="text-center">
                                        <?= ucfirst(htmlspecialchars($g['sexo'])) ?>
                                    </td>
                                    <td><?= htmlspecialchars($g['raza']) ?></td>
                                    <td class="text-end">
                                        <?= number_format($g['peso_actual'], 2) ?> kg
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-<?= $g['estado'] === 'Activo' ? 'success' : 'secondary' ?>">
                                            <?= htmlspecialchars($g['estado']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-1 flex-wrap">


                                            <a href="edit.php?id=<?= (int)$g['id_ganado'] ?>"
                                                class=" btn btn-sm btn-outline-warning">✏️

                                            </a>
                                            <a href="arbol.php?id=<?= (int)$g['id_ganado'] ?>"
                                                class="btn btn-sm btn-outline-info">🌳

                                            </a>

                                            <a href="../../app/controllers/GanadoController.php?delete=<?= (int)$g['id_ganado'] ?>"
                                                class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('¿Eliminar este ganado?')">
                                                🗑
                                            </a>
                                        </div>

                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>

        </main>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
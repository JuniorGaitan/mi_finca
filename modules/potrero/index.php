<?php
session_start();

require_once '../../config/config.php';
require_once ROOT_PATH . 'config/database.php';
require_once MODELS_PATH . 'Potrero.php';

$modelo = new Potrero($pdo);
$potreros = $modelo->listarTodos();

include ROOT_PATH . 'includes/header.php';
?>

<style>
    /* 🔥 RESET CLAVE */
    html,
    body {
        margin: 0;
        padding: 0;
        overflow-x: hidden;
    }

    .layout {
        display: flex;
        width: 100vw;
        min-height: 100vh;
    }

    /* Sidebar SIN Bootstrap */
    .sidebar-wrapper {
        width: 250px;
        min-width: 250px;
        max-width: 250px;
        margin: 0;
        padding: 0;
    }

    /* Contenido */
    .content-wrapper {
        flex: 1;
        margin: 0;
        padding: 24px;
        background: #f8f9fa;
    }
</style>

<div class="layout">

    <!-- SIDEBAR (aislado de Bootstrap) -->
    <div class="sidebar-wrapper">
        <?php include ROOT_PATH . 'includes/sidebar.php'; ?>
    </div>

    <!-- CONTENIDO -->
    <div class="content-wrapper">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-0">🌿 Gestión de Potreros</h2>
                <p class="text-muted small">Listado y estados de las divisiones</p>
            </div>
            <a href="create.php" class="btn btn-success">
                <i class="bi bi-plus-lg"></i> Nuevo Potrero
            </a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-success text-white">
                        <tr>
                            <th class="ps-4">Nombre</th>
                            <th>Terreno</th>
                            <th>Área</th>
                            <th>Carga</th>
                            <th>Estado</th>
                            <th class="text-center pe-4">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php foreach ($potreros as $p): ?>
                            <?php
                            $status = strtolower($p['estado']);
                            $clase = $status == 'disponible' ? 'success' : ($status == 'en uso' ? 'danger' : 'warning');
                            ?>
                            <tr>
                                <td class="ps-4"><?= htmlspecialchars($p['nombre']) ?></td>
                                <td><?= htmlspecialchars($p['terreno_nombre']) ?></td>
                                <td><?= number_format($p['area'], 2) ?> ha</td>
                                <td><?= $p['capacidad_animales'] ?></td>
                                <td>
                                    <span class="badge bg-<?= $clase ?>">
                                        <?= strtoupper($p['estado']) ?>
                                    </span>
                                </td>
                                <td class="text-center pe-4">
                                    <a href="edit.php?id=<?= $p['id_potrero'] ?>" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
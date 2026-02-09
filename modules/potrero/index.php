<?php
session_start();

require_once '../../config/config.php';
require_once ROOT_PATH . 'config/database.php';
require_once MODELS_PATH . 'Potrero.php';

$modelo = new Potrero($pdo);
$potreros = $modelo->listarTodos();

include ROOT_PATH . 'includes/header.php';
?>


<div class="container-fluid">
    <div class="row">
        <div class="col-md-3 col-lg-2 p-0">
            <?php include '../../includes/sidebar.php'; ?>
        </div>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">


            <!-- CONTENIDO -->
            <div class="content-wrapper">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="fw-bold mb-0">🌿 Gestión de Potreros</h2>
                        <p class="text-muted small">Listado y estados de las divisiones</p>
                    </div>

                    <a href="cardPotrero.php" class="btn btn-success">
                        <i class="bi bi bi-eye-fill"></i> CARD
                    </a>

                    <a href="../ubicacion/index.php" class="btn btn-success">
                        <i class="bi bi bi-eye-fill"></i> VER ROTACION
                    </a>
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
                                            <a href="../../app/controllers/PotreroController.php?delete=<?= (int)$p['id_potrero'] ?>" class="btn btn-sm btn-warning">
                                                <i class="bi bi-trash"></i>
                                            </a>

                                            
                                        </td>



                                    </tr>
                                <?php endforeach; ?>

                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
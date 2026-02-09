<?php
require '../../config/database.php';
require '../../app/models/Ganado.php';
require '../../app/models/Potrero.php';

$ganadoModel = new Ganado($pdo);
$potreroModel = new Potrero($pdo);

$ganados = $ganadoModel->listar();
$potreros = $potreroModel->getPotrerosDisponibles();

include '../../includes/header.php';
?>

<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-success text-white">
            🐄 Movimiento de Ganado por Lote
        </div>

        <div class="card-body">
            <form method="POST" action="../../app/controllers/UbicacionController.php?action=crear">

                <!-- GANADO -->
                <div class="mb-3">
                    <label class="form-label fw-bold">
                        Seleccione el ganado
                    </label>

                    <select name="id_ganado[]"
                        class="form-select"
                        multiple
                        size="8"
                        required>

                        <?php foreach ($ganados as $g): ?>
                            <option value="<?= $g['id_ganado'] ?>">
                                <?= $g['codigo_arete'] ?> - <?= $g['nombre'] ?>
                            </option>
                        <?php endforeach; ?>

                    </select>
                    <div class="form-text">
                        Mantén presionado <kbd>Ctrl</kbd> para seleccionar varios
                    </div>
                </div>

                <!-- POTRERO -->
                <div class="mb-3">
                    <label class="form-label fw-bold">
                        Potrero destino
                    </label>

                    <select name="id_potrero"
                        class="form-select"
                        required>

                        <option value="">Seleccione un potrero</option>
                        <?php foreach ($potreros as $p): ?>
                            <option value="<?= $p['id_potrero'] ?>">
                                <?= $p['nombre'] ?> (<?= $p['estado'] ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- BOTÓN -->
                <div class="text-end">
                    <button class="btn btn-success">
                        📍 Registrar Movimiento
                    </button>
                    <a href="index.php" class="btn btn-secondary">
                        Cancelar
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
<?php
require '../../config/database.php';
require '../../app/models/Ubicacion.php';
require '../../app/models/Ganado.php';
require '../../app/models/Potrero.php';

$ubicacionModel = new Ubicacion($pdo);
$ganadoModel    = new Ganado($pdo);
$potreroModel   = new Potrero($pdo);

// Validar ID
if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$id = (int) $_GET['id'];

// Datos actuales
$ubicacion = $ubicacionModel->obtenerPorId($id);
$ganados   = $ganadoModel->listar();
$potreros  = $potreroModel->listarTodos();

include '../../includes/header.php';
?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">

            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    ✏️ Editar Ubicación
                </div>

                <div class="card-body">
                    <form method="POST"
                        action="../../app/controllers/UbicacionController.php">
                        <input type="hidden" name="action" value="update">
                        <input type="hidden" name="id_ubicacion" value="<?= $ubicacion['id_ubicacion'] ?>">


                        <!-- ID UBICACIÓN -->
                        <input type="hidden"
                            name="id_ubicacion"
                            value="<?= $ubicacion['id_ubicacion'] ?>">

                        <!-- ACTION PARA EDITAR -->
                        <input type="hidden"
                            name="action"
                            value="update">

                        <!-- GANADO -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Ganado
                            </label>
                            <select name="id_ganado"
                                class="form-select"
                                required>

                                <?php foreach ($ganados as $g): ?>
                                    <option value="<?= $g['id_ganado'] ?>"
                                        <?= $g['id_ganado'] == $ubicacion['id_ganado'] ? 'selected' : '' ?>>
                                        <?= $g['codigo_arete'] ?> - <?= $g['nombre'] ?>
                                    </option>
                                <?php endforeach; ?>

                            </select>
                        </div>

                        <!-- POTRERO -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Potrero
                            </label>
                            <select name="id_potrero"
                                class="form-select"
                                required>

                                <?php foreach ($potreros as $p): ?>
                                    <option value="<?= $p['id_potrero'] ?>"
                                        <?= $p['id_potrero'] == $ubicacion['id_potrero'] ? 'selected' : '' ?>>
                                        <?= $p['nombre'] ?>
                                    </option>
                                <?php endforeach; ?>

                            </select>
                        </div>

                        <!-- FECHAS -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">
                                    Fecha de Entrada
                                </label>
                                <input type="date"
                                    name="fecha_entrada"
                                    class="form-control"
                                    value="<?= $ubicacion['fecha_entrada'] ?>"
                                    required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">
                                    Fecha de Salida
                                </label>
                                <input type="date"
                                    name="fecha_salida"
                                    class="form-control"
                                    value="<?= $ubicacion['fecha_salida'] ?>">
                            </div>
                        </div>

                        <!-- BOTONES -->
                        <div class="d-flex justify-content-between mt-4">
                            <a href="index.php" class="btn btn-outline-secondary">
                                Cancelar
                            </a>

                            <button class="btn btn-warning px-4">
                                💾 Actualizar
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
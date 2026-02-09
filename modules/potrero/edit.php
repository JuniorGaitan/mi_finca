<?php
require_once '../../config/config.php';
require_once ROOT_PATH . 'config/database.php';
require_once MODELS_PATH . 'Potrero.php';

$id = $_GET['id'];
$modelo = new Potrero($pdo);
$p = $modelo->obtenerPorId($id);
$terrenos = $modelo->listarTerrenos();

include ROOT_PATH . 'includes/header.php';
?>

<div class="d-flex">
    <?php include ROOT_PATH . 'includes/sidebar.php'; ?>
    <div class="container p-4">
        <div class="card shadow border-0">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Editar Potrero: <?= $p['nombre'] ?></h5>
            </div>
            <div class="card-body">
                <form action="../../app/controllers/PotreroController.php?action=editar" method="POST">
                    <input type="hidden" name="id_potrero" value="<?= $p['id_potrero'] ?>">

                    <div class="mb-3">
                        <label>Terreno</label>
                        <select name="id_terreno" class="form-select">
                            <?php foreach ($terrenos as $t): ?>
                                <option value="<?= $t['id_terreno'] ?>" <?= ($t['id_terreno'] == $p['id_terreno']) ? 'selected' : '' ?>>
                                    <?= $t['nombre'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Nombre</label>
                        <input type="text" name="nombre" class="form-control" value="<?= $p['nombre'] ?>" required>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label>Área (ha)</label>
                            <input type="number" step="0.01" name="area" class="form-control" value="<?= $p['area'] ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label>Capacidad</label>
                            <input type="number"
                                name="capacidad_animales"
                                class="form-control"
                                value="<?= $p['capacidad_animales'] ?>"
                                required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label>Estado</label>
                        <select name="estado" class="form-select">
                            <option value="disponible" <?= ($p['estado'] == 'disponible') ? 'selected' : '' ?>>Disponible</option>
                            <option value="en uso" <?= ($p['estado'] == 'en uso') ? 'selected' : '' ?>>En uso</option>
                            <option value="descanso" <?= ($p['estado'] == 'descanso') ? 'selected' : '' ?>>Descanso</option>
                        </select>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-success">Actualizar Cambios</button>
                        <a href="index.php" class="btn btn-outline-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
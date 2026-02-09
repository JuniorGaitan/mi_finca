<?php
session_start();
require_once '../../config/database.php';
require_once '../../app/models/Ganado.php';

$model = new Ganado($pdo);

$id = $_GET['id'];
$animal = $model->obtener($id);
$madre = $model->obtenerMadre($animal['id_madre']);
$padre = $model->obtenerPadre($animal['id_padre']);
$crias = $model->obtenerCrias($id);

include '../../includes/header.php';
?>

<div class="container mt-4">

    <h3 class="text-center mb-4">📊 Árbol Genealógico</h3>

    <!-- PADRES -->
    <div class="row text-center mb-4">
        <div class="col-md-6">
            <?php if ($madre): ?>
                <div class="card border-danger shadow">
                    <div class="card-body">
                        <h5 class="text-danger">👩 Madre</h5>
                        <strong><?= $madre['codigo_arete'] ?></strong><br>
                        <?= $madre['nombre'] ?><br>
                        <?= $madre['raza'] ?>
                    </div>
                </div>
            <?php else: ?>
                <div class="card bg-light">
                    <div class="card-body text-muted">
                        Madre desconocida
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <div class="col-md-6">
            <?php if ($padre): ?>
                <div class="card border-primary shadow">
                    <div class="card-body">
                        <h5 class="text-primary">👨 Padre</h5>
                        <strong><?= $padre['codigo_arete'] ?></strong><br>
                        <?= $padre['nombre'] ?><br>
                        <?= $padre['raza'] ?>
                    </div>
                </div>
            <?php else: ?>
                <div class="card bg-light">
                    <div class="card-body text-muted">
                        Padre desconocido
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- ANIMAL CENTRAL -->
    <div class="row justify-content-center mb-4">
        <div class="col-md-4">
            <div class="card border-success shadow-lg">
                <div class="card-body text-center">
                    <h5 class="text-success">🐮 Animal</h5>
                    <strong><?= $animal['codigo_arete'] ?></strong><br>
                    <?= $animal['nombre'] ?><br>
                    <?= $animal['raza'] ?><br>
                    <small><?= $animal['fecha_nacimiento'] ?></small>
                </div>
            </div>
        </div>
    </div>

    <!-- CRIAS -->
    <div class="row">
        <h5 class="text-center mb-3">🐣 Crías</h5>

        <?php if ($crias): ?>
            <?php foreach ($crias as $c): ?>
                <div class="col-md-3 mb-3">
                    <div class="card border-warning shadow-sm">
                        <div class="card-body text-center">
                            <strong><?= $c['codigo_arete'] ?></strong><br>
                            <?= $c['nombre'] ?><br>
                            <small><?= $c['fecha_nacimiento'] ?></small>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="text-center text-muted">
                No tiene crías registradas
            </div>
        <?php endif; ?>
    </div>

</div>

<?php include '../../includes/footer.php'; ?>
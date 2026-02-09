<?php
session_start();

require_once '../../config/config.php';
require_once ROOT_PATH . 'config/database.php';
require_once ROOT_PATH . 'app/controllers/VacunacionController.php';

$controller = new VacunacionController($pdo);

// Filtros
$filtros = [
    'buscar' => $_GET['buscar'] ?? null,
    'finca'  => $_GET['finca'] ?? null,
    'ganado' => $_GET['ganado'] ?? null,
];

$historial = $controller->historial($filtros);

// Combos
$ganado = $pdo->query("SELECT id_ganado, codigo_arete FROM ganado")->fetchAll(PDO::FETCH_ASSOC);
$fincas = $pdo->query("SELECT id_finca, nombre FROM finca")->fetchAll(PDO::FETCH_ASSOC);

include ROOT_PATH . 'includes/header.php';





?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-3 col-lg-2 p-0">
            <?php include '../../includes/sidebar.php'; ?>
        </div>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

            <h4>📋 Historial General de Vacunación</h4>



            <form method="GET" class="row mb-3 g-2">

                <div class="col-md-3">
                    <input type="text" name="buscar" class="form-control"
                        placeholder="Buscar por arete o nombre"
                        value="<?= htmlspecialchars($_GET['buscar'] ?? '') ?>">
                </div>

                <div class="col-md-3">
                    <select name="finca" class="form-select">
                        <option value="">Todas las fincas</option>
                        <?php foreach ($fincas as $f): ?>
                            <option value="<?= $f['id_finca'] ?>"
                                <?= ($_GET['finca'] ?? '') == $f['id_finca'] ? 'selected' : '' ?>>
                                <?= $f['nombre'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-3">
                    <select name="ganado" class="form-select">
                        <option value="">Todos los animales</option>
                        <?php foreach ($ganado as $g): ?>
                            <option value="<?= $g['id_ganado'] ?>"
                                <?= ($_GET['ganado'] ?? '') == $g['id_ganado'] ? 'selected' : '' ?>>
                                Arete <?= $g['codigo_arete'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-3">
                    <button class="btn btn-success w-100">🔍 Filtrar</button>
                </div>
               

            </form>


            <table class="table table-bordered table-striped">
                <a href="create.php" class="btn btn-light btn-sm">➕ Nueva</a>

                <thead class="table-success">
                    <tr>
                        <th>Arete</th>
                        <th>Nombre</th>
                        <th>Vacuna</th>
                        <th>Aplicación</th>
                        <th>Próxima</th>
                        <th>Finca</th>
                        <th>Observaciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($historial): ?>
                        <?php foreach ($historial as $h): ?>
                            <tr>
                                <td><?= $h['codigo_arete'] ?></td>
                                <td><?= htmlspecialchars($h['nombre_ganado']) ?></td>
                                <td><?= htmlspecialchars($h['vacuna']) ?></td>
                                <td><?= $h['fecha_aplicacion'] ?></td>
                                <td><?= $h['proxima_fecha'] ?></td>
                                <td><?= htmlspecialchars($h['finca']) ?></td>
                                <td><?= htmlspecialchars($h['observaciones']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted">
                                No hay registros
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </main>
    </div>
</div>

<?php include ROOT_PATH . 'includes/footer.php'; ?>
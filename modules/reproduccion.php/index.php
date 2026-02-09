<?php
session_start();
require_once '../../config/database.php';
require_once '../../app/models/Reproduccion.php';

$model = new Reproduccion($pdo);
$registros = $model->listarPorFinca($_SESSION['id_finca']);

include '../../includes/header.php';
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between mb-3">
        <h3>🐄 Control Reproductivo</h3>
        <a href="create.php" class="btn btn-success">
            ➕ Nueva Reproducción
        </a>
    </div>

    <div class="card shadow">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Hembra</th>
                        <th>Macho</th>
                        <th>Método</th>
                        <th>Monta</th>
                        <th>Prob. Parto</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($registros as $r): ?>
                        <tr>
                            <td><?= $r['arete_hembra'] ?> - <?= $r['nombre_hembra'] ?></td>
                            <td>
                                <?= $r['arete_macho'] ? $r['arete_macho'] . ' - ' . $r['nombre_macho'] : 'Inseminación' ?>
                            </td>
                            <td><?= ucfirst($r['metodo']) ?></td>
                            <td><?= $r['fecha_monta'] ?></td>
                            <td><?= $r['fecha_probable_parto'] ?></td>
                            <td>
                                <span class="badge bg-<?=
                                                        $r['estado'] == 'preñada' ? 'warning' : ($r['estado'] == 'parida' ? 'success' : 'danger')
                                                        ?>">
                                    <?= ucfirst($r['estado']) ?>
                                </span>
                            </td>
                            <td>
                                <a href="edit.php?id=<?= $r['id_reproduccion'] ?>" class="btn btn-sm btn-primary">Editar</a>
                                <a href="../../app/controllers/ReproduccionController.php?delete=<?= $r['id_reproduccion'] ?>"
                                    class="btn btn-sm btn-danger"
                                    onclick="return confirm('¿Eliminar registro?')">
                                    Eliminar
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
<?php
require '../../config/database.php';
include '../../includes/header.php';

$alertas = $pdo->query("SELECT * FROM alertas WHERE estado='pendiente'")->fetchAll();
?>

<h4>🚨 Alertas Pendientes</h4>

<table class="table table-bordered">
    <thead class="table-warning">
        <tr>
            <th>Tipo</th>
            <th>Mensaje</th>
            <th>Fecha</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($alertas as $a): ?>
        <tr>
            <td><?= $a['tipo'] ?></td>
            <td><?= $a['mensaje'] ?></td>
            <td><?= $a['fecha_alerta'] ?></td>
        </tr>
        <?php endforeach ?>
    </tbody>
</table>

<?php include '../../includes/footer.php'; ?>

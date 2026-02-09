<?php include ROOT_PATH . 'includes/header.php'; ?>

<div class="layout">
    <div class="sidebar-wrapper">
        <?php include ROOT_PATH . 'includes/sidebar.php'; ?>
    </div>

    <div class="content-wrapper">
        <h2 class="fw-bold mb-3">🐄 Movimiento de Ganado</h2>

        <form method="POST" action="ubicacion.php?action=procesar">

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th></th>
                        <th>Arete</th>
                        <th>Nombre</th>
                        <th>Sexo</th>
                        <th>Raza</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ganados as $g): ?>
                        <tr>
                            <td>
                                <input type="checkbox" name="ganados[]" value="<?= $g['id_ganado'] ?>">
                            </td>
                            <td><?= $g['codigo_arete'] ?></td>
                            <td><?= $g['nombre'] ?></td>
                            <td><?= $g['sexo'] ?></td>
                            <td><?= $g['raza'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <select name="id_potrero" class="form-select mt-3" required>
                <option value="">Seleccione potrero</option>
                <?php foreach ($potreros as $p): ?>
                    <option value="<?= $p['id_potrero'] ?>">
                        <?= $p['nombre'] ?> (<?= $p['estado'] ?>)
                    </option>
                <?php endforeach; ?>
            </select>

            <button class="btn btn-success mt-3">Mover Ganado</button>
        </form>
    </div>
</div>
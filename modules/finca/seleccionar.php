<h4>Seleccionar finca</h4>

<?php foreach ($_SESSION['fincas_disponibles'] as $f): ?>
    <a href="seleccionar_finca.php?id_finca=<?= $f['id_finca'] ?>"
        class="btn btn-outline-primary mb-2">
        <?= htmlspecialchars($f['nombre']) ?>
    </a><br>
<?php endforeach; ?>
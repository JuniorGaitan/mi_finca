<?php
session_start();
require_once '../../config/config.php';
require_once ROOT_PATH . 'config/database.php';
require_once MODELS_PATH . 'Potrero.php';
include '../../includes/header.php';


?>
<div class="container-fluid p-0">
    <div class="d-flex">
        <div class="flex-shrink-0" style="width: 250px; min-height: 100vh;">
            <?php include ROOT_PATH . 'includes/sidebar.php'; ?>
        </div>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 bg-light">

            <h2 class="mt-4">➕ Nuevo Animal</h2>

            <form method="POST" action="../../app/controllers/GanadoController.php" class="mt-3">
                <input type="hidden" name="action" value="crear">
                <div class="row">
                    <div class="col-md-4">
                        <label>Arete</label>
                        <input type="text" name="codigo_arete" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label>Nombre</label>
                        <input type="text" name="nombre" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label>Sexo</label>
                        <select name="sexo" class="form-control">
                            <option value="macho">Macho</option>
                            <option value="hembra">Hembra</option>
                        </select>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-4">
                        <label>Raza</label>
                        <input type="text" name="raza" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label>Fecha Nacimiento</label>
                        <input type="date" name="fecha_nacimiento" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label>Peso (kg)</label>
                        <input type="number" step="0.01" name="peso_actual" class="form-control">
                    </div>
                </div>

                <button class="btn btn-success mt-4">Guardar</button>
                <a href="index.php" class="btn btn-secondary mt-4">Cancelar</a>
            </form>
        </main>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
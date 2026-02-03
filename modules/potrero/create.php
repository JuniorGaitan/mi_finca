<?php
session_start();
require_once '../../config/config.php';
require_once ROOT_PATH . 'config/database.php';
require_once MODELS_PATH . 'Potrero.php';

$modelo = new Potrero($pdo);
$fincas = $modelo->listarFincas();


include ROOT_PATH . 'includes/header.php';
?>

<div class="container-fluid p-0">
    <div class="d-flex">
        <div class="flex-shrink-0" style="width: 250px; min-height: 100vh;">
            <?php include ROOT_PATH . 'includes/sidebar.php'; ?>
        </div>

        <div class="flex-grow-1 bg-light">
            <main class="p-4">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Potreros</a></li>
                        <li class="breadcrumb-item active">Nuevo Potrero</li>
                    </ol>
                </nav>
                <?php if (isset($_GET['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show mx-auto" style="max-width: 800px;" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        Hubo un error al guardar el potrero. Por favor, intente de nuevo.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <div class="card shadow-sm border-0 mx-auto" style="max-width: 800px;">
                    <div class="card-header bg-success text-white py-3">
                        <h5 class="mb-0"><i class="bi bi-plus-circle me-2"></i>Registrar Nuevo Potrero</h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="../../app/controllers/PotreroController.php?action=crear" method="POST">

                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label fw-bold">Finca</label>
                                    <select id="finca" name="id_finca" class="form-select border-2" required>
                                        <option value="" disabled selected>Seleccione la finca...</option>
                                        <?php foreach ($fincas as $f): ?>
                                            <option value="<?= $f['id_finca'] ?>">
                                                <?= htmlspecialchars($f['nombre']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="form-label fw-bold">Terreno</label>
                                    <select id="terreno" name="id_terreno" class="form-select border-2" required>
                                        <option value="" disabled selected>Seleccione primero una finca...</option>
                                    </select>
                                </div>


                                <div class="col-md-12 mb-3">
                                    <label class="form-label fw-bold">Nombre del Potrero</label>
                                    <input type="text" name="nombre" class="form-control border-2" placeholder="Ej: Lote Norte" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Área (Hectáreas)</label>
                                    <input type="number" step="0.01" name="area" class="form-control border-2" placeholder="0.00" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Capacidad (Animales)</label>
                                    <input type="number" name="capacidad" class="form-control border-2" placeholder="Ej: 20" required>
                                </div>
                            </div>

                            <hr class="my-4">

                            <div class="d-flex justify-content-end gap-2">
                                <a href="index.php" class="btn btn-outline-secondary px-4">Cancelar</a>
                                <button type="submit" class="btn btn-success px-5 shadow-sm">
                                    <strong>Guardar Potrero</strong>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>
</div>
<script>
    document.getElementById('finca').addEventListener('change', function() {
        const idFinca = this.value; // Nombre corregido
        const terrenoSelect = document.getElementById('terreno');

        if (!idFinca) return;

        // 1. Mostrar estado de carga
        terrenoSelect.innerHTML = '<option value="">Cargando terrenos...</option>';

        // 2. Hacer la petición al controlador
        // Asegúrate de que la ruta al controlador sea correcta desde la carpeta donde estás
        fetch('../../app/controllers/PotreroController.php?action=terrenosPorFinca&id_finca=' + idFinca)
            .then(res => {
                if (!res.ok) throw new Error('Error en la red');
                return res.json();
            })
            .then(data => {
                // 3. Limpiar y llenar el select
                terrenoSelect.innerHTML = '<option value="" disabled selected>Seleccione un terreno...</option>';

                if (!data || data.length === 0) {
                    terrenoSelect.innerHTML = '<option value="">No hay terrenos en esta finca</option>';
                    return;
                }

                data.forEach(t => {
                    const option = document.createElement('option');
                    option.value = t.id_terreno;
                    option.textContent = t.nombre;
                    terrenoSelect.appendChild(option);
                });
            })
            .catch(err => {
                console.error('Error Fetch:', err);
                terrenoSelect.innerHTML = '<option value="">Error al cargar terrenos</option>';
            });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
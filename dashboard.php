<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit;
}
include 'includes/header.php';
?>

<main class="app-content">

    <!-- MOBILE TOGGLE -->
    <div class="d-flex d-md-none justify-content-between align-items-center mb-4">
        <h5 class="fw-bold mb-0">📊 Panel</h5>
        <button id="btnToggleSidebar"
            class="btn btn-outline-secondary d-md-none mb-4">
            <i class="bi bi-list"></i>
        </button>


    </div>

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0">📊 Panel Principal</h2>
            <small class="text-muted">Resumen general del sistema</small>
        </div>

        <div class="d-none d-md-flex align-items-center gap-2">
            <a href="seleccionar.php" class="btn btn-outline-secondary">
                🔄 Cambiar terreno
            </a>
            <span class="badge bg-success px-3 py-2">
                <i class="bi bi-person-circle me-1"></i>
                <?= htmlspecialchars($_SESSION['usuario']['nombre'] ?? 'Usuario') ?>
            </span>

        </div>
    </div>



    <!-- DASHBOARD CARDS -->
    <div class="row g-4 mt-3">

        <!-- GANADO -->
        <div class="col-12 col-md-6 col-lg-3">
            <a href="/mi_finca/modules/ganado/index.php"
                class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 hover-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="icon-box bg-success text-white">
                                <i class="bi bi-cow"></i>
                            </div>
                            <h5 class="fw-bold mb-0 ms-3">Ganado</h5>
                        </div>
                        <p class="text-muted small mb-0">
                            Gestión y control del hato
                        </p>
                    </div>
                </div>
            </a>
        </div>

        <!-- POTREROS -->
        <div class="col-12 col-md-6 col-lg-3">
            <a href="/mi_finca/modules/potrero/index.php"
                class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 hover-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="icon-box bg-warning text-dark">
                                <i class="bi bi-tree"></i>
                            </div>
                            <h5 class="fw-bold mb-0 ms-3">Potreros</h5>
                        </div>
                        <p class="text-muted small mb-0">
                            Rotación y estados
                        </p>
                    </div>
                </div>
            </a>
            <a href="modules/potrero/cardPotrero.php" class="btn btn-success">
                🗺️ Ver croquis de potreros
            </a>
        </div>

        <!-- movimientos -->
        <div class="col-12 col-md-6 col-lg-3">
            <a href="/mi_finca/modules/ubicacion/index.php "
                class=" text-decoration-none">

                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="icon-box bg-primary text-white">
                                <i class="bi bi-bar-chart"></i>
                            </div>
                            <h5 class="fw-bold mb-0 ms-3">Movimientos</h5>
                        </div>
                        <p class="text-muted small mb-2">
                            en desarrollo
                        </p>
                        <span class="badge bg-secondary">En desarrollo</span>


                    </div>
                </div>
        </div>

        <!-- movimientos -->
        <div class="col-12 col-md-6 col-lg-3">
            <a href="/mi_finca/modules/vacunas/index.php "
                class=" text-decoration-none">

                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="icon-box bg-primary text-white">
                                <i class="bi bi-bar-chart"></i>
                            </div>
                            <h5 class="fw-bold mb-0 ms-3">Vacunas</h5>
                        </div>
                        <p class="text-muted small mb-2">
                            en desarrollo
                        </p>
                        <span class="badge bg-secondary">En desarrollo</span>


                    </div>
                </div>
        </div>
        <!-- REPORTES -->
        <div class="col-12 col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-box bg-primary text-white">
                            <i class="bi bi-bar-chart"></i>
                        </div>
                        <h5 class="fw-bold mb-0 ms-3">Reportes</h5>
                    </div>
                    <p class="text-muted small mb-2">
                        Próximamente
                    </p>
                    <span class="badge bg-secondary">En desarrollo</span>
                    <a href="/mi_finca/modules/ubicacion/index.php">
                        Movimiento de Ganado
                    </a>


                </div>
            </div>
        </div>

        <!-- CONFIG -->
        <div class="col-12 col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-box bg-dark text-white">
                            <i class="bi bi-gear"></i>
                        </div>
                        <h5 class="fw-bold mb-0 ms-3">Configuración</h5>
                    </div>
                    <p class="text-muted small mb-0">
                        Ajustes del sistema
                    </p>
                </div>
            </div>
        </div>

    </div>

</main>


</div>

<?php include 'includes/footer.php'; ?>
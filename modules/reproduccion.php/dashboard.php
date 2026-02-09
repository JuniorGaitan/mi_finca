<?php
session_start();
require_once '../../config/database.php';
require_once '../../app/models/Reproduccion.php';

$model = new Reproduccion($pdo);
$stats = $model->estadisticas();

include '../../includes/header.php';
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-3 col-lg-2 p-0">
            <?php include '../../includes/sidebar.php'; ?>
        </div>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

            <h2 class="mt-4">📊 Dashboard Reproductivo</h2>

            <div class="row mt-4">

                <div class="col-md-4">
                    <div class="card text-white bg-primary shadow">
                        <div class="card-body text-center">
                            <h5>Preñadas</h5>
                            <h2><?= $stats['prenadas'] ?></h2>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card text-white bg-success shadow">
                        <div class="card-body text-center">
                            <h5>Paridas</h5>
                            <h2><?= $stats['paridas'] ?></h2>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card text-white bg-danger shadow">
                        <div class="card-body text-center">
                            <h5>Fallidas</h5>
                            <h2><?= $stats['fallidas'] ?></h2>
                        </div>
                    </div>
                </div>

            </div>

        </main>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
<?php session_start(); ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Login</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-success bg-opacity-10">

    <div class="container vh-100 d-flex justify-content-center align-items-center">
        <div class="card shadow" style="width: 22rem;">
            <div class="card-body">
                <h4 class="text-center mb-3">🐄 Mi Finca</h4>

                <div class="card shadow">
                    <div class="card-header text-center bg-success text-white py-3">
                        <div>
                            <h4 class="mb-0">Iniciar sesion</h4>
                        </div>

                    </div>

                    <div class="card-body">

                        <?php if (!empty($_SESSION['error_login'])): ?>
                            <div class="alert alert-danger">
                                <?= $_SESSION['error_login']; ?>
                            </div>
                        <?php unset($_SESSION['error_login']);
                        endif; ?>

                        <form method="POST" action="./app/controllers/AuthController.php">


                            <div class="mb-3">
                                <label class="form-label">Usuario</label>
                                <input type="text" name="usuario" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Contraseña</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>

                            <button class="btn btn-success w-100">
                                Ingresar
                            </button>

                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>

</body>

</html>
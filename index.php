<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ingreso - Mi Finca</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-success bg-opacity-10">

<div class="container vh-100 d-flex justify-content-center align-items-center">
    <div class="card shadow" style="width: 22rem;">
        <div class="card-body">
            <h4 class="text-center mb-3">🐄 Mi Finca</h4>

            <form method="POST" action="auth/login.php">
                <div class="mb-3">
                    <label>Usuario</label>
                    <input type="text" name="usuario" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Contraseña</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <button class="btn btn-success w-100">
                    Ingresar
                </button>
            </form>
        </div>
    </div>
</div>

</body>
</html>

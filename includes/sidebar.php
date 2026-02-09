<?php
$path = $_SERVER['REQUEST_URI'];

function isActive($route)
{
    return strpos($_SERVER['REQUEST_URI'], $route) !== false ? 'active' : '';
}
?>

<aside id="sidebar" class="app-sidebar">


    <div class="sidebar-header">
        🌱 <strong>Mi Finca</strong>
    </div>

    <nav class="sidebar-menu">

        <a class="sidebar-link <?= isActive('dashboard.php') ?>"
            href="/mi_finca/dashboard.php">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>

        <a class="sidebar-link <?= isActive('modules/ganado') ?>"
            href="/mi_finca/modules/ganado/index.php">
            <i class="bi bi-cow"></i> Ganado
        </a>

        <a class="sidebar-link <?= isActive('modules/potrero') ?>"
            href="/mi_finca/modules/potrero/index.php">
            <i class="bi bi-tree"></i> Potreros
        </a>
        <a class="sidebar-link <?= isActive('') ?>"
            href="#">
            <i class="bi bi-tree"></i> Producción/Pendiente
        </a>
        <a class="sidebar-link <?= isActive('modules/potrero') ?>"
            href="/mi_finca/modules/vacunas/index.php">
            <i class="bi bi-tree"></i> Vacunas / tratamientos
        </a>
        
        <a class="sidebar-link <?= isActive('modules/ubicacion') ?>"
            href="/mi_finca/modules/ubicacion/index.php">
            <i class="bi bi-tree"></i> Movimientos Ganado
        </a>
        
        <a class="sidebar-link <?= isActive('') ?>"
            href="/mi_finca/modules/potrero/index.php">
            <i class="bi bi-tree"></i> Reportes/pendiente
        </a>

        <hr>

        <a class="sidebar-link text-danger"
            href="/mi_finca/auth/logout.php"
            onclick="return confirm('¿Cerrar sesión?')">
            <i class="bi bi-box-arrow-right"></i> Salir
        </a>

    </nav>

</aside>
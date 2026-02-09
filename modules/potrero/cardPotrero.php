<?php

session_start();

if (!isset($_SESSION['id_finca'])) {
    die("No hay finca seleccionada.");
}

if (!isset($_SESSION['id_terreno'])) {
    die("No hay terreno seleccionado.");
}

$id_terreno = $_SESSION['id_terreno'];

require_once '../../config/config.php';
require_once ROOT_PATH . 'config/database.php';
require_once MODELS_PATH . 'Potrero.php';

$modelo = new Potrero($pdo);
$potreros = $modelo->obtenerPotrerosConAnimales($id_terreno);

include ROOT_PATH . 'includes/header.php';
?>

<div class="container mt-4">
    <h4 class="mb-3">🗺️ Croquis interactivo de la finca</h4>

    <div class="mb-3">
        🟢 Disponible &nbsp;&nbsp;
        🟡 En uso &nbsp;&nbsp;
        🔵 Descanso
    </div>

    <svg viewBox="0 0 1000 600" class="mapa-svg" id="mapa">

        <?php foreach ($potreros as $p): ?>
            <?php
            $color = '#2196F3';
            if ($p['estado'] == 'disponible') $color = '#4CAF50';
            if ($p['estado'] == 'en uso') $color = '#FFC107';
            ?>

            <g class="potrero"
                data-id="<?= $p['id_potrero'] ?>"
                transform="translate(<?= $p['x'] ?>, <?= $p['y'] ?>)"
                oncontextmenu="moverGanado(event, <?= $p['id_potrero'] ?>)">

                <rect width="150" height="90" rx="12"
                    fill="<?= $color ?>" class="potrero-animado" />

                <text x="10" y="25" class="potrero-text">
                    <?= $p['nombre'] ?>
                </text>

                <text x="10" y="45" class="potrero-text small">
                    🐄 <?= $p['animales_actuales'] ?>/<?= $p['capacidad_animales'] ?>
                </text>
            </g>
        <?php endforeach; ?>

    </svg>
</div>

<script src="https://d3js.org/d3.v7.min.js"></script>

<script>
    const svg = d3.select("#mapa");

    svg.selectAll(".potrero")
        .each(function() {
            // Guardamos posición inicial
            const transform = d3.select(this).attr("transform");
            const match = /translate\(([^,]+),\s*([^)]+)\)/.exec(transform);
            this._x = match ? parseFloat(match[1]) : 0;
            this._y = match ? parseFloat(match[2]) : 0;
        })
        .call(
            d3.drag()

            .on("start", function(event) {
                this._startX = event.x;
                this._startY = event.y;
            })

            .on("drag", function(event) {
                const dx = event.x - this._startX;
                const dy = event.y - this._startY;

                const newX = this._x + dx;
                const newY = this._y + dy;

                d3.select(this)
                    .attr("transform", `translate(${newX}, ${newY})`);
            })

            .on("end", function(event) {
                const dx = event.x - this._startX;
                const dy = event.y - this._startY;

                this._x += dx;
                this._y += dy;

                fetch("guardar_posicion_potrero.php", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({
                            id_potrero: this.dataset.id,
                            x: Math.round(this._x),
                            y: Math.round(this._y)
                        })
                    })
                    .then(r => r.text())
                    .then(console.log);
            })
        );

    function moverGanado(e, id) {
        e.preventDefault();
        if (confirm("¿Mover ganado desde este potrero?")) {
            window.location.href = "mover_ganado.php?id=" + id;
        }
    }
</script>
<?php
require_once __DIR__ . '/../models/Vacunacion.php';

class VacunacionController
{

    private $model;

    public function __construct($pdo)
    {
        $this->model = new Vacunacion($pdo);
    }



  

    public function historial($filtros = []) {
        return $this->model->filtrar($filtros);
    }

    public function store($post) {
        $this->model->create([
            $post['ganado'],
            $post['vacuna'],
            $post['fecha'],
            $post['proxima'],
            $post['obs']
        ]);

        header("Location: historial.php");
    }

    public function filtrar($buscar)
    {
        return $this->model->filtrar($buscar);
    }
}

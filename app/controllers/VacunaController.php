<?php
require_once __DIR__ . '/../models/Vacuna.php';

class VacunaController
{

    private $model;

    public function __construct($pdo)
    {
        $this->model = new Vacuna($pdo);
    }

    public function index()
    {
        return $this->model->all();
    }

    public function store($post)
    {
        $this->model->create([
            $post['nombre'],
            $post['descripcion'],
            $post['frecuencia_dias']
        ]);
        header("Location: index.php");
        exit;
    }

    public function show($id)
    {
        return $this->model->find($id);
    }

    public function update($id, $post)
    {
        $this->model->update($id, [
            $post['nombre'],
            $post['descripcion'],
            $post['frecuencia_dias']
        ]);
        header("Location: index.php");
        exit;
    }
}

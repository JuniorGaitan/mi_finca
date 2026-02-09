<?php
require_once 'BaseModel.php';

class Tratamiento extends BaseModel {

    public function all() {
        return $this->db->query("SELECT * FROM tratamientos")->fetchAll();
    }

    public function aplicar($data) {
        $sql = "INSERT INTO tratamiento_ganado
        (id_ganado, id_tratamiento, fecha, dosis, observaciones)
        VALUES (?, ?, ?, ?, ?)";
        return $this->db->prepare($sql)->execute($data);
    }
}

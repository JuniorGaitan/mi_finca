<?php
require_once 'BaseModel.php';

class Alerta extends BaseModel {

    public function pendientes() {
        return $this->db->query(
            "SELECT * FROM alertas WHERE estado='pendiente'"
        )->fetchAll();
    }

    public function crear($tipo, $ref, $mensaje) {
        $sql = "INSERT INTO alertas
        (tipo, referencia_id, mensaje, fecha_alerta, estado)
        VALUES (?, ?, ?, NOW(), 'pendiente')";
        return $this->db->prepare($sql)->execute([
            $tipo, $ref, $mensaje
        ]);
    }
}

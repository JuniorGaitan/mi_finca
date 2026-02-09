<?php

class Terreno {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function obtenerTerrenosPorFinca($id_finca) {
        $sql = "SELECT * FROM terreno WHERE id_finca = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id_finca]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

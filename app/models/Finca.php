<?php
class Finca
{

    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function obtenerFincasPorUsuario($id_usuario)
    {
        $sql = "
            SELECT f.id_finca, f.nombre
            FROM finca f
            INNER JOIN usuario_fincas uf ON uf.id_finca = f.id_finca
            WHERE uf.id_usuario = ?
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id_usuario]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

<?php


class Vacuna 
{
    private $db;

    public function __construct($pdo)
    {
        $this->db = $pdo;
    }

    public function all()
    {
        $sql = "SELECT id_vacuna, nombre, descripcion, frecuencia_dias 
                FROM vacunas";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $sql = "INSERT INTO vacunas (nombre, descripcion, frecuencia_dias)
                VALUES (?, ?, ?)";
        return $this->db->prepare($sql)->execute($data);
    }

    public function find($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM vacunas WHERE id_vacuna=?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function update($id, $data)
    {
        $sql = "UPDATE vacunas 
            SET nombre = ?, descripcion = ?, frecuencia_dias = ?
            WHERE id_vacuna = ?";

        $params = array_merge($data, [$id]);
        return $this->db->prepare($sql)->execute($params);
    }
}

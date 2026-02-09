<?php
class Ganado
{
    private $db;

    public function __construct($pdo)
    {
        $this->db = $pdo;
    }

    // LISTAR TODO EL GANADO
    public function listar()
    {
        $sql = "SELECT * FROM ganado ORDER BY id_ganado DESC";
        return $this->db->query($sql)->fetchAll();
    }

    // CREAR NUEVO REGISTRO
    public function crear($data)
    {
        $sql = "INSERT INTO ganado
        (codigo_arete, nombre, sexo, raza, fecha_nacimiento, id_madre, id_padre, origen)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['codigo_arete'],
            $data['nombre'],
            $data['sexo'],
            $data['raza'],
            $data['fecha_nacimiento'],
            $data['id_madre'] ?? null,
            $data['id_padre'] ?? null,
            $data['origen'] ?? 'comprado'
        ]);
    }


    // OBTENER UN SOLO ANIMAL POR ID
    public function obtenerPorId($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM ganado WHERE id_ganado = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // ACTUALIZAR
    public function actualizar($id, $data)
    {
        $sql = "UPDATE ganado SET codigo_arete=?, nombre=?, sexo=?, raza=?, fecha_nacimiento=?, peso_actual=? 
                WHERE id_ganado=?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['codigo_arete'],
            $data['nombre'],
            $data['sexo'],
            $data['raza'],
            $data['fecha_nacimiento'],
            $data['peso_actual'],
            $id
        ]);
    }

    // ELIMINAR
    public function eliminar($id)
    {
        $stmt = $this->db->prepare("DELETE FROM ganado WHERE id_ganado = ?");
        return $stmt->execute([$id]);
    }

    // Obtener animal
    public function obtener($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM ganado WHERE id_ganado = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Obtener madre
    public function obtenerMadre($id_madre)
    {
        if (!$id_madre) return null;

        $stmt = $this->db->prepare("SELECT * FROM ganado WHERE id_ganado = ?");
        $stmt->execute([$id_madre]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Obtener padre
    public function obtenerPadre($id_padre)
    {
        if (!$id_padre) return null;

        $stmt = $this->db->prepare("SELECT * FROM ganado WHERE id_ganado = ?");
        $stmt->execute([$id_padre]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Obtener crías
    public function obtenerCrias($id)
    {
        $stmt = $this->db->prepare("
        SELECT * FROM ganado 
        WHERE id_madre = ? OR id_padre = ?
    ");
        $stmt->execute([$id, $id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

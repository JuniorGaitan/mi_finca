<?php
class Ubicacion
{
    private $db;

    public function __construct($pdo)
    {
        $this->db = $pdo;
    }

    // LISTAR HISTORIAL
    public function listar()
    {
        $sql = "
            SELECT ug.*, 
                   g.codigo_arete, g.nombre,
                   p.nombre AS potrero
            FROM ubicacion_ganado ug
            JOIN ganado g ON ug.id_ganado = g.id_ganado
            JOIN potrero p ON ug.id_potrero = p.id_potrero
            ORDER BY ug.fecha_salida ASC
        ";
        return $this->db->query($sql)->fetchAll();
    }

    // CREAR
    public function crear($data)
    {
        $sql = "INSERT INTO ubicacion_ganado 
                (id_ganado, id_potrero, fecha_entrada, fecha_salida)
                VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['id_ganado'],
            $data['id_potrero'],
            $data['fecha_entrada'],
            $data['fecha_salida']
        ]);
    }

    // OBTENER POR ID
    public function obtenerPorId($id)
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM ubicacion_ganado WHERE id_ubicacion = ?"
        );
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // ACTUALIZAR
    public function actualizar($id, $id_ganado, $id_potrero, $fecha_entrada, $fecha_salida)
    {
        $sql = "UPDATE ubicacion_ganado 
            SET id_ganado=?, id_potrero=?, fecha_entrada=?, fecha_salida=?
            WHERE id_ubicacion=?";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            $id_ganado,
            $id_potrero,
            $fecha_entrada,
            $fecha_salida ?: null,
            $id
        ]);
    }


    // ELIMINAR
    public function eliminar($id)
    {
        $stmt = $this->db->prepare(
            "DELETE FROM ubicacion_ganado WHERE id_ubicacion = ?"
        );
        return $stmt->execute([$id]);
    }

    // 🔁 Cerrar ubicación activa
    public function cerrarUbicacionActiva($id_ganado)
    {
        $sql = "UPDATE ubicacion_ganado
                SET fecha_salida = CURDATE()
                WHERE id_ganado = ?
                AND fecha_salida IS NULL";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id_ganado]);
    }

    // ➕ Registrar nueva ubicación
    public function registrarEntrada($id_ganado, $id_potrero)
    {
        $sql = "INSERT INTO ubicacion_ganado
                (id_ganado, id_potrero, fecha_entrada)
                VALUES (?, ?, CURDATE())";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id_ganado, $id_potrero]);
    }
}

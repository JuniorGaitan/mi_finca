<?php
class Potrero
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    /* =========================
       POTREROS (Escritura)
    ========================= */

    public function guardar($id_terreno, $nombre, $area, $capacidad)
    {
        // ELIMINÉ el código de redirección (header) de aquí. 
        // El modelo solo debe devolver TRUE o FALSE. El controlador decide a dónde ir.
        $sql = "INSERT INTO potrero (id_terreno, nombre, area, capacidad_animales, estado, dias_descanso) 
                VALUES (?, ?, ?, ?, 'disponible', 30)";
        return $this->pdo->prepare($sql)->execute([$id_terreno, $nombre, $area, $capacidad]);
    }

    public function actualizar($id, $data)
    {
        $sql = "UPDATE potrero 
            SET nombre = ?, area = ?, capacidad_animales = ?, estado = ?
            WHERE id_potrero = ?";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $data['nombre'],
            $data['area'],
            $data['capacidad'],
            $data['estado'],
            $id
        ]);
    }

    public function eliminar($id)
    {
        $sql = "DELETE FROM potrero WHERE id_potrero = ?";
        return $this->pdo->prepare($sql)->execute([$id]);
    }

    /* =========================
       POTREROS (Lectura)
    ========================= */

    public function listarTodos()
    {
        // Esta consulta es excelente porque trae los nombres de Finca y Terreno de una vez
        $sql = "SELECT p.*, 
                       t.nombre AS terreno_nombre,
                       f.nombre AS finca_nombre
                FROM potrero p
                INNER JOIN terreno t ON p.id_terreno = t.id_terreno
                INNER JOIN finca f ON t.id_finca = f.id_finca
                ORDER BY f.nombre, t.nombre, p.nombre";

        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId($id)
    {
        $sql = "SELECT * FROM potrero WHERE id_potrero = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /* =========================
       FINCAS Y TERRENOS (Para Selectores)
    ========================= */

    public function listarFincas()
    {
        $sql = "SELECT id_finca, nombre FROM finca ORDER BY nombre";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarTerrenosPorFinca($id_finca)
    {
        $sql = "SELECT id_terreno, nombre 
                FROM terreno 
                WHERE id_finca = ?
                ORDER BY nombre";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id_finca]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

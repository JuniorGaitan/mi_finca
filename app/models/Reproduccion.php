<?php
class Reproduccion
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // 🔹 Listar por finca
    public function listarPorFinca($id_finca)
    {
        $sql = "SELECT r.*,
                       h.codigo_arete AS arete_hembra,
                       h.nombre AS nombre_hembra,
                       m.codigo_arete AS arete_macho,
                       m.nombre AS nombre_macho
                FROM reproduccion r
                INNER JOIN ganado h ON r.id_hembra = h.id_ganado
                LEFT JOIN ganado m ON r.id_macho = m.id_ganado
                INNER JOIN ubicacion_ganado ug ON h.id_ganado = ug.id_ganado
                INNER JOIN potrero p ON ug.id_potrero = p.id_potrero
                INNER JOIN terreno t ON p.id_terreno = t.id_terreno
                WHERE t.id_finca = ?
                AND ug.fecha_salida IS NULL
                ORDER BY r.fecha_monta DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id_finca]);
        return $stmt->fetchAll();
    }

    // 🔹 Crear
    public function crear($data)
    {
        $sql = "INSERT INTO reproduccion
                (id_hembra, id_macho, metodo, fecha_monta, fecha_probable_parto, estado)
                VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $data['id_hembra'],
            $data['id_macho'] ?: null,
            $data['metodo'],
            $data['fecha_monta'],
            $data['fecha_probable_parto'],
            $data['estado']
        ]);
    }

    // 🔹 Obtener uno
    public function obtener($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM reproduccion WHERE id_reproduccion=?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // 🔹 Actualizar
    public function actualizar($data)
    {
        $sql = "UPDATE reproduccion SET
            id_hembra=?,
            id_macho=?,
            metodo=?,
            fecha_monta=?,
            fecha_probable_parto=?,
            estado=?
            WHERE id_reproduccion=?";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            $data['id_hembra'] ?? null,
            !empty($data['id_macho']) ? $data['id_macho'] : null,
            $data['metodo'],
            $data['fecha_monta'],
            $data['fecha_probable_parto'],
            $data['estado'],
            $data['id_reproduccion']
        ]);
    }


    // 🔹 Eliminar
    public function eliminar($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM reproduccion WHERE id_reproduccion=?");
        return $stmt->execute([$id]);
    }

    public function estadisticas()
    {
        $sql = "SELECT 
        SUM(estado='preñada') as prenadas,
        SUM(estado='parida') as paridas,
        SUM(estado='fallida') as fallidas
        FROM reproduccion";

        return $this->pdo->query($sql)->fetch();
    }

    public function hembraPreñada($id_hembra)
    {
        $sql = "SELECT COUNT(*) FROM reproduccion
            WHERE id_hembra = ?
            AND estado = 'preñada'";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id_hembra]);
        return $stmt->fetchColumn();
    }
}

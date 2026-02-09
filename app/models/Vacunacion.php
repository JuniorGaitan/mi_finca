<?php


class Vacunacion
{
    private $db;

    public function __construct($pdo)
    {
        $this->db = $pdo;
    }

    public function allByGanado($idGanado)
    {
        $sql = "SELECT v.nombre, vg.*
                FROM vacunacion_ganado vg
                JOIN vacunas v ON v.id_vacuna = vg.id_vacuna
                WHERE vg.id_ganado=?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$idGanado]);
        return $stmt->fetchAll();
    }

    public function create($data)
    {
        $sql = "INSERT INTO vacunacion_ganado
        (id_ganado, id_vacuna, fecha_aplicacion, proxima_fecha, observaciones)
        VALUES (?, ?, ?, ?, ?)";
        return $this->db->prepare($sql)->execute($data);
    }


    // HISTORIAL COMPLETO (con filtros opcionales)
    public function historialGeneral($filtros = [])
    {
        $sql = "SELECT 
                    vg.id_vacunacion,
                    vg.fecha_aplicacion,
                    vg.proxima_fecha,
                    vg.observaciones,
                    v.nombre AS vacuna,
                    g.codigo_arete,
                    g.nombre AS nombre_ganado,
                    f.nombre AS finca
                FROM vacunacion_ganado vg
                JOIN vacunas v ON v.id_vacuna = vg.id_vacuna
                JOIN ganado g ON g.id_ganado = vg.id_ganado
                LEFT JOIN ubicacion_ganado ug ON ug.id_ganado = g.id_ganado 
                    AND ug.fecha_salida IS NULL
                LEFT JOIN potrero p ON p.id_potrero = ug.id_potrero
                LEFT JOIN terreno t ON t.id_terreno = p.id_terreno
                LEFT JOIN finca f ON f.id_finca = t.id_finca
                WHERE 1 ";

        $params = [];

        if (!empty($filtros['buscar'])) {
            $sql .= " AND (g.codigo_arete LIKE ? OR g.nombre LIKE ?) ";
            $params[] = '%' . $filtros['buscar'] . '%';
            $params[] = '%' . $filtros['buscar'] . '%';
        }

        if (!empty($filtros['finca'])) {
            $sql .= " AND f.id_finca = ? ";
            $params[] = $filtros['finca'];
        }

        if (!empty($filtros['ganado'])) {
            $sql .= " AND g.id_ganado = ? ";
            $params[] = $filtros['ganado'];
        }

        $sql .= " ORDER BY vg.fecha_aplicacion DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }




    public function all()
    {
        $sql = "SELECT v.*, 
                       g.codigo_arete, 
                       g.nombre AS nombre_ganado,
                       f.nombre AS finca,
                       va.nombre AS vacuna
                FROM vacunaciones v
                JOIN ganado g ON g.id_ganado = v.id_ganado
                JOIN fincas f ON f.id_finca = g.id_finca
                JOIN vacunas va ON va.id_vacuna = v.id_vacuna
                ORDER BY v.fecha_aplicacion DESC";

        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }


    public function filtrar($filtros = [])
    {
        $sql = "SELECT vg.*, 
                   g.codigo_arete,
                   g.nombre AS nombre_ganado,
                   f.nombre AS finca,
                   va.nombre AS vacuna
            FROM vacunacion_ganado vg
            JOIN ganado g ON g.id_ganado = vg.id_ganado
            JOIN vacunas va ON va.id_vacuna = vg.id_vacuna
            LEFT JOIN ubicacion_ganado ug ON ug.id_ganado = g.id_ganado AND ug.fecha_salida IS NULL
            LEFT JOIN potrero p ON p.id_potrero = ug.id_potrero
            LEFT JOIN terreno t ON t.id_terreno = p.id_terreno
            LEFT JOIN finca f ON f.id_finca = t.id_finca
            WHERE 1=1";

        $params = [];

        // Buscar por arete o nombre
        if (!empty($filtros['buscar'])) {
            $sql .= " AND (g.codigo_arete LIKE ? OR g.nombre LIKE ?)";
            $params[] = "%" . $filtros['buscar'] . "%";
            $params[] = "%" . $filtros['buscar'] . "%";
        }

        // Filtrar por finca
        if (!empty($filtros['finca'])) {
            $sql .= " AND f.id_finca = ?";
            $params[] = $filtros['finca'];
        }

        // Filtrar por ganado
        if (!empty($filtros['ganado'])) {
            $sql .= " AND g.id_ganado = ?";
            $params[] = $filtros['ganado'];
        }

        $sql .= " ORDER BY vg.fecha_aplicacion DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

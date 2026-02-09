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




    public function crear($data)
    {
        $sql = "INSERT INTO potrero
        (id_terreno, nombre, area, capacidad_animales, estado)
        VALUES (:id_terreno, :nombre, :area, :capacidad, 'disponible')";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':id_terreno' => $data['id_terreno'],
            ':nombre'     => $data['nombre'],
            ':area'       => $data['area'],
            ':capacidad'  => $data['capacidad_animales']
        ]);
    }



    public function actualizar($id, $data)
    {
        $sql = "UPDATE potrero SET
        id_terreno = :id_terreno,
        nombre = :nombre,
        area = :area,
        capacidad_animales = :capacidad,
        estado = :estado
    WHERE id_potrero = :id";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':id_terreno' => $data['id_terreno'],
            ':nombre'     => $data['nombre'],
            ':area'       => $data['area'],
            ':capacidad'  => $data['capacidad_animales'],
            ':estado'     => $data['estado'],
            ':id'         => $id
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

    public function listarTerrenos()
    {
        $sql = "SELECT id_terreno, nombre FROM terreno ORDER BY nombre";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

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
    ///////

    public function cambiarEstado($id_potrero, $estado)
    {
        $sql = "UPDATE potrero
                SET estado = :estado
                WHERE id_potrero = :id";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':estado' => $estado,
            ':id' => $id_potrero
        ]);
    }

    public function enviarADescanso($id_potrero)
    {
        $sql = "UPDATE potrero
                SET estado = 'descanso',
                    fecha_ultimo_uso = CURDATE()
                WHERE id_potrero = :id";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id' => $id_potrero]);
    }

    public function getPotrerosDisponibles()
    {
        return $this->pdo->query("
        SELECT * FROM potrero
        WHERE estado IN ('disponible','en uso')
    ")->fetchAll();
    }

    public function calcularDiasDescanso($id_potrero)
    {
        $sql = "UPDATE potrero
            SET dias_descanso = DATEDIFF(CURDATE(), fecha_ultimo_uso)
            WHERE id_potrero = ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id_potrero]);
    }

    public function obtenerPotreroActivo($id_ganado)
    {
        $sql = "SELECT id_potrero
            FROM ubicacion_ganado
            WHERE id_ganado = ?
            AND fecha_salida IS NULL
            LIMIT 1";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id_ganado]);

        return $stmt->fetchColumn(); // devuelve id_potrero o false
    }

    public function actualizarDiasDescansoPotrero()
    {
        $sql = "UPDATE potrero
            SET dias_descanso = DATEDIFF(CURDATE(), fecha_ultimo_uso)
            WHERE estado = 'descanso'";

        $this->pdo->exec($sql);
    }

    public function obtenerPotrerosConAnimales($id_terreno)
    {
        $sql = "
        SELECT 
            p.id_potrero,
            p.nombre,
            p.estado,
            p.capacidad_animales,
            p.x,
            p.y,
            p.width,
            p.height,
            COUNT(ug.id_ganado) AS animales_actuales
        FROM potrero p
        LEFT JOIN ubicacion_ganado ug 
            ON ug.id_potrero = p.id_potrero
            AND ug.fecha_salida IS NULL
        WHERE p.id_terreno = ?
        GROUP BY p.id_potrero
    ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id_terreno]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

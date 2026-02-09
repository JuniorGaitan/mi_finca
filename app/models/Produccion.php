<?php
class Produccion
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function listar($id_finca)
    {
        $sql = "SELECT p.*, g.codigo_arete, g.nombre
                FROM produccion p
                INNER JOIN ganado g ON p.id_ganado = g.id_ganado
                WHERE p.id_finca = ?
                ORDER BY p.fecha DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id_finca]);
        return $stmt->fetchAll();
    }



    public function crear($data)
    {
        $sql = "INSERT INTO produccion 
            (id_ganado, tipo, cantidad, fecha)
            VALUES (?, ?, ?, ?)";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $data['id_ganado'],
            $data['tipo'],
            $data['cantidad'],
            $data['fecha']
        ]);
    }


    public function obtener($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM produccion WHERE id_produccion=?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function actualizar($data)
    {
        $sql = "UPDATE produccion SET
                id_ganado=?, tipo=?, cantidad=?, fecha=?
                WHERE id_produccion=?";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $data['id_ganado'],
            $data['tipo'],
            $data['cantidad'],
            $data['fecha'],
            $data['id_produccion']
        ]);
    }

    public function eliminar($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM produccion WHERE id_produccion=?");
        return $stmt->execute([$id]);
    }



    public function listarPorFinca($id_finca)
    {
        $sql = "SELECT p.id_produccion,
                   p.tipo,
                   p.cantidad,
                   p.fecha,
                   g.codigo_arete,
                   g.nombre
            FROM produccion p
            INNER JOIN ganado g ON p.id_ganado = g.id_ganado
            INNER JOIN ubicacion_ganado ug ON g.id_ganado = ug.id_ganado
            INNER JOIN potrero po ON ug.id_potrero = po.id_potrero
            INNER JOIN terreno t ON po.id_terreno = t.id_terreno
            WHERE t.id_finca = ?
              AND ug.fecha_salida IS NULL
            ORDER BY p.fecha DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id_finca]);
        return $stmt->fetchAll();
    }
}

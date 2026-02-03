<?php
class Usuario {
    private $db;

    public function __construct($pdo) {
        $this->db = $pdo;
    }

    // Buscar usuario por nombre de usuario y que esté activo
    public function buscarPorNombre($username) {
        $sql = "SELECT u.*, r.nombre AS rol 
                FROM usuarios u 
                JOIN roles r ON u.id_rol = r.id_rol 
                WHERE u.usuario = ? AND u.estado = 'activo' 
                LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Podrías agregar aquí métodos para registrar usuarios, cambiar claves, etc.
    public function obtenerUsuarioActivo($usuario)
    {
        $sql = "SELECT u.id_usuario, u.nombre, u.password, r.nombre AS rol
                FROM usuarios u
                JOIN roles r ON u.id_rol = r.id_rol
                WHERE u.usuario = ? AND u.estado = 'activo'
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$usuario]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
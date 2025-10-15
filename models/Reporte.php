<?php
class Reporte {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $sql = "SELECT r.*, u.nombre as usuario_nombre 
                FROM reportes r 
                LEFT JOIN usuarios u ON r.usuario_id = u.id 
                ORDER BY r.fecha_generacion DESC";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $sql = "SELECT r.*, u.nombre as usuario_nombre 
                FROM reportes r 
                LEFT JOIN usuarios u ON r.usuario_id = u.id 
                WHERE r.id = ?";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function guardar($nombre, $tipo, $ruta, $usuario_id, $parametros) {
        $sql = "INSERT INTO reportes 
                (nombre_reporte, tipo_reporte, ruta_archivo, usuario_id, parametros) 
                VALUES (?, ?, ?, ?, ?)";
        
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$nombre, $tipo, $ruta, $usuario_id, $parametros]);
    }
}
?>
<?php
class Prestamo {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Obtener todos los préstamos con nombres de usuario y producto
    public function getAll() {
        $sql = "SELECT p.id, u.nombre AS usuario_nombre, pr.nombre AS producto_nombre, 
                       p.fecha_prestamo, p.fecha_devolucion, p.estado
                FROM prestamos p
                JOIN usuarios u ON p.usuario_id = u.id
                JOIN productos pr ON p.producto_id = pr.id
                ORDER BY p.fecha_prestamo DESC";
        return $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    // Crear préstamo (solo 1 unidad)
    public function create($usuario_id, $producto_id) {
        // Verificar stock
        $stock = $this->conn->query("SELECT stock FROM productos WHERE id = $producto_id")->fetchColumn();
        if ($stock < 1) return false;

        // Insertar préstamo con fecha y hora actual
        $stmt = $this->conn->prepare(
            "INSERT INTO prestamos (usuario_id, producto_id, fecha_prestamo, estado) 
             VALUES (?, ?, NOW(), 'prestado')"
        );
        $res = $stmt->execute([$usuario_id, $producto_id]);

        if ($res) {
            // Descontar stock
            $this->conn->exec("UPDATE productos SET stock = stock - 1 WHERE id = $producto_id");

            // 🔹 Retornar el ID del préstamo insertado
            return $this->conn->lastInsertId();
        }

        return false;
    }

    // Devolver préstamo
    public function devolver($id) {
        $prestamo = $this->conn->query("SELECT producto_id FROM prestamos WHERE id = $id")->fetch(PDO::FETCH_ASSOC);
        if (!$prestamo) return false;

        // Actualizar fecha de devolución y estado
        $stmt = $this->conn->prepare(
            "UPDATE prestamos SET fecha_devolucion = NOW(), estado = 'devuelto' WHERE id = ?"
        );
        $res = $stmt->execute([$id]);

        if ($res) {
            // Incrementar stock
            $this->conn->exec("UPDATE productos SET stock = stock + 1 WHERE id = {$prestamo['producto_id']}");
        }

        return $res;
    }
}
?>

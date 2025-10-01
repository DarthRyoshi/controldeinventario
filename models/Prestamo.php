<?php
class Prestamo {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $sql = "SELECT p.id, u.nombre AS usuario_nombre, p.fecha_prestamo, p.estado,
                       dp.id AS detalle_id, pr.nombre AS producto_nombre, pr.serial,
                       dp.cantidad_prestada, dp.cantidad_devuelta, dp.fecha_devolucion
                FROM prestamos p
                JOIN usuarios u ON u.id = p.usuario_id
                LEFT JOIN detalle_prestamos dp ON dp.prestamo_id = p.id
                LEFT JOIN productos pr ON pr.id = dp.producto_id
                ORDER BY p.fecha_prestamo DESC";

        $rows = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);

        $prestamos = [];
        foreach ($rows as $row) {
            $id = $row['id'];
            if (!isset($prestamos[$id])) {
                $prestamos[$id] = [
                    'id' => $id,
                    'usuario_nombre' => $row['usuario_nombre'],
                    'fecha_prestamo' => $row['fecha_prestamo'],
                    'estado' => $row['estado'],
                    'detalle' => []
                ];
            }
            if (!empty($row['detalle_id'])) {
                $prestamos[$id]['detalle'][] = [
                    'detalle_id' => $row['detalle_id'],
                    'producto_nombre' => $row['producto_nombre'],
                    'serial' => $row['serial'],
                    'cantidad_prestada' => $row['cantidad_prestada'],
                    'cantidad_devuelta' => $row['cantidad_devuelta'],
                    'fecha_devolucion' => $row['fecha_devolucion']
                ];
            }
        }

        return array_values($prestamos);
    }

    public function create($usuario_id, $productos) {
        $stmt = $this->conn->prepare("INSERT INTO prestamos (usuario_id, fecha_prestamo, estado) VALUES (?, NOW(), 'vigente')");
        $stmt->execute([$usuario_id]);
        $prestamo_id = $this->conn->lastInsertId();

        foreach ($productos as $p) {
            $producto_id = $p['id'];
            $cantidad = $p['cantidad'];

            $stock = $this->conn->query("SELECT stock FROM productos WHERE id = $producto_id")->fetchColumn();
            if ($stock < $cantidad) continue;

            $stmt_detalle = $this->conn->prepare(
                "INSERT INTO detalle_prestamos (prestamo_id, producto_id, cantidad_prestada, cantidad_devuelta) VALUES (?, ?, ?, 0)"
            );
            $stmt_detalle->execute([$prestamo_id, $producto_id, $cantidad]);

            $this->conn->exec("UPDATE productos SET stock = stock - $cantidad WHERE id = $producto_id");
        }

        return $prestamo_id;
    }

    public function devolver($prestamo_id, $productos_devueltos) {
        foreach ($productos_devueltos as $detalle_id => $cantidad) {
            if ($cantidad <= 0) continue;

            $stmt = $this->conn->prepare(
                "UPDATE detalle_prestamos SET cantidad_devuelta = cantidad_devuelta + ? WHERE id = ?"
            );
            $stmt->execute([$cantidad, $detalle_id]);

            $producto_id = $this->conn->query("SELECT producto_id FROM detalle_prestamos WHERE id = $detalle_id")->fetchColumn();
            $this->conn->exec("UPDATE productos SET stock = stock + $cantidad WHERE id = $producto_id");

            $check = $this->conn->query("SELECT cantidad_prestada, cantidad_devuelta FROM detalle_prestamos WHERE id = $detalle_id")->fetch(PDO::FETCH_ASSOC);
            if ($check['cantidad_devuelta'] >= $check['cantidad_prestada']) {
                $this->conn->exec("UPDATE detalle_prestamos SET fecha_devolucion = NOW() WHERE id = $detalle_id");
            }
        }

        $pendientes = $this->conn->query("SELECT COUNT(*) FROM detalle_prestamos WHERE prestamo_id = $prestamo_id AND cantidad_devuelta < cantidad_prestada")->fetchColumn();
        if ($pendientes == 0) {
            $this->conn->exec("UPDATE prestamos SET estado = 'completo' WHERE id = $prestamo_id");
        }

        return true;
    }
}
?>

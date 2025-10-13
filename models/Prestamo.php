<?php
class Prestamo {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll($filters = []) {
        $fecha_inicio = $filters['fecha_inicio'] ?? '';
        $fecha_fin    = $filters['fecha_fin'] ?? '';

        $sql = "SELECT 
                    p.id, 
                    u.nombre AS usuario_nombre, 
                    p.fecha_prestamo, 
                    p.estado,
                    dp.id AS detalle_id, 
                    pr.nombre AS producto_nombre, 
                    pr.serial,
                    COALESCE(dp.cantidad_prestada, 1) AS cantidad_prestada,
                    COALESCE(dp.cantidad_devuelta, 0) AS cantidad_devuelta,
                    dp.fecha_devolucion
                FROM prestamos p
                JOIN usuarios u ON u.id = p.usuario_id
                LEFT JOIN detalle_prestamos dp ON dp.prestamo_id = p.id
                LEFT JOIN productos pr ON pr.id = dp.producto_id
                WHERE 1=1";

        $params = [];

        if (!empty($fecha_inicio)) {
            $sql .= " AND p.fecha_prestamo >= :fecha_inicio";
            $params['fecha_inicio'] = $fecha_inicio . " 00:00:00";
        }
        if (!empty($fecha_fin)) {
            $sql .= " AND p.fecha_prestamo <= :fecha_fin";
            $params['fecha_fin'] = $fecha_fin . " 23:59:59";
        }

        $sql .= " ORDER BY p.fecha_prestamo DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

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

    public function getProductosDisponiblesOrganizados() {
        // Primero obtener todos los productos disponibles
        $sql = "SELECT * FROM productos 
                WHERE stock > 0 AND estado = 'activo'
                ORDER BY nombre, categoria, serial";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $organizados = [];
        
        foreach ($productos as $producto) {
            $nombre = trim($producto['nombre']);
            $categoria = trim($producto['categoria']) ?: 'Sin Categoría';
            
            // Inicializar categoría si no existe
            if (!isset($organizados[$categoria])) {
                $organizados[$categoria] = [];
            }
            
            // Inicializar producto si no existe
            if (!isset($organizados[$categoria][$nombre])) {
                $organizados[$categoria][$nombre] = [
                    'total_stock' => 0,
                    'variantes' => []
                ];
            }
            
            // Sumar stock y agregar variante
            $organizados[$categoria][$nombre]['total_stock'] += (int)$producto['stock'];
            $organizados[$categoria][$nombre]['variantes'][] = [
                'id' => $producto['id'],
                'serial' => $producto['serial'],
                'stock' => $producto['stock']
            ];
        }
        
        return $organizados;
    }

    public function create($usuario_id, $productos) {
        try {
            $this->conn->beginTransaction();

            $stmt = $this->conn->prepare(
                "INSERT INTO prestamos (usuario_id, fecha_prestamo, estado) VALUES (?, NOW(), 'vigente')"
            );
            $stmt->execute([$usuario_id]);
            $prestamo_id = $this->conn->lastInsertId();

            foreach ($productos as $p) {
                $producto_id = $p['id'];
                
                // Verificar stock con bloqueo
                $stockStmt = $this->conn->prepare("SELECT stock FROM productos WHERE id = ? FOR UPDATE");
                $stockStmt->execute([$producto_id]);
                $stock = $stockStmt->fetchColumn();
                
                if ($stock < 1) continue;

                // Insertar detalle
                $stmt_detalle = $this->conn->prepare(
                    "INSERT INTO detalle_prestamos (prestamo_id, producto_id, cantidad_prestada, cantidad_devuelta) VALUES (?, ?, 1, 0)"
                );
                $stmt_detalle->execute([$prestamo_id, $producto_id]);
                
                // Actualizar stock
                $updateStmt = $this->conn->prepare("UPDATE productos SET stock = stock - 1 WHERE id = ?");
                $updateStmt->execute([$producto_id]);
            }

            $this->conn->commit();
            return $prestamo_id;

        } catch (Exception $e) {
            $this->conn->rollBack();
            error_log("Error al crear préstamo: " . $e->getMessage());
            return false;
        }
    }

    public function devolver($prestamo_id, $productos_devueltos) {
        if (empty($productos_devueltos)) return false;

        try {
            $this->conn->beginTransaction();

            foreach ($productos_devueltos as $detalle_id) {
                $stmt = $this->conn->prepare(
                    "UPDATE detalle_prestamos 
                     SET cantidad_devuelta = cantidad_prestada, fecha_devolucion = NOW()
                     WHERE id = ?"
                );
                $stmt->execute([$detalle_id]);

                $productoStmt = $this->conn->prepare("SELECT producto_id FROM detalle_prestamos WHERE id = ?");
                $productoStmt->execute([$detalle_id]);
                $producto_id = $productoStmt->fetchColumn();
                
                $updateStockStmt = $this->conn->prepare("UPDATE productos SET stock = stock + 1 WHERE id = ?");
                $updateStockStmt->execute([$producto_id]);
            }

            $pendientesStmt = $this->conn->prepare(
                "SELECT COUNT(*) FROM detalle_prestamos WHERE prestamo_id = ? AND cantidad_devuelta < cantidad_prestada"
            );
            $pendientesStmt->execute([$prestamo_id]);
            $pendientes = $pendientesStmt->fetchColumn();
            
            if ($pendientes == 0) {
                $updatePrestamoStmt = $this->conn->prepare("UPDATE prestamos SET estado = 'completo' WHERE id = ?");
                $updatePrestamoStmt->execute([$prestamo_id]);
            }

            $this->conn->commit();
            return true;

        } catch (Exception $e) {
            $this->conn->rollBack();
            error_log("Error al devolver préstamo: " . $e->getMessage());
            return false;
        }
    }
}
?>
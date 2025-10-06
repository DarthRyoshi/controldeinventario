<?php
class Bitacora {
    private $conn; // PDO

    public function __construct($conn) {
        $this->conn = $conn;
    }

    /**
     * Registrar un evento en la bitácora
     * Solo para acciones de usuario
     * @param string $accion
     * @param string|null $descripcion
     * @param int|null $usuario_id
     * @param int|null $producto_id
     * @param int|null $prestamo_id
     */
    public function registrar($accion, $descripcion = null, $usuario_id = null, $producto_id = null, $prestamo_id = null) {
        $sql = "INSERT INTO bitacora (accion, descripcion, usuario_id, producto_id, prestamo_id, fecha) 
                VALUES (:accion, :descripcion, :usuario_id, :producto_id, :prestamo_id, NOW())";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':accion'      => $accion,
            ':descripcion' => $descripcion,
            ':usuario_id'  => $usuario_id,
            ':producto_id' => $producto_id,
            ':prestamo_id' => $prestamo_id
        ]);
    }

    /**
     * Obtener todos los registros de bitácora con filtros por fecha
     * @param array $filters
     * @return array
     */
    public function getAll($filters = []) {
        $sql = "SELECT 
                    b.id,
                    b.fecha,
                    b.accion,
                    b.descripcion,
                    CONCAT(u.nombre, ' (', u.rut, ')') AS usuario,
                    p.serial AS producto_serial,
                    b.prestamo_id
                FROM bitacora b
                LEFT JOIN usuarios u ON b.usuario_id = u.id
                LEFT JOIN productos p ON b.producto_id = p.id
                WHERE 1=1";

        $params = [];

        if (!empty($filters['fecha_inicio'])) {
            $sql .= " AND b.fecha >= :fecha_inicio";
            // ---- NUEVO: incluir todo el día desde las 00:00:00 ----
            $params[':fecha_inicio'] = $filters['fecha_inicio'] . " 00:00:00";
        }

        if (!empty($filters['fecha_fin'])) {
            $sql .= " AND b.fecha <= :fecha_fin";
            // ---- NUEVO: incluir todo el día hasta las 23:59:59 ----
            $params[':fecha_fin'] = $filters['fecha_fin'] . " 23:59:59";
        }

        $sql .= " ORDER BY b.fecha DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>

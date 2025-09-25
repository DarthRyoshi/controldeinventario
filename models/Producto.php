<?php
class Producto {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $sql = "SELECT * FROM productos";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $sql = "SELECT * FROM productos WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($nombre, $categoria, $stock, $imagen, $descripcion, $estado, $serial) {
        $sql = "INSERT INTO productos (nombre, categoria, stock, imagen, descripcion, estado, serial, fecha_creacion)
                VALUES (:nombre, :categoria, :stock, :imagen, :descripcion, :estado, :serial, NOW())";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':nombre' => $nombre,
            ':categoria' => $categoria,
            ':stock' => $stock,
            ':imagen' => $imagen,
            ':descripcion' => $descripcion,
            ':estado' => $estado,
            ':serial' => $serial
        ]);
    }

    public function update($id, $nombre, $categoria, $stock, $imagen, $descripcion, $estado, $serial) {
        if ($imagen) {
            $sql = "UPDATE productos SET nombre=:nombre, categoria=:categoria, stock=:stock, imagen=:imagen, descripcion=:descripcion, estado=:estado, serial=:serial WHERE id=:id";
        } else {
            $sql = "UPDATE productos SET nombre=:nombre, categoria=:categoria, stock=:stock, descripcion=:descripcion, estado=:estado, serial=:serial WHERE id=:id";
        }
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':nombre' => $nombre,
            ':categoria' => $categoria,
            ':stock' => $stock,
            ':imagen' => $imagen,
            ':descripcion' => $descripcion,
            ':estado' => $estado,
            ':serial' => $serial,
            ':id' => $id
        ]);
    }

    public function delete($id) {
        $sql = "DELETE FROM productos WHERE id=:id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    public function serialExists($serial, $excludeId = null) {
        $sql = "SELECT COUNT(*) FROM productos WHERE serial = :serial";
        if ($excludeId) $sql .= " AND id != :id";
        $stmt = $this->conn->prepare($sql);
        $params = [':serial' => $serial];
        if ($excludeId) $params[':id'] = $excludeId;
        $stmt->execute($params);
        return $stmt->fetchColumn() > 0;
    }
}
?>

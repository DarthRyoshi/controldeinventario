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
        $serial = trim($serial);
        if ($serial === '' || preg_match('/\s/', $serial)) {
            throw new Exception("El serial no puede estar vacío ni contener espacios.");
        }

        $stmtCheck = $this->conn->prepare("SELECT COUNT(*) FROM productos WHERE serial = ?");
        $stmtCheck->execute([$serial]);
        if ($stmtCheck->fetchColumn() > 0) {
            throw new Exception("El serial ya existe.");
        }

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

    public function update($id, $nombre, $categoria, $stock, $imagen, $descripcion, $estado) {
        if ($imagen) {
            $sql = "UPDATE productos SET nombre=:nombre, categoria=:categoria, stock=:stock, imagen=:imagen, descripcion=:descripcion, estado=:estado WHERE id=:id";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                ':nombre' => $nombre,
                ':categoria' => $categoria,
                ':stock' => $stock,
                ':imagen' => $imagen,
                ':descripcion' => $descripcion,
                ':estado' => $estado,
                ':id' => $id
            ]);
        } else {
            $sql = "UPDATE productos SET nombre=:nombre, categoria=:categoria, stock=:stock, descripcion=:descripcion, estado=:estado WHERE id=:id";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                ':nombre' => $nombre,
                ':categoria' => $categoria,
                ':stock' => $stock,
                ':descripcion' => $descripcion,
                ':estado' => $estado,
                ':id' => $id
            ]);
        }
    }

    public function delete($id) {
        $sql = "DELETE FROM productos WHERE id=:id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}
?>

<?php
class Producto {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // 🔹 Obtener todos los productos
    public function getAll() {
        $sql = "SELECT * FROM productos";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 🔹 Obtener producto por ID
    public function getById($id) {
        $sql = "SELECT * FROM productos WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // 🔹 Crear producto
    public function create($nombre, $categoria, $stock, $imagen, $descripcion, $estado) {
        $sql = "INSERT INTO productos (nombre, categoria, stock, imagen, descripcion, estado, fecha_creacion)
                VALUES (:nombre, :categoria, :stock, :imagen, :descripcion, :estado, NOW())";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':nombre' => $nombre,
            ':categoria' => $categoria,
            ':stock' => $stock,
            ':imagen' => $imagen,
            ':descripcion' => $descripcion,
            ':estado' => $estado
        ]);
    }

    // 🔹 Actualizar producto
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

    // 🔹 Eliminar producto
    public function delete($id) {
        $sql = "DELETE FROM productos WHERE id=:id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}
?>

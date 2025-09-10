<?php
class Usuario {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function login($email, $contrasena) {
        $sql = "SELECT * FROM usuarios WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$usuario) return false;

        if (password_verify($contrasena, $usuario['contrasena'])) return $usuario;

        if ($usuario['contrasena'] === $contrasena) {
            $nuevoHash = password_hash($contrasena, PASSWORD_DEFAULT);
            $sqlUpdate = "UPDATE usuarios SET contrasena = :contrasena WHERE id = :id";
            $stmtUpdate = $this->conn->prepare($sqlUpdate);
            $stmtUpdate->execute([
                ':contrasena' => $nuevoHash,
                ':id' => $usuario['id']
            ]);
            return $usuario;
        }

        return false;
    }

    public function getAll() {
        $sql = "SELECT * FROM usuarios";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $sql = "SELECT * FROM usuarios WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function existsRut($rut, $excludeId = null) {
        $sql = "SELECT COUNT(*) FROM usuarios WHERE rut = :rut";
        if ($excludeId) {
            $sql .= " AND id != :id";
        }
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':rut', $rut);
        if ($excludeId) {
            $stmt->bindParam(':id', $excludeId);
        }
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    public function create($nombre, $email, $contrasena, $rol, $rut) {
        if ($this->existsRut($rut)) {
            return false; // RUT ya existe
        }

        $hash = password_hash($contrasena, PASSWORD_DEFAULT);
        $sql = "INSERT INTO usuarios (nombre, email, contrasena, rol, rut) 
                VALUES (:nombre, :email, :contrasena, :rol, :rut)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':nombre' => $nombre,
            ':email' => $email,
            ':contrasena' => $hash,
            ':rol' => $rol,
            ':rut' => $rut
        ]);
    }

    public function update($id, $nombre, $email, $contrasena, $rol, $rut) {
        if ($this->existsRut($rut, $id)) {
            return false; // RUT ya existe
        }

        if (!empty($contrasena)) {
            $hash = password_hash($contrasena, PASSWORD_DEFAULT);
            $sql = "UPDATE usuarios 
                    SET nombre=:nombre, email=:email, contrasena=:contrasena, rol=:rol, rut=:rut 
                    WHERE id=:id";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                ':nombre' => $nombre,
                ':email' => $email,
                ':contrasena' => $hash,
                ':rol' => $rol,
                ':rut' => $rut,
                ':id' => $id
            ]);
        } else {
            $sql = "UPDATE usuarios 
                    SET nombre=:nombre, email=:email, rol=:rol, rut=:rut 
                    WHERE id=:id";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                ':nombre' => $nombre,
                ':email' => $email,
                ':rol' => $rol,
                ':rut' => $rut,
                ':id' => $id
            ]);
        }
    }

    public function delete($id) {
        $sql = "DELETE FROM usuarios WHERE id=:id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}
?>

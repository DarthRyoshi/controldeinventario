<?php
require_once __DIR__ . '/../models/Prestamo.php';
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../models/Producto.php';
require_once __DIR__ . '/../config.php';

class PrestamoController {
    public static function handle($action) {
        global $conn;
        $prestamoModel = new Prestamo($conn);

        if (!isset($_SESSION['user'])) {
            header("Location: index.php?action=login");
            exit;
        }

        switch ($action) {
            case 'prestamos':
                $prestamos = $prestamoModel->getAll();
                include __DIR__ . '/../views/prestamos/listar.php';
                break;

            case 'crearPrestamo':
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $usuario_id  = $_POST['usuario_id'];   // a quién se le presta
                    $producto_id = $_POST['producto_id'];

                    // Crear el préstamo
                    $prestamo_id = $prestamoModel->create($usuario_id, $producto_id);

                    if ($prestamo_id) {
                        // Guardamos en bitácora el evento de creación
                        $stmt = $conn->prepare(
                            "INSERT INTO bitacora (prestamo_id, accion, fecha) 
                             VALUES (?, 'PRÉSTAMO CREADO', NOW())"
                        );
                        $stmt->execute([$prestamo_id]);
                    }

                    header("Location: index.php?action=prestamos");
                    exit;
                } else {
                    $usuarioModel = new Usuario($conn);
                    $productoModel = new Producto($conn);

                    $usuarios  = $usuarioModel->getAll();
                    $productos = $productoModel->getAll();

                    include __DIR__ . '/../views/prestamos/crear.php';
                }
                break;

            case 'devolverPrestamo':
                $id = $_GET['id'] ?? null;

                if ($id) {
                    if ($prestamoModel->devolver($id)) {
                        // Guardamos en bitácora el evento de devolución
                        $stmt = $conn->prepare(
                            "INSERT INTO bitacora (prestamo_id, accion, fecha) 
                             VALUES (?, 'DEVUELTO', NOW())"
                        );
                        $stmt->execute([$id]);
                    }
                }

                header("Location: index.php?action=prestamos");
                exit;
                break;

            default:
                echo "Acción no válida";
        }
    }
}
?>

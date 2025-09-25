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
                    $usuario_id  = $_POST['usuario_id'];
                    $productos = [];

                    if (!empty($_POST['productos'])) {
                        foreach ($_POST['productos'] as $p) {
                            if (isset($p['id'], $p['cantidad']) && $p['cantidad'] > 0) {
                                $productos[] = ['id' => $p['id'], 'cantidad' => (int)$p['cantidad']];
                            }
                        }
                    }

                    $prestamo_id = $prestamoModel->create($usuario_id, $productos);

                    if ($prestamo_id) {
                        $stmt = $conn->prepare(
                            "INSERT INTO bitacora (prestamo_id, accion, fecha) VALUES (?, 'PRÉSTAMO CREADO', NOW())"
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
                $prestamo_id = $_GET['id'] ?? null;

                if ($_SERVER['REQUEST_METHOD'] === 'POST' && $prestamo_id) {
                    $prestamoModel->devolver($prestamo_id, $_POST['devolver'] ?? []);

                    $stmt = $conn->prepare(
                        "INSERT INTO bitacora (prestamo_id, accion, fecha) VALUES (?, 'DEVUELTO PARCIAL', NOW())"
                    );
                    $stmt->execute([$prestamo_id]);

                    header("Location: index.php?action=prestamos");
                    exit;
                } else {
                    $sql = "SELECT dp.id, pr.nombre, dp.cantidad_prestada, dp.cantidad_devuelta
                            FROM detalle_prestamos dp
                            JOIN productos pr ON pr.id = dp.producto_id
                            WHERE dp.prestamo_id = $prestamo_id AND dp.cantidad_devuelta < dp.cantidad_prestada";
                    $productos = $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);

                    include __DIR__ . '/../views/prestamos/devolver.php';
                }
                break;

            default:
                echo "Acción no válida";
        }
    }
}
?>

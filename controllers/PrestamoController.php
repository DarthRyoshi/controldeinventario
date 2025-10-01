<?php
require_once __DIR__ . '/../models/Prestamo.php';
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../models/Producto.php';
require_once __DIR__ . '/../models/Bitacora.php';
require_once __DIR__ . '/../config.php';

class PrestamoController {
    public static function handle($action) {
        global $conn;
        $prestamoModel = new Prestamo($conn);
        $usuarioModel  = new Usuario($conn);
        $productoModel = new Producto($conn);
        $bitacora      = new Bitacora($conn);

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
                    $productos   = [];

                    foreach ($_POST['productos'] ?? [] as $p) {
                        if (isset($p['id'], $p['cantidad']) && $p['cantidad'] > 0) {
                            $productos[] = ['id' => $p['id'], 'cantidad' => (int)$p['cantidad']];
                        }
                    }

                    $prestamo_id = $prestamoModel->create($usuario_id, $productos);

                    if ($prestamo_id) {
                        // Crear mensaje descriptivo para bitácora
                        $detalle_texto = [];
                        foreach ($productos as $p) {
                            $prod = $productoModel->getById($p['id']);
                            if ($prod) $detalle_texto[] = $prod['nombre'] . " (Serial: {$prod['serial']}) x{$p['cantidad']}";
                        }
                        $mensaje = "{$_SESSION['user']['nombre']} le prestó los siguientes insumos a " .
                                    $usuarioModel->getById($usuario_id)['nombre'] . ": " . implode(", ", $detalle_texto);

                        // Registrar en bitácora
                        $bitacora->registrar(
                            "CREAR PRÉSTAMO",
                            $mensaje,
                            $_SESSION['user']['id'],
                            null,
                            $prestamo_id
                        );
                    }

                    header("Location: index.php?action=prestamos");
                    exit;
                }

                $usuarios  = $usuarioModel->getAll();
                $productos = $productoModel->getAll();
                include __DIR__ . '/../views/prestamos/crear.php';
                break;

            case 'devolverPrestamo':
                $prestamo_id = $_GET['id'] ?? null;
                if (!$prestamo_id) {
                    header("Location: index.php?action=prestamos");
                    exit;
                }

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $prestamoModel->devolver($prestamo_id, $_POST['devolver'] ?? []);

                    // Registrar devolución parcial o completa en bitácora
                    $mensaje = "El usuario {$_SESSION['user']['nombre']} registró devolución en el préstamo ID $prestamo_id";
                    $bitacora->registrar("DEVOLUCIÓN PRÉSTAMO", $mensaje, $_SESSION['user']['id'], null, $prestamo_id);

                    header("Location: index.php?action=prestamos");
                    exit;
                }

                $sql = "SELECT dp.id, pr.nombre, pr.serial, dp.cantidad_prestada, dp.cantidad_devuelta
                        FROM detalle_prestamos dp
                        JOIN productos pr ON pr.id = dp.producto_id
                        WHERE dp.prestamo_id = $prestamo_id AND dp.cantidad_devuelta < dp.cantidad_prestada";
                $productos = $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);

                include __DIR__ . '/../views/prestamos/devolver.php';
                break;

            default:
                echo "Acción no válida";
        }
    }
}
?>

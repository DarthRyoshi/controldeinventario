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
                    $usuario_id = $_POST['usuario_id'];
                    $productos  = [];

                    // Solo se agregan productos marcados (checklist)
                    foreach ($_POST['productos'] ?? [] as $pid => $p) {
                        if (!empty($p['id'])) {
                            $productos[] = ['id' => (int)$p['id']];
                        }
                    }

                    $prestamo_id = $prestamoModel->create($usuario_id, $productos);

                    if ($prestamo_id) {
                        $detalle_texto = [];
                        foreach ($productos as $p) {
                            $prod = $productoModel->getById($p['id']);
                            if ($prod) {
                                $detalle_texto[] = "{$prod['nombre']} (Serial: {$prod['serial']})";
                            }
                        }

                        $mensaje = "{$_SESSION['user']['nombre']} le prestó los siguientes insumos a " .
                                   $usuarioModel->getById($usuario_id)['nombre'] . ": " . implode(", ", $detalle_texto);

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
                    $productos_devueltos = $_POST['devolver'] ?? [];
                    $prestamoModel->devolver($prestamo_id, $productos_devueltos);

                    // Obtener nombre del usuario asociado al préstamo
                    $stmt_usuario = $conn->prepare("SELECT u.nombre FROM prestamos p JOIN usuarios u ON p.usuario_id = u.id WHERE p.id = :prestamo_id");
                    $stmt_usuario->execute(['prestamo_id' => $prestamo_id]);
                    $usuario_nombre = $stmt_usuario->fetchColumn() ?: 'Usuario';

                    // Construir mensaje descriptivo para bitácora
                    $detalle_texto = [];
                    foreach ($productos_devueltos as $detalle_id) {
                        $prod = $conn->query("
                            SELECT pr.nombre, pr.serial 
                            FROM detalle_prestamos dp 
                            JOIN productos pr ON pr.id = dp.producto_id 
                            WHERE dp.id = $detalle_id
                        ")->fetch(PDO::FETCH_ASSOC);

                        if ($prod) {
                            $detalle_texto[] = "{$prod['nombre']} (Serial: {$prod['serial']})";
                        }
                    }

                    $mensaje = "Registro de devolución del préstamo de {$usuario_nombre}: " . implode(", ", $detalle_texto);

                    // Registrar en bitácora
                    $bitacora->registrar("DEVOLUCIÓN PRÉSTAMO", $mensaje, $_SESSION['user']['id'], null, $prestamo_id);

                    header("Location: index.php?action=prestamos");
                    exit;
                }

                $sql = "SELECT 
                            dp.id AS id,
                            dp.producto_id,
                            pr.nombre,
                            pr.serial,
                            COALESCE(dp.cantidad_prestada, 1) AS cantidad_prestada,
                            COALESCE(dp.cantidad_devuelta, 0) AS cantidad_devuelta
                        FROM detalle_prestamos dp
                        JOIN productos pr ON pr.id = dp.producto_id
                        WHERE dp.prestamo_id = :prestamo_id
                        ORDER BY dp.id";
                $stmt = $conn->prepare($sql);
                $stmt->execute(['prestamo_id' => $prestamo_id]);
                $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

                include __DIR__ . '/../views/prestamos/devolver.php';
                break;

            default:
                echo "Acción no válida";
        }
    }
}
?>

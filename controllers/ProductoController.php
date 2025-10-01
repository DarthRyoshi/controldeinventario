<?php
require_once __DIR__ . '/../models/Producto.php';
require_once __DIR__ . '/../models/Bitacora.php';
require_once __DIR__ . '/../config.php';

class ProductoController {
    public static function handle($action) {
        global $conn;
        $productoModel = new Producto($conn);
        $bitacora = new Bitacora($conn);

        if (!isset($_SESSION['user'])) {
            header("Location: index.php?action=login");
            exit;
        }

        switch($action) {
            case 'productos':
                $productos = $productoModel->getAll();
                include __DIR__ . '/../views/productos/listar.php';
                break;

            case 'crearProducto':
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $nombre      = $_POST['nombre'];
                    $categoria   = $_POST['categoria'];
                    $stock       = $_POST['stock'];
                    $descripcion = $_POST['descripcion'];
                    $estado      = $_POST['estado'];
                    $serial      = $_POST['serial'];

                    $imagen = null;
                    if (!empty($_FILES['imagen']['name'])) {
                        $ruta = 'assets/images/productos/';
                        if (!is_dir($ruta)) mkdir($ruta, 0755, true);
                        $imagen = time() . '_' . preg_replace("/[^a-zA-Z0-9\._-]/", "_", basename($_FILES['imagen']['name']));
                        move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta . $imagen);
                    }

                    try {
                        $id_nuevo = $productoModel->create($nombre, $categoria, $stock, $imagen, $descripcion, $estado, $serial);

                        // Registrar en bitácora
                        $bitacora->registrar(
                            "CREAR PRODUCTO",
                            "Se creó el producto $nombre con serial $serial",
                            $_SESSION['user']['id'],
                            $id_nuevo
                        );

                        header("Location: index.php?action=productos");
                        exit;
                    } catch (Exception $e) {
                        $error = $e->getMessage();
                        include __DIR__ . '/../views/productos/crear.php';
                        exit;
                    }
                } else {
                    include __DIR__ . '/../views/productos/crear.php';
                }
                break;

            case 'editarProducto':
                $id = $_GET['id'] ?? null;
                if (!$id) {
                    header("Location: index.php?action=productos");
                    exit;
                }

                $producto = $productoModel->getById($id);
                if (!$producto) {
                    header("Location: index.php?action=productos");
                    exit;
                }

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $nombre      = $_POST['nombre'];
                    $categoria   = $_POST['categoria'];
                    $stock       = $_POST['stock'];
                    $descripcion = $_POST['descripcion'];
                    $estado      = $_POST['estado'];

                    $imagen = null;
                    if (!empty($_FILES['imagen']['name'])) {
                        $ruta = 'assets/images/productos/';
                        if (!is_dir($ruta)) mkdir($ruta, 0755, true);
                        $imagen = time() . '_' . preg_replace("/[^a-zA-Z0-9\._-]/", "_", basename($_FILES['imagen']['name']));
                        move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta . $imagen);
                    }

                    $productoModel->update($id, $nombre, $categoria, $stock, $imagen, $descripcion, $estado);

                    // Registrar en bitácora
                    $bitacora->registrar(
                        "EDITAR PRODUCTO",
                        "Se editó el producto $nombre (ID $id)",
                        $_SESSION['user']['id'],
                        $id
                    );

                    header("Location: index.php?action=productos");
                    exit;
                } else {
                    include __DIR__ . '/../views/productos/editar.php';
                }
                break;

            case 'eliminarProducto':
                $id = $_GET['id'] ?? null;
                if ($id) {
                    $producto = $productoModel->getById($id);
                    $productoModel->delete($id);

                    // Registrar en bitácora
                    $bitacora->registrar(
                        "ELIMINAR PRODUCTO",
                        "Se eliminó el producto {$producto['nombre']} (ID $id)",
                        $_SESSION['user']['id'],
                        $id
                    );
                }
                header("Location: index.php?action=productos");
                exit;

            default:
                echo "Acción no válida";
                break;
        }
    }
}
?>

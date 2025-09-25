<?php
require_once __DIR__ . '/../models/Producto.php';
require_once __DIR__ . '/../config.php';

class ProductoController {
    public static function handle($action) {
        global $conn;
        $productoModel = new Producto($conn);

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
                    $nombre = $_POST['nombre'];
                    $categoria = $_POST['categoria'];
                    $stock = $_POST['stock'];
                    $descripcion = $_POST['descripcion'];
                    $estado = $_POST['estado'];
                    $serial = $_POST['serial'];

                    if ($productoModel->serialExists($serial)) {
                        $error = "El número de serial ya existe.";
                        include __DIR__ . '/../views/productos/crear.php';
                        exit;
                    }

                    $imagen = null;
                    if (!empty($_FILES['imagen']['name'])) {
                        $ruta = 'assets/images/productos/';
                        if (!is_dir($ruta)) mkdir($ruta, 0755, true);
                        $imagen = time() . '_' . preg_replace("/[^a-zA-Z0-9\._-]/", "_", basename($_FILES['imagen']['name']));
                        move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta . $imagen);
                    }

                    $productoModel->create($nombre, $categoria, $stock, $imagen, $descripcion, $estado, $serial);
                    header("Location: index.php?action=productos");
                    exit;
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
                    $nombre = $_POST['nombre'];
                    $categoria = $_POST['categoria'];
                    $stock = $_POST['stock'];
                    $descripcion = $_POST['descripcion'];
                    $estado = $_POST['estado'];
                    $serial = $_POST['serial'];

                    if ($productoModel->serialExists($serial, $id)) {
                        $error = "El número de serial ya existe.";
                        include __DIR__ . '/../views/productos/editar.php';
                        exit;
                    }

                    $imagen = null;
                    if (!empty($_FILES['imagen']['name'])) {
                        $ruta = 'assets/images/productos/';
                        if (!is_dir($ruta)) mkdir($ruta, 0755, true);
                        $imagen = time() . '_' . preg_replace("/[^a-zA-Z0-9\._-]/", "_", basename($_FILES['imagen']['name']));
                        move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta . $imagen);
                    }

                    $productoModel->update($id, $nombre, $categoria, $stock, $imagen, $descripcion, $estado, $serial);
                    header("Location: index.php?action=productos");
                    exit;
                }

                include __DIR__ . '/../views/productos/editar.php';
                break;

            case 'eliminarProducto':
                $id = $_GET['id'] ?? null;
                if ($id) $productoModel->delete($id);
                header("Location: index.php?action=productos");
                exit;

            default:
                header("Location: index.php?action=productos");
                exit;
        }
    }
}
?>

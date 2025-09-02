<?php
session_start();

$action = $_GET['action'] ?? 'login';

require_once __DIR__ . '/controllers/UsuarioController.php';
require_once __DIR__ . '/controllers/ProductoController.php';

$usuarioActions = ['login','dashboard','usuarios','crearUsuario','editarUsuario','eliminarUsuario','logout'];
$productoActions = ['productos','crearProducto','editarProducto','eliminarProducto'];

if (in_array($action, $usuarioActions)) {
    UsuarioController::handle($action);
} elseif (in_array($action, $productoActions)) {
    ProductoController::handle($action);
} else {
    echo "Acción no válida";
}

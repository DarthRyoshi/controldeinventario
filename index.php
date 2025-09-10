<?php
session_start();

$action = $_GET['action'] ?? 'login';

// Incluimos los controllers
require_once __DIR__ . '/controllers/UsuarioController.php';
require_once __DIR__ . '/controllers/ProductoController.php';
require_once __DIR__ . '/controllers/PrestamoController.php';

// Acciones por módulo
$usuarioActions = ['login','dashboard','usuarios','crearUsuario','editarUsuario','eliminarUsuario','logout'];
$productoActions = ['productos','crearProducto','editarProducto','eliminarProducto'];
$prestamoActions = ['prestamos','crearPrestamo','devolverPrestamo']; // Nuevo módulo

// Enrutamiento
if (in_array($action, $usuarioActions)) {
    UsuarioController::handle($action);
} elseif (in_array($action, $productoActions)) {
    ProductoController::handle($action);
} elseif (in_array($action, $prestamoActions)) {
    PrestamoController::handle($action);
} else {
    echo "Acción no válida";
}

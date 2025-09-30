<?php
session_start();

$action = $_GET['action'] ?? 'login';

// Incluimos los controllers
require_once __DIR__ . '/controllers/UsuarioController.php';
require_once __DIR__ . '/controllers/ProductoController.php';
require_once __DIR__ . '/controllers/PrestamoController.php';
require_once __DIR__ . '/controllers/BitacoraController.php'; // Añadido Bitácora

// Incluye tu conexión
require_once __DIR__ . '/config.php'; // define $conn

// Acciones por módulo
$usuarioActions = ['login','dashboard','usuarios','crearUsuario','editarUsuario','eliminarUsuario','logout'];
$productoActions = ['productos','crearProducto','editarProducto','eliminarProducto'];
$prestamoActions = ['prestamos','crearPrestamo','devolverPrestamo']; 
$bitacoraActions = ['listar']; // Acción disponible para Bitácora

// Enrutamiento
if (in_array($action, $usuarioActions)) {
    UsuarioController::handle($action);
} elseif (in_array($action, $productoActions)) {
    ProductoController::handle($action);
} elseif (in_array($action, $prestamoActions)) {
    PrestamoController::handle($action);
} elseif (in_array($action, $bitacoraActions)) { // <-- Bitácora
    $bitacoraController = new BitacoraController($conn);
    $bitacoraController->listar();
} else {
    echo "Acción no válida";
}

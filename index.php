<?php
session_start();

$action = $_GET['action'] ?? 'login';

// Controllers
require_once __DIR__ . '/controllers/UsuarioController.php';
require_once __DIR__ . '/controllers/ProductoController.php';
require_once __DIR__ . '/controllers/PrestamoController.php';
require_once __DIR__ . '/controllers/BitacoraController.php'; 
require_once __DIR__ . '/controllers/ReporteBitacoraController.php'; 

// Conexión DB
require_once __DIR__ . '/config.php'; 

// Acciones por módulo
$usuarioActions  = ['login','dashboard','usuarios','crearUsuario','editarUsuario','eliminarUsuario','logout'];
$productoActions = ['productos','crearProducto','editarProducto','eliminarProducto'];
$prestamoActions = ['prestamos','crearPrestamo','devolverPrestamo']; 
$bitacoraActions = ['listar'];
$reporteActions  = ['informesBitacora','previewReporte','descargarPDF','descargarExcel','listarInformes']; 

// Enrutamiento
if (in_array($action, $usuarioActions)) {
    UsuarioController::handle($action);

} elseif (in_array($action, $productoActions)) {
    ProductoController::handle($action);

} elseif (in_array($action, $prestamoActions)) {
    PrestamoController::handle($action);

} elseif (in_array($action, $bitacoraActions)) { 
    $bitacoraController = new BitacoraController($conn);
    $bitacoraController->listar();

} elseif (in_array($action, $reporteActions)) { 
    ReporteBitacoraController::handle($action);

} else {
    echo "Acción no válida";
}
?>
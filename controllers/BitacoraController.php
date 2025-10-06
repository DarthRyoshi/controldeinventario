<?php
require_once __DIR__ . '/../models/Bitacora.php';

class BitacoraController {
    private $model;

    public function __construct($conn) {
        $this->model = new Bitacora($conn);
    }

    
    public function listar() {
        
        // Obtener filtros de fecha desde la solicitud GET

        $filters = [
            'fecha_inicio' => $_GET['fecha_inicio'] ?? '',
            'fecha_fin'    => $_GET['fecha_fin'] ?? ''
        ];

        $bitacoras = $this->model->getAll($filters);

        // Cargar la vista
        require __DIR__ . '/../views/bitacora/listar.php';
    }

   
    public function registrarAccion($accion, $descripcion, $usuario_id) {
    // Solo acciones de usuario, producto y préstamo null
    $this->model->registrar($accion, $descripcion, $usuario_id, null, null);
    }
}
?>

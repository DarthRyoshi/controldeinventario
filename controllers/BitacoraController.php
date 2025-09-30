<?php
require_once __DIR__ . '/../models/Bitacora.php';

class BitacoraController {
    private $model;

    public function __construct($conn) {
        $this->model = new Bitacora($conn);
    }

    /**
     * Listar registros de la bitácora con filtros por fecha
     */
    public function listar() {
        $filters = [
            'fecha_inicio' => $_GET['fecha_inicio'] ?? '',
            'fecha_fin'    => $_GET['fecha_fin'] ?? ''
        ];

        $bitacoras = $this->model->getAll($filters);

        // Cargar la vista
        require __DIR__ . '/../views/bitacora/listar.php';
    }

    /**
     * Registrar acción de usuario
     */
    public function registrarAccion($accion, $descripcion, $usuario_id) {
        // Solo acciones de usuario, producto y préstamo null
        $this->model->registrar($accion, $descripcion, $usuario_id, null, null);
    }
}
?>

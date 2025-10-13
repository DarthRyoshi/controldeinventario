<?php
require_once __DIR__ . '/../models/Bitacora.php'; 
require_once __DIR__ . '/../vendor/autoload.php'; // Para Dompdf y PhpSpreadsheet

use Dompdf\Dompdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ReporteBitacoraController {
    private $model;

    public function __construct($conn) {
        $this->model = new Bitacora($conn); // Reutiliza tu modelo Bitacora
    }

    /**
     * Muestra la vista del reporte de bitácora.
     * Incluye filtros por fecha y botones para exportar a PDF/Excel.
     */
    public function index() {
        $filters = [
            'fecha_inicio' => $_GET['fecha_inicio'] ?? '',
            'fecha_fin'    => $_GET['fecha_fin'] ?? ''
        ];

        $bitacoras = $this->model->getAll($filters);

        // Carga la vista
        require __DIR__ . '/../views/reportes/bitacora.php';
    }

    /**
     * Genera y descarga el reporte de bitácora en PDF
     */
    public function exportarPDF() {
        $filters = [
            'fecha_inicio' => $_GET['fecha_inicio'] ?? '',
            'fecha_fin'    => $_GET['fecha_fin'] ?? ''
        ];

        $bitacoras = $this->model->getAll($filters);

        $html = '<h2 style="text-align:center;">Reporte de Bitácora</h2>
                <table border="1" cellspacing="0" cellpadding="5" width="100%">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Acción</th>
                        <th>Descripción</th>
                        <th>Usuario</th>
                    </tr>
                </thead>
                <tbody>';

        foreach ($bitacoras as $b) {
            $html .= '<tr>
                        <td>'.htmlspecialchars($b['fecha']).'</td>
                        <td>'.htmlspecialchars($b['accion']).'</td>
                        <td>'.htmlspecialchars($b['descripcion']).'</td>
                        <td>'.htmlspecialchars($b['usuario']).'</td>
                      </tr>';
        }

        $html .= '</tbody></table>';

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream('reporte_bitacora.pdf', ['Attachment' => true]);
    }

    /**
     * Genera y descarga el reporte de bitácora en Excel
     */
    public function exportarExcel() {
        $filters = [
            'fecha_inicio' => $_GET['fecha_inicio'] ?? '',
            'fecha_fin'    => $_GET['fecha_fin'] ?? ''
        ];

        $bitacoras = $this->model->getAll($filters);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Bitácora');

        // Encabezados
        $sheet->setCellValue('A1', 'Fecha');
        $sheet->setCellValue('B1', 'Acción');
        $sheet->setCellValue('C1', 'Descripción');
        $sheet->setCellValue('D1', 'Usuario');

        $fila = 2;
        foreach ($bitacoras as $b) {
            $sheet->setCellValue('A'.$fila, $b['fecha']);
            $sheet->setCellValue('B'.$fila, $b['accion']);
            $sheet->setCellValue('C'.$fila, $b['descripcion']);
            $sheet->setCellValue('D'.$fila, $b['usuario']);
            $fila++;
        }

        // Configuración de headers para descarga
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="reporte_bitacora.xlsx"');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}
?>

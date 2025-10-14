<?php
require_once __DIR__ . '/../models/Bitacora.php'; 
require_once __DIR__ . '/../models/Reporte.php';
require_once __DIR__ . '/../vendor/autoload.php';

use Dompdf\Dompdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class ReporteBitacoraController {
    private $bitacoraModel;
    private $reporteModel;

    public function __construct($conn) {
        $this->bitacoraModel = new Bitacora($conn);
        $this->reporteModel = new Reporte($conn);
    }

    public static function handle($action) {
        global $conn;
        $controller = new self($conn);
        
        switch ($action) {
            case 'informesBitacora':
                $controller->informes();
                break;
            case 'listarInformes':
                $controller->listar();
                break;
            case 'previewReporte':
                $controller->previewReporte();
                break;
            case 'descargarPDF':
                $controller->descargarPDF();
                break;
            case 'descargarExcel':
                $controller->descargarExcel();
                break;
            default:
                echo "Acción no válida";
        }
    }

    private function informes() {
        // Obtener datos para previsualización
        $bitacorasPreview = $this->bitacoraModel->getAll([]);
        $bitacorasPreview = array_slice($bitacorasPreview, 0, 10);
        $totalRegistros = count($this->bitacoraModel->getAll([]));
        
        include __DIR__ . '/../views/reportes/informes.php';
    }

    private function listar() {
        $reportes = $this->reporteModel->getAll();
        include __DIR__ . '/../views/reportes/listar.php';
    }

    private function previewReporte() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Obtener formato seleccionado
            $formato = $_POST['formato'] ?? 'pdf';
            
            // Guardar en sesión para la descarga
            $_SESSION['formato_reporte'] = $formato;
            
            // Generar previsualización según el formato
            if ($formato === 'pdf') {
                $this->generarPreviewPDF();
            } else {
                $this->generarPreviewExcel();
            }
        } else {
            header('Location: index.php?action=informesBitacora');
        }
    }

    private function generarPreviewPDF() {
        $bitacoras = $this->bitacoraModel->getAll([]);

        $html = '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>Vista Previa - Reporte de Bitácora</title>
            <style>
                body { 
                    font-family: "Arial", sans-serif; 
                    margin: 20px;
                    color: #333;
                }
                .header {
                    text-align: center;
                    margin-bottom: 30px;
                    border-bottom: 2px solid #2c3e50;
                    padding-bottom: 20px;
                }
                .title {
                    color: #2c3e50;
                    font-size: 24px;
                    margin-bottom: 10px;
                }
                .subtitle {
                    color: #7f8c8d;
                    font-size: 14px;
                }
                .preview-notice {
                    background: #fff3cd;
                    border: 1px solid #ffeaa7;
                    padding: 10px;
                    border-radius: 5px;
                    margin-bottom: 20px;
                    text-align: center;
                    color: #856404;
                }
                .action-buttons {
                    text-align: center;
                    margin: 20px 0;
                    padding: 15px;
                    background: #f8f9fa;
                    border-radius: 5px;
                }
                .table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-top: 20px;
                }
                .table th {
                    background: #2c3e50;
                    color: white;
                    padding: 12px;
                    text-align: left;
                    border: 1px solid #ddd;
                }
                .table td {
                    padding: 10px;
                    border: 1px solid #ddd;
                }
                .table tr:nth-child(even) {
                    background: #f9f9f9;
                }
            </style>
        </head>
        <body>
            <div class="preview-notice">
                <strong>VISTA PREVIA - </strong> Este es un documento de previsualización. Revise el contenido antes de descargar.
            </div>

            <div class="action-buttons">
                <a href="index.php?action=descargarPDF" class="btn" style="background: #dc3545; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin-right: 10px;">
                    📄 Descargar PDF
                </a>
                <a href="index.php?action=informesBitacora" class="btn" style="background: #6c757d; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">
                    ↩️ Volver a Modificar
                </a>
            </div>

            <div class="header">
                <div class="title">REPORTE DE BITÁCORA DEL SISTEMA</div>
                <div class="subtitle">Generado el: ' . date('d/m/Y H:i:s') . '</div>
                <div class="subtitle">Total de registros: ' . count($bitacoras) . '</div>
            </div>

            <table class="table">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Usuario</th>
                        <th>Acción</th>
                        <th>Descripción</th>
                    </tr>
                </thead>
                <tbody>';

        // Mostrar solo los primeros 20 registros en previsualización
        $bitacorasPreview = array_slice($bitacoras, 0, 20);
        
        foreach ($bitacorasPreview as $b) {
            $html .= '<tr>
                        <td>' . date('d/m/Y H:i', strtotime($b['fecha'])) . '</td>
                        <td>' . htmlspecialchars($b['usuario']) . '</td>
                        <td>' . htmlspecialchars($b['accion']) . '</td>
                        <td>' . htmlspecialchars($b['descripcion']) . '</td>
                      </tr>';
        }

        if (count($bitacoras) > 20) {
            $html .= '<tr>
                        <td colspan="4" style="text-align: center; padding: 15px; background: #f8f9fa; font-style: italic;">
                        ... y ' . (count($bitacoras) - 20) . ' registros más
                        </td>
                      </tr>';
        }

        if (empty($bitacoras)) {
            $html .= '<tr><td colspan="4" style="text-align: center; padding: 20px;">No hay registros en la bitácora</td></tr>';
        }

        $html .= '</tbody></table>
                </body>
                </html>';

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Mostrar en navegador sin descargar
        $dompdf->stream('vista_previa_bitacora.pdf', ['Attachment' => false]);
    }

    private function generarPreviewExcel() {
        $bitacoras = $this->bitacoraModel->getAll([]);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Bitácora');

        // Título
        $sheet->setCellValue('A1', 'VISTA PREVIA - Reporte de Bitácora del Sistema');
        $sheet->mergeCells('A1:D1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');

        // Instrucciones
        $sheet->setCellValue('A2', 'Este es un documento de previsualización. Revise antes de descargar.');
        $sheet->mergeCells('A2:D2');
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A2')->getFont()->setItalic(true);

        // Fecha
        $sheet->setCellValue('A3', 'Generado: ' . date('d/m/Y H:i:s'));
        $sheet->mergeCells('A3:D3');
        $sheet->getStyle('A3')->getAlignment()->setHorizontal('center');

        // Encabezados
        $sheet->setCellValue('A5', 'Fecha');
        $sheet->setCellValue('B5', 'Usuario');
        $sheet->setCellValue('C5', 'Acción');
        $sheet->setCellValue('D5', 'Descripción');

        // Estilo encabezados
        $headerStyle = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '4CAF50']]
        ];
        $sheet->getStyle('A5:D5')->applyFromArray($headerStyle);

        // Datos (solo primeros 20 para preview)
        $bitacorasPreview = array_slice($bitacoras, 0, 20);
        $fila = 6;
        foreach ($bitacorasPreview as $b) {
            $sheet->setCellValue('A'.$fila, date('d/m/Y H:i', strtotime($b['fecha'])));
            $sheet->setCellValue('B'.$fila, $b['usuario']);
            $sheet->setCellValue('C'.$fila, $b['accion']);
            $sheet->setCellValue('D'.$fila, $b['descripcion']);
            $fila++;
        }

        if (count($bitacoras) > 20) {
            $sheet->setCellValue('A'.$fila, '... y ' . (count($bitacoras) - 20) . ' registros más');
            $sheet->mergeCells('A'.$fila.':D'.$fila);
            $sheet->getStyle('A'.$fila)->getAlignment()->setHorizontal('center');
            $sheet->getStyle('A'.$fila)->getFont()->setItalic(true);
            $fila++;
        }

        if (empty($bitacoras)) {
            $sheet->setCellValue('A6', 'No hay registros en la bitácora');
            $sheet->mergeCells('A6:D6');
            $sheet->getStyle('A6')->getAlignment()->setHorizontal('center');
        }

        // Autoajustar columnas
        foreach (range('A', 'D') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Aplicar bordes
        $lastRow = $fila > 6 ? $fila - 1 : 6;
        $sheet->getStyle('A5:D' . $lastRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'DDDDDD']
                ]
            ]
        ]);

        // Guardar temporalmente para preview
        $writer = new Xlsx($spreadsheet);
        $tempFile = tempnam(sys_get_temp_dir(), 'preview_excel_');
        $writer->save($tempFile);

        // Mostrar en navegador
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: inline; filename="vista_previa_bitacora.xlsx"');
        header('Cache-Control: max-age=0');
        readfile($tempFile);
        unlink($tempFile);
        exit;
    }

    private function descargarPDF() {
        $bitacoras = $this->bitacoraModel->getAll([]);

        $html = '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>Reporte de Bitácora</title>
            <style>
                body { 
                    font-family: "Arial", sans-serif; 
                    margin: 20px;
                    color: #333;
                }
                .header {
                    text-align: center;
                    margin-bottom: 30px;
                    border-bottom: 2px solid #2c3e50;
                    padding-bottom: 20px;
                }
                .title {
                    color: #2c3e50;
                    font-size: 24px;
                    margin-bottom: 10px;
                }
                .subtitle {
                    color: #7f8c8d;
                    font-size: 14px;
                }
                .table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-top: 20px;
                }
                .table th {
                    background: #2c3e50;
                    color: white;
                    padding: 12px;
                    text-align: left;
                    border: 1px solid #ddd;
                }
                .table td {
                    padding: 10px;
                    border: 1px solid #ddd;
                }
                .table tr:nth-child(even) {
                    background: #f9f9f9;
                }
            </style>
        </head>
        <body>
            <div class="header">
                <div class="title">REPORTE DE BITÁCORA DEL SISTEMA</div>
                <div class="subtitle">Generado el: ' . date('d/m/Y H:i:s') . '</div>
            </div>

            <table class="table">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Usuario</th>
                        <th>Acción</th>
                        <th>Descripción</th>
                    </tr>
                </thead>
                <tbody>';

        foreach ($bitacoras as $b) {
            $html .= '<tr>
                        <td>' . date('d/m/Y H:i', strtotime($b['fecha'])) . '</td>
                        <td>' . htmlspecialchars($b['usuario']) . '</td>
                        <td>' . htmlspecialchars($b['accion']) . '</td>
                        <td>' . htmlspecialchars($b['descripcion']) . '</td>
                      </tr>';
        }

        if (empty($bitacoras)) {
            $html .= '<tr><td colspan="4" style="text-align: center; padding: 20px;">No hay registros en la bitácora</td></tr>';
        }

        $html .= '</tbody></table>
                </body>
                </html>';

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $nombreArchivo = 'reporte_bitacora_' . date('Y-m-d_H-i-s') . '.pdf';
        
        $this->reporteModel->guardar(
            'Reporte de Bitácora',
            'PDF',
            $nombreArchivo,
            $_SESSION['user']['id'],
            '{}'
        );

        // Limpiar sesión
        unset($_SESSION['formato_reporte']);
        
        $dompdf->stream($nombreArchivo, ['Attachment' => true]);
    }

    private function descargarExcel() {
        $bitacoras = $this->bitacoraModel->getAll([]);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Bitácora');

        // Título
        $sheet->setCellValue('A1', 'Reporte de Bitácora del Sistema');
        $sheet->mergeCells('A1:D1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');

        // Fecha
        $sheet->setCellValue('A2', 'Generado: ' . date('d/m/Y H:i:s'));
        $sheet->mergeCells('A2:D2');
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');

        // Encabezados
        $sheet->setCellValue('A4', 'Fecha');
        $sheet->setCellValue('B4', 'Usuario');
        $sheet->setCellValue('C4', 'Acción');
        $sheet->setCellValue('D4', 'Descripción');

        // Estilo encabezados
        $headerStyle = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '4CAF50']]
        ];
        $sheet->getStyle('A4:D4')->applyFromArray($headerStyle);

        // Datos
        $fila = 5;
        foreach ($bitacoras as $b) {
            $sheet->setCellValue('A'.$fila, date('d/m/Y H:i', strtotime($b['fecha'])));
            $sheet->setCellValue('B'.$fila, $b['usuario']);
            $sheet->setCellValue('C'.$fila, $b['accion']);
            $sheet->setCellValue('D'.$fila, $b['descripcion']);
            $fila++;
        }

        if (empty($bitacoras)) {
            $sheet->setCellValue('A5', 'No hay registros en la bitácora');
            $sheet->mergeCells('A5:D5');
            $sheet->getStyle('A5')->getAlignment()->setHorizontal('center');
        }

        // Autoajustar columnas
        foreach (range('A', 'D') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Aplicar bordes
        $lastRow = $fila > 5 ? $fila - 1 : 5;
        $sheet->getStyle('A4:D' . $lastRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'DDDDDD']
                ]
            ]
        ]);

        $nombreArchivo = 'reporte_bitacora_' . date('Y-m-d_H-i-s') . '.xlsx';
        
        $this->reporteModel->guardar(
            'Reporte de Bitácora',
            'EXCEL',
            $nombreArchivo,
            $_SESSION['user']['id'],
            '{}'
        );

        // Limpiar sesión
        unset($_SESSION['formato_reporte']);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $nombreArchivo . '"');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}
?>
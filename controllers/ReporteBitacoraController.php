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
            case 'previewPDF':
                $controller->previewPDF();
                break;
            case 'previewExcel':
                $controller->previewExcel();
                break;
            case 'descargarPDF':
                $controller->descargarPDF();
                break;
            case 'descargarExcel':
                $controller->descargarExcel();
                break;
            case 'descargarArchivoGuardado':
                $controller->descargarArchivoGuardado();
                break;
            default:
                echo "Acción no válida";
        }
    }

    private function informes() {
        $totalRegistros = count($this->bitacoraModel->getAll([]));
        include __DIR__ . '/../views/reportes/informes.php';
    }

    private function listar() {
        $reportes = $this->reporteModel->getAll();
        include __DIR__ . '/../views/reportes/listar.php';
    }

    private function previewPDF() {
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
                .btn {
                    display: inline-block;
                    padding: 12px 25px;
                    margin: 0 10px;
                    border-radius: 5px;
                    text-decoration: none;
                    font-weight: bold;
                    border: none;
                    cursor: pointer;
                    font-size: 14px;
                }
                .btn-download {
                    background: #dc3545;
                    color: white;
                }
                .btn-cancel {
                    background: #6c757d;
                    color: white;
                }
                .btn:hover {
                    opacity: 0.9;
                    transform: translateY(-2px);
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
                <button onclick="descargarPDF()" class="btn btn-download">
                    📄 DESCARGAR PDF
                </button>
                <button onclick="cancelar()" class="btn btn-cancel">
                    ❌ CANCELAR
                </button>
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
                        <th>Acción</th>
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

            <script>
                function descargarPDF() {
                    window.open("index.php?action=descargarPDF", "_blank");
                }
                
                function cancelar() {
                    window.close();
                }
            </script>
        </body>
        </html>';

        echo $html;
        exit;
    }

    private function previewExcel() {
        $bitacoras = $this->bitacoraModel->getAll([]);

        $html = '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>Vista Previa - Reporte Excel</title>
            <style>
                body { 
                    font-family: "Arial", sans-serif; 
                    margin: 0;
                    padding: 40px 20px;
                    color: #333;
                    background: #f4f6f9;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    min-height: 100vh;
                }
                .container {
                    max-width: 900px;
                    width: 100%;
                    background: white;
                    padding: 40px;
                    border-radius: 15px;
                    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
                }
                .header {
                    text-align: center;
                    margin-bottom: 30px;
                    border-bottom: 2px solid #2c3e50;
                    padding-bottom: 20px;
                }
                .title {
                    color: #2c3e50;
                    font-size: 28px;
                    margin-bottom: 10px;
                    font-weight: bold;
                }
                .subtitle {
                    color: #7f8c8d;
                    font-size: 16px;
                }
                .preview-notice {
                    background: #fff3cd;
                    border: 1px solid #ffeaa7;
                    padding: 20px;
                    border-radius: 8px;
                    margin-bottom: 25px;
                    text-align: center;
                    color: #856404;
                    font-size: 16px;
                }
                .action-buttons {
                    text-align: center;
                    margin: 40px 0 30px 0;
                    padding: 25px;
                    background: #f8f9fa;
                    border-radius: 10px;
                }
                .btn {
                    display: inline-block;
                    padding: 15px 30px;
                    margin: 0 15px;
                    border-radius: 8px;
                    text-decoration: none;
                    font-weight: bold;
                    border: none;
                    cursor: pointer;
                    font-size: 16px;
                    transition: all 0.3s ease;
                    min-width: 180px;
                }
                .btn-download {
                    background: #198754;
                    color: white;
                }
                .btn-cancel {
                    background: #6c757d;
                    color: white;
                }
                .btn:hover {
                    opacity: 0.9;
                    transform: translateY(-3px);
                    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
                }
                .instructions {
                    background: #e8f4fd;
                    padding: 25px;
                    border-radius: 8px;
                    margin: 25px 0;
                    border-left: 5px solid #0dcaf0;
                    text-align: center;
                }
                .stats {
                    background: #e9ecef;
                    padding: 20px;
                    border-radius: 8px;
                    text-align: center;
                    margin: 25px 0;
                    font-size: 18px;
                    font-weight: bold;
                }
                .table-preview {
                    width: 100%;
                    border-collapse: collapse;
                    margin: 25px 0;
                    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
                }
                .table-preview th {
                    background: #2c3e50;
                    color: white;
                    padding: 15px;
                    text-align: center;
                    border: 1px solid #ddd;
                    font-weight: bold;
                }
                .table-preview td {
                    padding: 12px;
                    border: 1px solid #ddd;
                    text-align: center;
                }
                .table-preview tr:nth-child(even) {
                    background: #f9f9f9;
                }
                .table-preview tr:hover {
                    background: #f1f1f1;
                }
                .data-container {
                    max-height: 400px;
                    overflow-y: auto;
                    margin: 25px 0;
                    border: 2px solid #e9ecef;
                    border-radius: 8px;
                    padding: 10px;
                }
                .instructions h3 {
                    margin-top: 0;
                    color: #2c3e50;
                    font-size: 20px;
                }
                .instructions ol {
                    text-align: left;
                    display: inline-block;
                    margin: 15px 0;
                }
                .instructions li {
                    margin: 10px 0;
                    font-size: 15px;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="header">
                    <div class="title">VISTA PREVIA - REPORTE EXCEL</div>
                    <div class="subtitle">Bitácora del Sistema</div>
                </div>

                <div class="preview-notice">
                    <strong>📊 VISTA PREVIA EXCEL</strong><br>
                    Revise el contenido antes de descargar el archivo Excel definitivo
                </div>

                <div class="stats">
                    <strong>Total de registros en bitácora:</strong> ' . count($bitacoras) . '
                </div>

                <div class="data-container">
                    <table class="table-preview">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Usuario</th>
                                <th>Acción</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>';

        $previewData = array_slice($bitacoras, 0, 15);
        foreach ($previewData as $b) {
            $html .= '<tr>
                        <td>' . date('d/m/Y H:i', strtotime($b['fecha'])) . '</td>
                        <td>' . htmlspecialchars($b['usuario']) . '</td>
                        <td>' . htmlspecialchars($b['accion']) . '</td>
                        <td>' . htmlspecialchars($b['descripcion']) . '</td>
                      </tr>';
        }

        if (count($bitacoras) > 15) {
            $html .= '<tr>
                        <td colspan="4" style="text-align: center; padding: 20px; font-style: italic; background: #f8f9fa;">
                        ... y ' . (count($bitacoras) - 15) . ' registros más en el archivo completo
                        </td>
                      </tr>';
        }

        if (empty($bitacoras)) {
            $html .= '<tr><td colspan="4" style="text-align: center; padding: 25px; color: #6c757d;">No hay registros en la bitácora</td></tr>';
        }

        $html .= '</tbody>
                    </table>
                </div>

                <div class="instructions">
                    <h3>📝 INSTRUCCIONES</h3>
                    <ol>
                        <li>Revise el contenido del reporte arriba</li>
                        <li>Si está correcto, use <strong>"DESCARGAR EXCEL"</strong> para guardar el archivo definitivo</li>
                        <li>Use <strong>"CANCELAR"</strong> para volver atrás sin descargar</li>
                    </ol>
                </div>

                <div class="action-buttons">
                    <button onclick="descargarExcel()" class="btn btn-download">
                        📊 DESCARGAR EXCEL
                    </button>
                    <button onclick="cancelar()" class="btn btn-cancel">
                        ❌ CANCELAR
                    </button>
                </div>
            </div>

            <script>
                function descargarExcel() {
                    window.open("index.php?action=descargarExcel", "_blank");
                }
                
                function cancelar() {
                    window.close();
                }
            </script>
        </body>
        </html>';

        echo $html;
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
                <div class="subtitle">Total de registros: ' . count($bitacoras) . '</div>
            </div>

            <table class="table">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Usuario</th>
                        <th>Acción</th>
                        <th>Acción</th>
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

        $dompdf->stream($nombreArchivo, ['Attachment' => true]);
        exit;
    }

    private function descargarExcel() {
        $bitacoras = $this->bitacoraModel->getAll([]);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Bitácora');

        // Título - Centrado
        $sheet->setCellValue('A1', 'REPORTE DE BITÁCORA DEL SISTEMA');
        $sheet->mergeCells('A1:D1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');

        // Fecha - Centrado
        $sheet->setCellValue('A2', 'Generado: ' . date('d/m/Y H:i:s'));
        $sheet->mergeCells('A2:D2');
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A2')->getFont()->setSize(12);

        // Total de registros - Centrado
        $sheet->setCellValue('A3', 'Total de registros: ' . count($bitacoras));
        $sheet->mergeCells('A3:D3');
        $sheet->getStyle('A3')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A3')->getFont()->setBold(true)->setSize(12);

        // Espacio
        $sheet->setCellValue('A4', '');

        // Encabezados - Centrados
        $sheet->setCellValue('A5', 'FECHA');
        $sheet->setCellValue('B5', 'USUARIO');
        $sheet->setCellValue('C5', 'ACCIÓN');
        $sheet->setCellValue('D5', 'ACCIÓN');

        // Estilo encabezados - Centrados
        $headerStyle = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 12],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '4CAF50']],
            'alignment' => ['horizontal' => 'center', 'vertical' => 'center']
        ];
        $sheet->getStyle('A5:D5')->applyFromArray($headerStyle);

        // Datos - Centrados
        $fila = 6;
        foreach ($bitacoras as $b) {
            $sheet->setCellValue('A'.$fila, date('d/m/Y H:i', strtotime($b['fecha'])));
            $sheet->setCellValue('B'.$fila, $b['usuario']);
            $sheet->setCellValue('C'.$fila, $b['accion']);
            $sheet->setCellValue('D'.$fila, $b['descripcion']);
            
            // Centrar todas las celdas de datos
            $sheet->getStyle('A'.$fila.':D'.$fila)->getAlignment()->setHorizontal('center');
            $fila++;
        }

        if (empty($bitacoras)) {
            $sheet->setCellValue('A6', 'No hay registros en la bitácora');
            $sheet->mergeCells('A6:D6');
            $sheet->getStyle('A6')->getAlignment()->setHorizontal('center');
            $sheet->getStyle('A6')->getFont()->setItalic(true);
        }

        // Autoajustar columnas
        foreach (range('A', 'D') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Aplicar bordes a toda la tabla
        $lastRow = $fila > 6 ? $fila - 1 : 6;
        $sheet->getStyle('A5:D' . $lastRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'DDDDDD']
                ]
            ]
        ]);

        // Centrar verticalmente todas las celdas
        $sheet->getStyle('A1:D' . $lastRow)->getAlignment()->setVertical('center');

        $nombreArchivo = 'reporte_bitacora_' . date('Y-m-d_H-i-s') . '.xlsx';
        
        $this->reporteModel->guardar(
            'Reporte de Bitácora',
            'EXCEL',
            $nombreArchivo,
            $_SESSION['user']['id'],
            '{}'
        );

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $nombreArchivo . '"');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    private function descargarArchivoGuardado() {
        // Para archivos guardados, regeneramos el reporte
        $bitacoras = $this->bitacoraModel->getAll([]);
        
        if (isset($_GET['tipo']) && $_GET['tipo'] == 'excel') {
            $this->descargarExcel();
        } else {
            $this->descargarPDF();
        }
    }
}
?>
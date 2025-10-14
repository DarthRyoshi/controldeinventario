<?php 
if (!isset($_SESSION['user'])) { 
    header("Location: index.php?action=login"); 
    exit; 
} 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Generar Informes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f4f6f9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .logo-img { height: 60px; cursor:pointer; margin-bottom:20px; display:block; margin:auto; }
        .card { border-radius:15px; padding:30px; background:#fff; box-shadow:0 5px 20px rgba(0,0,0,0.1); max-width:1200px; margin:auto;}
        h2 { text-align:center; margin-bottom:20px; }
        .btn-export { padding: 12px 25px; font-size: 1em; margin: 5px; }
        .preview-container { background: white; padding: 20px; border-radius: 10px; margin-top: 20px; border: 2px solid #e9ecef; }
        .preview-header { background: #2c3e50; color: white; padding: 15px; border-radius: 5px; margin-bottom: 15px; }
        .preview-table { width: 100%; border-collapse: collapse; }
        .preview-table th { background: #4CAF50; color: white; padding: 10px; text-align: left; border: 1px solid #ddd; }
        .preview-table td { padding: 8px; border: 1px solid #ddd; }
        .preview-table tr:nth-child(even) { background: #f9f9f9; }
        .format-options { background: #e9ecef; padding: 20px; border-radius: 10px; margin-bottom: 20px; }
    </style>
</head>
<body>
<div class="container mt-5">
    <img src="assets/images/iconomuni.png" class="logo-img" onclick="window.location='index.php?action=dashboard'">
    <div class="card">
        <h2>Generar Informes de Bitácora</h2>

        <!-- Selección de formato -->
        <div class="format-options">
            <h5 class="text-center mb-4">📋 ¿Cómo quieres ver tu reporte?</h5>
            <div class="row justify-content-center">
                <div class="col-md-5 mb-3">
                    <form action="index.php?action=previewReporte" method="POST">
                        <input type="hidden" name="formato" value="pdf">
                        <button type="submit" class="btn btn-danger btn-lg w-100 py-3">
                            <i class="fas fa-file-pdf fa-2x mb-2 d-block"></i>
                            Previsualizar PDF
                        </button>
                        <small class="text-muted d-block mt-2 text-center">
                            Ver en formato PDF antes de descargar
                        </small>
                    </form>
                </div>
                <div class="col-md-5 mb-3">
                    <form action="index.php?action=previewReporte" method="POST">
                        <input type="hidden" name="formato" value="excel">
                        <button type="submit" class="btn btn-success btn-lg w-100 py-3">
                            <i class="fas fa-file-excel fa-2x mb-2 d-block"></i>
                            Previsualizar Excel
                        </button>
                        <small class="text-muted d-block mt-2 text-center">
                            Ver en formato Excel antes de descargar
                        </small>
                    </form>
                </div>
            </div>
        </div>

        <!-- Previsualización de ejemplo -->
        <div class="preview-container">
            <div class="preview-header">
                <h4 class="mb-0">👁️ Vista Previa de Ejemplo</h4>
                <small>Así se verá tu reporte (primeros 10 registros)</small>
            </div>
            
            <div class="table-responsive">
                <table class="preview-table">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Usuario</th>
                            <th>Acción</th>
                            <th>Descripción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($bitacorasPreview)): ?>
                            <?php foreach($bitacorasPreview as $row): ?>
                                <tr>
                                    <td><?= date('d/m/Y H:i', strtotime($row['fecha'])) ?></td>
                                    <td><?= htmlspecialchars($row['usuario']) ?></td>
                                    <td><?= htmlspecialchars($row['accion']) ?></td>
                                    <td><?= htmlspecialchars($row['descripcion']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center text-muted py-3">
                                    No hay registros en la bitácora
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <div class="mt-3 text-muted">
                <small>Total de registros en bitácora: <?= $totalRegistros ?></small>
            </div>
        </div>

        <!-- Enlaces adicionales -->
        <div class="text-center mt-4">
            <a href="index.php?action=listarInformes" class="btn btn-info btn-export">
                📁 Ver Informes Guardados
            </a>
            
            <a href="index.php?action=listar" class="btn btn-secondary">← Volver a Bitácora</a>
        </div>
    </div>
</div>
</body>
</html>
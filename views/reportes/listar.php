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
    <title>Informes Guardados</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f4f6f9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .logo-img { height: 60px; cursor:pointer; margin-bottom:20px; display:block; margin:auto; }
        .card { border-radius:15px; padding:30px; background:#fff; box-shadow:0 5px 20px rgba(0,0,0,0.1); max-width:1200px; margin:auto;}
        h2 { text-align:center; margin-bottom:20px; }
    </style>
</head>
<body>
<div class="container mt-5">
    <img src="assets/images/iconomuni.png" class="logo-img" onclick="window.location='index.php?action=dashboard'">
    <div class="card">
        <h2>Informes Guardados</h2>
        
        <?php if (!empty($reportes)): ?>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>Nombre</th>
                            <th>Tipo</th>
                            <th>Fecha</th>
                            <th>Usuario</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($reportes as $reporte): ?>
                        <tr>
                            <td><?= htmlspecialchars($reporte['nombre_reporte']) ?></td>
                            <td>
                                <span class="badge bg-<?= $reporte['tipo_reporte'] == 'PDF' ? 'danger' : 'success' ?>">
                                    <?= htmlspecialchars($reporte['tipo_reporte']) ?>
                                </span>
                            </td>
                            <td><?= date('d/m/Y H:i', strtotime($reporte['fecha_generacion'])) ?></td>
                            <td><?= htmlspecialchars($reporte['usuario_nombre'] ?? 'Sistema') ?></td>
                            <td>
                                <a href="<?= htmlspecialchars($reporte['ruta_archivo']) ?>" class="btn btn-sm btn-success" download>📥 Descargar</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-info text-center">
                <h5>No hay informes guardados</h5>
                <p>Genera tu primer informe desde la sección de generación de informes.</p>
            </div>
        <?php endif; ?>

        <a href="index.php?action=informesBitacora" class="btn btn-secondary">← Volver a Generar Informes</a>
    </div>
</div>
</body>
</html>
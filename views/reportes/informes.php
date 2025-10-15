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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background: #f4f6f9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .logo-img { height: 60px; cursor:pointer; margin-bottom:20px; display:block; margin:auto; }
        .card { border-radius:15px; padding:30px; background:#fff; box-shadow:0 5px 20px rgba(0,0,0,0.1); max-width:500px; margin:auto;}
        h2 { text-align:center; margin-bottom:30px; color: #2c3e50; }
        .btn-option { 
            padding: 15px; 
            font-size: 1em; 
            margin: 10px 0;
            border-radius: 8px;
            border: none;
            transition: all 0.3s ease;
            width: 100%;
        }
        .btn-option:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .btn-pdf { background: #dc3545; color: white; }
        .btn-excel { background: #198754; color: white; }
    </style>
</head>
<body>
<div class="container mt-5">
    <img src="assets/images/iconomuni.png" class="logo-img" onclick="window.location='index.php?action=dashboard'">
    <div class="card">
        <h2>📊 Generar Reportes</h2>

        <!-- Botones principales -->
        <div class="text-center">
            <a href="index.php?action=previewPDF" target="_blank" class="btn btn-pdf btn-option">
                <i class="fas fa-file-pdf me-2"></i>
                Previsualizar PDF
            </a>

            <a href="index.php?action=previewExcel" target="_blank" class="btn btn-excel btn-option">
                <i class="fas fa-file-excel me-2"></i>
                Previsualizar Excel
            </a>
        </div>

        <!-- Botones secundarios -->
        <div class="text-center">
            <div class="d-grid gap-2">
                <a href="index.php?action=listarInformes" class="btn btn-info">
                    <i class="fas fa-history me-2"></i>Ver Informes Guardados
                </a>
                
                <a href="index.php?action=listar" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Volver a Bitácora
                </a>
            </div>
        </div>
    </div>
</div>
</body>
</html>
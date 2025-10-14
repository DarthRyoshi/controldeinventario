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
    <title>Listado de Bitácora</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f4f6f9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .logo-img { height: 60px; cursor:pointer; margin-bottom:20px; display:block; margin:auto; }
        .card { border-radius:15px; padding:30px; background:#fff; box-shadow:0 5px 20px rgba(0,0,0,0.1); max-width:1000px; margin:auto;}
        h2 { text-align:center; margin-bottom:20px; }
        table { background:#fff; border-radius:10px; overflow:hidden; }
        th, td { vertical-align: middle !important; text-align: center; }
        .btn { border-radius: 8px; }
    </style>
</head>
<body>
<div class="container mt-5">
    <img src="assets/images/iconomuni.png" class="logo-img" onclick="window.location='index.php?action=dashboard'">
    <div class="card">
        <h2>Listado de Bitácora</h2>

        <!-- Filtros de fecha -->
        <form method="GET" action="" class="mb-3 d-flex gap-2 align-items-end flex-wrap">
            <div>
                <label class="form-label">Desde:</label>
                <input type="date" name="fecha_inicio" class="form-control" value="<?= htmlspecialchars($_GET['fecha_inicio'] ?? '') ?>">
            </div>
            <div>
                <label class="form-label">Hasta:</label>
                <input type="date" name="fecha_fin" class="form-control" value="<?= htmlspecialchars($_GET['fecha_fin'] ?? '') ?>">
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Filtrar</button>
                <form method="GET" action="index.php" style="display: inline;">
                    <input type="hidden" name="action" value="informesBitacora">
                    <input type="hidden" name="fecha_inicio" value="<?= $_GET['fecha_inicio'] ?? '' ?>">
                    <input type="hidden" name="fecha_fin" value="<?= $_GET['fecha_fin'] ?? '' ?>">
                    <button type="submit" class="btn btn-info">Reportes</button>
                </form>
            </div>
        </form>

        <!-- Tabla de bitácora -->
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Fecha</th>
                        <th>Acción</th>
                        <th>Descripción</th>
                        <th>Usuario</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($bitacoras)): ?>
                        <?php foreach($bitacoras as $row): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['fecha']) ?></td>
                                <td><?= htmlspecialchars($row['accion']) ?></td>
                                <td><?= htmlspecialchars($row['descripcion']) ?></td>
                                <td><?= htmlspecialchars($row['usuario']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4"><em>No hay registros en la bitácora</em></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <a href="index.php?action=dashboard" class="btn btn-secondary mt-3">Volver a Inicio</a>
    </div>
</div>
</body>
</html>
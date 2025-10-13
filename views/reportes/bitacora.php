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
    <title>Reporte de Bitácora</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f4f6f9; font-family: 'Segoe UI', sans-serif; }
        .logo-img { height: 60px; cursor:pointer; margin-bottom:15px; display:block; margin:auto; }
        .card { border-radius:15px; padding:25px; background:#fff; box-shadow:0 5px 20px rgba(0,0,0,0.1); }
        th, td { text-align:center; vertical-align:middle; }
    </style>
</head>
<body>
<div class="container mt-4">
    <img src="assets/images/iconomuni.png" class="logo-img" onclick="window.location='index.php?action=dashboard'">
    <div class="card">
        <h2 class="text-center mb-4">Reporte de Bitácora</h2>

        <form method="GET" action="index.php" class="row g-3 mb-4">
            <input type="hidden" name="action" value="reporteBitacora">
            <div class="col-md-4">
                <label>Desde:</label>
                <input type="date" name="fecha_inicio" class="form-control" value="<?= htmlspecialchars($_GET['fecha_inicio'] ?? '') ?>">
            </div>
            <div class="col-md-4">
                <label>Hasta:</label>
                <input type="date" name="fecha_fin" class="form-control" value="<?= htmlspecialchars($_GET['fecha_fin'] ?? '') ?>">
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary me-2">Filtrar</button>
                <a href="index.php?action=exportarPDF&fecha_inicio=<?= $_GET['fecha_inicio'] ?? '' ?>&fecha_fin=<?= $_GET['fecha_fin'] ?? '' ?>" class="btn btn-danger me-2">PDF</a>
                <a href="index.php?action=exportarExcel&fecha_inicio=<?= $_GET['fecha_inicio'] ?? '' ?>&fecha_fin=<?= $_GET['fecha_fin'] ?? '' ?>" class="btn btn-success">Excel</a>
            </div>
        </form>

        <table class="table table-striped">
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
                    <?php foreach ($bitacoras as $b): ?>
                        <tr>
                            <td><?= htmlspecialchars($b['fecha']) ?></td>
                            <td><?= htmlspecialchars($b['accion']) ?></td>
                            <td><?= htmlspecialchars($b['descripcion']) ?></td>
                            <td><?= htmlspecialchars($b['usuario']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="4">No hay registros</td></tr>
                <?php endif; ?>
            </tbody>
        </table>

        <a href="index.php?action=listar" class="btn btn-secondary mt-3">Volver a Bitácora</a>
    </div>
</div>
</body>
</html>

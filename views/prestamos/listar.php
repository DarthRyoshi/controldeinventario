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
    <title>Listado de Préstamos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f4f6f9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .logo-img { height: 60px; cursor:pointer; margin-bottom:20px; display:block; margin:auto; }
        .card { border-radius:15px; padding:30px; background:#fff; box-shadow:0 5px 20px rgba(0,0,0,0.1); max-width:1000px; margin:auto;}
        h2 { text-align:center; margin-bottom:20px; }
        table { background:#fff; border-radius:10px; overflow:hidden; }
        th, td { vertical-align: middle !important; text-align: center; }
    </style>
</head>
<body>
<div class="container mt-5">
    <img src="assets/images/iconomuni.png" class="logo-img" onclick="window.location='index.php?action=dashboard'">
    <div class="card">
        <h2>Listado de Préstamos</h2>
        <a href="index.php?action=crearPrestamo" class="btn btn-success mb-3">Crear Préstamo</a>
        <table class="table table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Usuario</th>
                    <th>Producto</th>
                    <th>Fecha Préstamo</th>
                    <th>Fecha Devolución</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($prestamos as $p): ?>
                <tr>
                    <td><?= htmlspecialchars($p['usuario_nombre']) ?></td>
                    <td><?= htmlspecialchars($p['producto_nombre']) ?></td>
                    <td><?= date('Y-m-d H:i:s', strtotime($p['fecha_prestamo'])) ?></td>
                    <td><?= !empty($p['fecha_devolucion']) ? date('Y-m-d H:i:s', strtotime($p['fecha_devolucion'])) : '-' ?></td>
                    <td><?= htmlspecialchars($p['estado']) ?></td>
                    <td>
                        <?php if ($p['estado'] === 'prestado'): ?>
                            <a href="index.php?action=devolverPrestamo&id=<?= $p['id'] ?>" class="btn btn-primary btn-sm">Devolver</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="index.php?action=dashboard" class="btn btn-secondary btn-back">Volver al Dashboard</a>
    </div>
</div>
</body>
</html>

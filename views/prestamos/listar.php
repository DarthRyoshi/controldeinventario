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
        .card { border-radius:15px; padding:30px; background:#fff; box-shadow:0 5px 20px rgba(0,0,0,0.1); max-width:1200px; margin:auto;}
        h2 { text-align:center; margin-bottom:20px; }
        table { background:#fff; border-radius:10px; overflow:hidden; }
        th, td { vertical-align: middle !important; text-align: center; }
        ul { padding-left: 20px; text-align: left; margin:0; }
        .estado-completo { color: green; font-weight: bold; }
        .estado-vigente { color: orange; font-weight: bold; }
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
                    <th>Productos</th>
                    <th>Fecha Préstamo</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($prestamos)): ?>
                    <?php foreach ($prestamos as $p): ?>
                        <tr>
                            <td><?= htmlspecialchars($p['usuario_nombre']) ?></td>
                            <td>
                                <ul>
                                    <?php if (!empty($p['detalle'])): ?>
                                        <?php foreach ($p['detalle'] as $d): ?>
                                            <li>
                                                <?= htmlspecialchars($d['producto_nombre']) ?>  
                                                (Serial: <?= htmlspecialchars($d['serial']) ?>)
                                                <?php if (!empty($d['fecha_devolucion'])): ?>
                                                    <span class="text-success">✔ Devuelto</span>
                                                <?php else: ?>
                                                    <span class="text-danger">⏳ Prestado</span>
                                                <?php endif; ?>
                                            </li>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <li><em>Sin productos registrados</em></li>
                                    <?php endif; ?>
                                </ul>
                            </td>
                            <td><?= date('Y-m-d H:i:s', strtotime($p['fecha_prestamo'])) ?></td>
                            <td class="<?= $p['estado'] === 'completo' ? 'estado-completo' : 'estado-vigente' ?>">
                                <?= htmlspecialchars(ucfirst($p['estado'])) ?>
                            </td>
                            <td>
                                <?php 
                                $pendientes = false;
                                foreach ($p['detalle'] as $d) {
                                    if (empty($d['fecha_devolucion'])) {
                                        $pendientes = true; 
                                        break;
                                    }
                                }
                                if ($pendientes): ?>
                                    <a href="index.php?action=devolverPrestamo&id=<?= $p['id'] ?>" class="btn btn-primary btn-sm">
                                        Devolver
                                    </a>
                                <?php else: ?>
                                    <span class="badge bg-success">Completo</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="5"><em>No hay préstamos registrados</em></td></tr>
                <?php endif; ?>
            </tbody>
        </table>

        <a href="index.php?action=dashboard" class="btn btn-secondary btn-back">Volver a Inicio</a>
    </div>
</div>
</body>
</html>
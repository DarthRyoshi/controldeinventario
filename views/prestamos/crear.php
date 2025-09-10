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
    <title>Crear Préstamo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f4f6f9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .logo-img { height: 60px; cursor:pointer; margin-bottom:20px; display:block; margin:auto; }
        .card { border-radius:15px; padding:30px; background:#fff; box-shadow:0 5px 20px rgba(0,0,0,0.1); max-width:600px; margin:auto;}
    </style>
</head>
<body>
<div class="container mt-5">
    <img src="assets/images/iconomuni.png" class="logo-img" onclick="window.location='index.php?action=dashboard'">
    <div class="card">
        <h2>Crear Préstamo</h2>
        <form action="index.php?action=crearPrestamo" method="POST">
            <div class="mb-3">
                <label>Usuario</label>
                <select name="usuario_id" class="form-control" required>
                    <?php foreach ($usuarios as $u): ?>
                        <option value="<?= $u['id'] ?>">
                            <?= htmlspecialchars($u['nombre']) ?> (<?= htmlspecialchars($u['rol']) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label>Producto</label>
                <select name="producto_id" class="form-control" required>
                    <?php foreach ($productos as $prod): ?>
                        <?php if ($prod['stock'] > 0): ?>
                            <option value="<?= $prod['id'] ?>">
                                <?= htmlspecialchars($prod['nombre']) ?> - Stock: <?= $prod['stock'] ?>
                            </option>
                        <?php else: ?>
                            <option value="<?= $prod['id'] ?>" disabled>
                                <?= htmlspecialchars($prod['nombre']) ?> - SIN STOCK
                            </option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label>Fecha Préstamo</label>
                <input type="text" class="form-control" value="<?= date('Y-m-d H:i:s') ?>" disabled>
            </div>

            <button type="submit" class="btn btn-success">Crear Préstamo</button>
            <a href="index.php?action=prestamos" class="btn btn-secondary">Volver</a>
        </form>
    </div>
</div>
</body>
</html>

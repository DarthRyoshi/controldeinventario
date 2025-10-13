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
    <title>Devolver Préstamo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f4f6f9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .logo-img { height: 60px; cursor:pointer; margin-bottom:20px; display:block; margin:auto; }
        .card { border-radius:15px; padding:30px; background:#fff; box-shadow:0 5px 20px rgba(0,0,0,0.1); max-width:600px; margin:auto;}
        h2 { text-align:center; margin-bottom:20px; }
    </style>
</head>
<body>
<div class="container mt-5">
    <img src="assets/images/iconomuni.png" class="logo-img" onclick="window.location='index.php?action=dashboard'">
    <div class="card">
        <h2>Devolver Préstamo</h2>
        <form action="" method="POST">
            <?php if (!empty($productos)): ?>
                <?php foreach ($productos as $p): 
                    $nombre = htmlspecialchars($p['nombre'] ?? 'Sin nombre');
                    $serial = htmlspecialchars($p['serial'] ?? '');
                    $detalle_id = $p['id'];
                    $prestada = (int)($p['cantidad_prestada'] ?? 1);
                    $devuelta = (int)($p['cantidad_devuelta'] ?? 0);
                    $pendiente = max(0, $prestada - $devuelta);
                ?>
                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="devolver[]" value="<?= $detalle_id ?>" id="chk<?= $detalle_id ?>" <?= $pendiente <= 0 ? 'disabled' : '' ?>>
                        <label class="form-check-label" for="chk<?= $detalle_id ?>">
                            <?= $nombre ?> (Serial: <?= $serial ?>)
                        </label>
                    </div>
                    <div class="small text-muted">
                        Prestado: <?= $prestada ?> — Devuelto: <?= $devuelta ?>
                        <?php if ($pendiente > 0): ?>
                            <span class="text-warning"> — Pendiente: <?= $pendiente ?></span>
                        <?php else: ?>
                            <span class="text-success"> — Completado</span>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No hay productos pendientes de devolución en este préstamo.</p>
            <?php endif; ?>

            <button type="submit" class="btn btn-primary mt-3">Registrar Devolución</button>
            <a href="index.php?action=prestamos" class="btn btn-secondary mt-3">Cancelar</a>
        </form>
    </div>
</div>
</body>
</html>
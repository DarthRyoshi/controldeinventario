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
        .logo-img { height: 60px; cursor:pointer; margin-bottom:15px; display:block; margin:auto; }
        .card { border-radius:15px; padding:25px; background:#fff; box-shadow:0 5px 20px rgba(0,0,0,0.05); max-width:550px; margin:auto;}
        h2 { text-align:center; margin-bottom:20px; font-size:1.5rem; font-weight:600; }
        .form-check { margin-bottom:5px; }
        .small-text { font-size:0.8rem; color:#6c757d; }

        /* Cambiar color del checkbox */
        input[type="checkbox"] {
            accent-color: #0d6efd; /* azul Bootstrap primary */
        }
    </style>
</head>
<body>
<div class="container mt-4">
    <img src="assets/images/iconomuni.png" class="logo-img" onclick="window.location='index.php?action=dashboard'">
    <div class="card">
        <h2>Crear Préstamo</h2>
        <form action="index.php?action=crearPrestamo" method="POST">
            <div class="mb-3">
                <select name="usuario_id" class="form-control" required>
                    <option value="">Selecciona usuario para préstamo</option>
                    <?php foreach ($usuarios as $u): ?>
                        <option value="<?= $u['id'] ?>"><?= htmlspecialchars($u['nombre']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <?php if (!empty($productos)): ?>
                    <?php foreach ($productos as $prod): ?>
                        <?php if ($prod['stock'] > 0): ?>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="productos[<?= $prod['id'] ?>][id]" value="<?= $prod['id'] ?>" id="prod<?= $prod['id'] ?>">
                                <label class="form-check-label" for="prod<?= $prod['id'] ?>">
                                    <?= htmlspecialchars($prod['nombre']) ?> 
                                    <span class="small-text">(Serial: <?= htmlspecialchars($prod['serial']) ?>, Stock: <?= $prod['stock'] ?>)</span>
                                </label>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="small-text">No hay productos disponibles para préstamo.</p>
                <?php endif; ?>
            </div>

            <div class="d-flex justify-content-between mt-3">
                <a href="index.php?action=prestamos" class="btn btn-secondary btn-sm">Cancelar</a>
                <button type="submit" class="btn btn-success btn-sm">Crear Préstamo</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>

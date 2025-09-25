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
            <?php foreach ($productos as $p): ?>
                <div class="mb-3">
                    <label>
                        <?= htmlspecialchars($p['nombre']) ?>  
                        (Serial: <?= htmlspecialchars($p['serial']) ?>)  
                        - Prestado: <?= $p['cantidad_prestada'] ?>,  
                        Devuelto: <?= $p['cantidad_devuelta'] ?>
                    </label>
                    <input type="number" name="devolver[<?= $p['id'] ?>]" value="0" min="0" max="<?= $p['cantidad_prestada'] - $p['cantidad_devuelta'] ?>" class="form-control mt-1" style="width:120px;">
                </div>
            <?php endforeach; ?>
            <button type="submit" class="btn btn-primary mt-3">Registrar Devolución</button>
            <a href="index.php?action=prestamos" class="btn btn-secondary mt-3">Cancelar</a>
        </form>
    </div>
</div>
</body>
</html>

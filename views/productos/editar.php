<?php if (!isset($_SESSION['user'])) { header("Location: index.php?action=login"); exit; } ?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Editar Producto</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body { background: #f4f6f9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
.logo-img { height: 60px; cursor:pointer; margin-bottom:20px; display:block; margin:auto; }
.card { border-radius:15px; padding:30px; background:#fff; box-shadow:0 5px 20px rgba(0,0,0,0.1); max-width:600px; margin:auto;}
.btn-bottom { display:block; margin:auto; margin-top:20px; }
</style>
</head>
<body>
<div class="container mt-5">
<img src="assets/images/iconomuni.png" class="logo-img" onclick="window.location='index.php?action=dashboard'">
<div class="card">
<h2>Editar Producto</h2>

<form action="index.php?action=editarProducto&id=<?= $producto['id'] ?>" method="POST" enctype="multipart/form-data">
    <div class="mb-3">
        <label>Nombre</label>
        <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($producto['nombre']) ?>" required>
    </div>
    <div class="mb-3">
        <label>Categoria</label>
        <input type="text" name="categoria" class="form-control" value="<?= htmlspecialchars($producto['categoria']) ?>" required>
    </div>
    <div class="mb-3">
        <label>Stock</label>
        <input type="number" name="stock" class="form-control" min="0" value="<?= htmlspecialchars($producto['stock']) ?>" required>
    </div>
    <div class="mb-3">
        <label>Imagen</label>
        <input type="file" name="imagen" class="form-control" accept="image/*">
        <?php if (!empty($producto['imagen'])): ?>
            <img src="assets/images/productos/<?= $producto['imagen'] ?>" style="height:80px; margin-top:10px;">
        <?php endif; ?>
    </div>
    <div class="mb-3">
        <label>Descripción</label>
        <textarea name="descripcion" class="form-control"><?= htmlspecialchars($producto['descripcion']) ?></textarea>
    </div>
    <div class="mb-3">
        <label>Estado</label>
        <select name="estado" class="form-control">
            <option value="activo" <?= ($producto['estado']=='activo')?'selected':'' ?>>Activo</option>
            <option value="inactivo" <?= ($producto['estado']=='inactivo')?'selected':'' ?>>Inactivo</option>
        </select>
    </div>
    <div class="mb-3">
        <label>Serial</label>
        <input type="text" class="form-control" value="<?= htmlspecialchars($producto['serial']) ?>" readonly>
    </div>

    <button type="submit" class="btn btn-success">Actualizar Producto</button>
    <a href="index.php?action=productos" class="btn btn-secondary btn-bottom">Volver</a>
</form>
</div>
</div>
</body>
</html>

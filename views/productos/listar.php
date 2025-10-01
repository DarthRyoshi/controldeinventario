<?php 
if (!isset($_SESSION['user'])) { header("Location: index.php?action=login"); exit; } 
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Listado de Productos</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body { background: #f4f6f9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
.logo-img { height: 60px; cursor:pointer; margin-bottom:20px; display:block; margin:auto; }
.card { border-radius:15px; padding:30px; background:#fff; box-shadow:0 5px 20px rgba(0,0,0,0.1); max-width:1000px; margin:auto;}
h2 { text-align:center; margin-bottom:20px; }
table { background:#fff; border-radius:10px; overflow:hidden; }
th, td { vertical-align: middle !important; text-align: center; }
.product-img { width: 80px; height: 80px; object-fit: cover; cursor:pointer; border-radius:5px; }
.truncate { max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; cursor:pointer; color:blue; }
.modal-img { width:auto; max-width:400px; max-height:400px; display:block; margin:20px auto; border-radius:10px; box-shadow:0 5px 15px rgba(0,0,0,0.2); transition: transform 0.3s ease; }
</style>
</head>
<body>
<div class="container mt-5">
<img src="assets/images/iconomuni.png" class="logo-img" onclick="window.location='index.php?action=dashboard'">
<div class="card">
<h2>Listado de Productos</h2>
<a href="index.php?action=crearProducto" class="btn btn-success mb-3">Crear Producto</a>
<table class="table table-striped">
    <thead class="table-dark">
        <tr>
            <th>Nombre</th>
            <th>Categoria</th>
            <th>Stock</th>
            <th>Serial</th>
            <th>Imagen</th>
            <th>Descripción</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($productos as $p): ?>
        <tr>
            <td><?= htmlspecialchars($p['nombre']) ?></td>
            <td><?= htmlspecialchars($p['categoria']) ?></td>
            <td><?= htmlspecialchars($p['stock']) ?></td>
            <td><?= htmlspecialchars($p['serial']) ?></td>
            <td>
                <?php if($p['imagen'] && file_exists('assets/images/productos/'.$p['imagen'])): ?>
                    <img src="assets/images/productos/<?= $p['imagen'] ?>" class="product-img" onclick="showModal('<?= $p['imagen'] ?>')">
                <?php else: ?>
                    <img src="assets/images/no-image.png" class="product-img">
                <?php endif; ?>
            </td>
            <td class="truncate" title="<?= htmlspecialchars($p['descripcion']) ?>" onclick="showDescriptionModal('<?= htmlspecialchars(addslashes($p['descripcion'])) ?>')">
                <?= htmlspecialchars(substr($p['descripcion'], 0, 50)) ?><?= strlen($p['descripcion'])>50?'...':'' ?>
            </td>
            <td><?= htmlspecialchars($p['estado']) ?></td>
            <td>
                <a href="index.php?action=editarProducto&id=<?= $p['id'] ?>" class="btn btn-warning btn-sm">Actualizar</a>
                <a href="index.php?action=eliminarProducto&id=<?= $p['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar este producto?')">Eliminar</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<a href="index.php?action=dashboard" class="btn btn-secondary btn-back">Volver a Inicio</a>
</div>
</div>

<div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body p-0">
        <img src="" id="modalImage" class="modal-img">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="descriptionModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Descripción del Producto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body" id="modalDescriptionBody"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function showModal(filename) {
    const modalImage = document.getElementById('modalImage');
    modalImage.src = 'assets/images/productos/' + filename;
    const modal = new bootstrap.Modal(document.getElementById('imageModal'));
    modal.show();
}
function showDescriptionModal(texto) {
    document.getElementById('modalDescriptionBody').innerText = texto;
    const modal = new bootstrap.Modal(document.getElementById('descriptionModal'));
    modal.show();
}
</script>
</body>
</html>

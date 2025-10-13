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
        .card { border-radius:15px; padding:30px; background:#fff; box-shadow:0 5px 20px rgba(0,0,0,0.1); max-width:1200px; margin:auto;}
        h2 { text-align:center; margin-bottom:20px; }
        .form-check { margin-bottom:10px; padding: 10px; background: #f8f9fa; border-radius: 5px; }
        
        input[type="checkbox"] {
            accent-color: #0d6efd;
        }
        
        .categoria-group { margin-bottom: 15px; }
        .categoria-header { 
            background: #e9ecef; 
            padding: 12px 15px; 
            border-radius: 8px; 
            cursor: pointer; 
            border: 1px solid #dee2e6;
            display: flex;
            justify-content: between;
            align-items: center;
        }
        .categoria-title { 
            font-weight: bold; 
            color: #495057; 
            margin: 0;
            font-size: 1.1em; 
        }
        .categoria-content { 
            padding: 15px;
            background: #f8f9fa;
            border-radius: 0 0 8px 8px;
            display: none;
        }
        .categoria-content.show {
            display: block;
        }
        .toggle-icon { 
            margin-left: auto;
            font-weight: bold;
            color: #6c757d;
        }
        .stock-badge { background: #198754; color: white; padding: 3px 10px; border-radius: 15px; font-size: 0.8em; margin-left: 10px; }
    </style>
</head>
<body>
<div class="container mt-5">
    <img src="assets/images/iconomuni.png" class="logo-img" onclick="window.location='index.php?action=dashboard'">
    <div class="card">
        <h2>Crear Préstamo</h2>
        
        <form action="index.php?action=crearPrestamo" method="POST">
            <div class="mb-4">
                <label class="form-label fw-bold">Usuario que recibe el préstamo:</label>
                <select name="usuario_id" class="form-control" required>
                    <option value="">Selecciona un usuario</option>
                    <?php foreach ($usuarios as $u): ?>
                        <option value="<?= $u['id'] ?>"><?= htmlspecialchars($u['nombre']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold">Seleccionar Productos:</label>
                
                <?php if (!empty($productosOrganizados)): ?>
                    <?php foreach ($productosOrganizados as $categoriaNombre => $productosPorNombre): ?>
                        <div class="categoria-group">
                            <div class="categoria-header" onclick="toggleCategoria(this)">
                                <div class="categoria-title">
                                    📁 <?= htmlspecialchars($categoriaNombre) ?>
                                </div>
                                <span class="toggle-icon">▶</span>
                            </div>
                            
                            <div class="categoria-content" id="categoria-<?= md5($categoriaNombre) ?>">
                                <?php foreach ($productosPorNombre as $nombreProducto => $grupo): ?>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" 
                                               name="productos[<?= $nombreProducto ?>][nombre]" 
                                               value="<?= $nombreProducto ?>" 
                                               id="prod<?= md5($nombreProducto) ?>">
                                        <label class="form-check-label" for="prod<?= md5($nombreProducto) ?>">
                                            <strong><?= htmlspecialchars($nombreProducto) ?></strong> 
                                            <span class="stock-badge"><?= $grupo['total_stock'] ?> disponible(s)</span>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="alert alert-warning">
                        No hay productos disponibles para préstamo.
                    </div>
                <?php endif; ?>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <a href="index.php?action=prestamos" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-success">Crear Préstamo</button>
            </div>
        </form>
    </div>
</div>

<script>
function toggleCategoria(element) {
    const content = element.nextElementSibling;
    const icon = element.querySelector('.toggle-icon');
    
    content.classList.toggle('show');
    
    if (content.classList.contains('show')) {
        icon.textContent = '▼';
    } else {
        icon.textContent = '▶';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const primeraCategoria = document.querySelector('.categoria-header');
    if (primeraCategoria) {
        toggleCategoria(primeraCategoria);
    }
});
</script>
</body>
</html>
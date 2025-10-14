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
        h2 { text-align:center; margin-bottom:20px; color: #2c3e50; }
        .form-check { margin-bottom:10px; padding: 12px 15px; background: #fff; border-radius: 8px; border: 1px solid #e9ecef; }
        
        input[type="checkbox"] {
            accent-color: #0d6efd;
            transform: scale(1.2);
        }
        
        .categoria-group { margin-bottom: 15px; }
        .categoria-header { 
            background: #5d8aa8; 
            padding: 15px 20px; 
            border-radius: 8px; 
            cursor: pointer; 
            border: none;
            display: flex;
            justify-content: between;
            align-items: center;
            transition: all 0.3s ease;
        }
        .categoria-header:hover {
            background: #6b94b0;
        }
        .categoria-title { 
            font-weight: bold; 
            color: white; 
            margin: 0;
            font-size: 1.1em; 
        }
        .categoria-content { 
            padding: 20px;
            background: #f8f9fa;
            border-radius: 0 0 8px 8px;
            border: 1px solid #dee2e6;
            border-top: none;
            display: none;
        }
        .categoria-content.show {
            display: block;
        }
        .toggle-icon { 
            margin-left: auto;
            font-weight: bold;
            color: white;
            font-size: 1.1em;
        }
        .stock-badge { 
            background: #28a745; 
            color: white; 
            padding: 4px 12px; 
            border-radius: 20px; 
            font-size: 0.8em; 
            margin-left: 10px; 
            font-weight: 600;
        }
        .form-label {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 10px;
        }
        .form-control {
            border-radius: 8px;
            border: 1px solid #ddd;
            padding: 10px 15px;
        }
        .btn-success {
            background: #28a745;
            border: none;
            border-radius: 8px;
            padding: 10px 25px;
            font-weight: 600;
        }
        .btn-secondary {
            background: #6c757d;
            border: none;
            border-radius: 8px;
            padding: 10px 25px;
            font-weight: 600;
        }
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
                                            <strong style="color: #2c3e50;"><?= htmlspecialchars($nombreProducto) ?></strong> 
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
</script>
</body>
</html>
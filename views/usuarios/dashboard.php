<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Sistema de Inventario Educativo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: #f4f6f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .header {
            background: #1e3c72;
            color: white;
            padding: 15px 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            position: relative;
        }
        .header .logo-img {
            height: 40px;
            cursor: pointer;
        }
        .header .title {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            font-size: 20px;
            font-weight: bold;
        }
        .cards-container {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 50px;
        }
        .card-dashboard {
            width: 220px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            transition: 0.3s;
        }
        .card-dashboard:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        .card-icon {
            font-size: 50px;
            color: #1e3c72;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
<div class="header">
    <!-- Logo a la izquierda, más grande y con fondo blanco -->
    <img src="assets/images/iconomuni.png" 
         class="logo-img" 
         onclick="window.location='index.php?action=dashboard'" 
         style="height:70px; background:white; padding:5px; border-radius:10px; box-shadow:0 2px 5px rgba(0,0,0,0.2);">
    
    <!-- Título centrado -->
    <div class="title">Sistema de Inventario Educativo</div>
    
    <!-- Botón cerrar sesión -->
    <a href="index.php?action=logout" class="btn btn-danger">Cerrar Sesión</a>
</div>


    <div class="container text-center">
        <h2 class="mt-4">Bienvenido, <?= htmlspecialchars($usuario['nombre']); ?></h2>
        <p class="text-muted">Selecciona una opción para continuar</p>

        <div class="cards-container">
            <?php if($usuario['rol'] === 'admin'): ?>
            <div class="card text-center card-dashboard">
                <div class="card-body">
                    <i class="bi bi-people-fill card-icon"></i>
                    <h5 class="card-title">Gestionar Usuarios</h5>
                    <a href="index.php?action=usuarios" class="btn btn-primary mt-2">Abrir</a>
                </div>
            </div>
            <?php endif; ?>

            <div class="card text-center card-dashboard">
                <div class="card-body">
                    <i class="bi bi-box-seam card-icon"></i>
                    <h5 class="card-title">Gestionar Inventario</h5>
                    <a href="index.php?action=productos" class="btn btn-success mt-2">Abrir</a>
                </div>
                
            </div>
             <div class="card text-center card-dashboard">
                <div class="card-body">
                    <i class="bi bi-book card-icon"></i>
                    <h5 class="card-title">Gestionar Prestamos</h5>
                    <a href="index.php?action=prestamos" class="btn btn-success mt-2">Abrir</a>
                </div>
                
            </div>
           <div class="card text-center card-dashboard">
    <div class="card-body">
        <i class="bi bi-journal card-icon"></i>
        <h5 class="card-title">Bitácora</h5>
        <!-- Cambiamos action=bitacora por action=listar -->
        <a href="index.php?action=listar" class="btn btn-success mt-2">Abrir</a>
    </div>
</div>

        </div>
    </div>
</body>
</html>

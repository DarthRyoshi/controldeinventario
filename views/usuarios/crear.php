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
    <title>Crear Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            background: #f0f2f5; 
        }
        .logo-img { 
            height: 60px; 
            cursor: pointer; 
            display: block; 
            margin: 30px auto 20px auto; 
        }
        .card { 
            border-radius: 15px; 
            box-shadow: 0 5px 25px rgba(0,0,0,0.1); 
            padding: 30px; 
            max-width: 600px; 
            margin: auto; 
            background: #fff;
        }
        h2 { 
            text-align: center; 
            margin-bottom: 20px; 
        }
        .btn-top {
            display: block;
            margin-bottom: 20px;
        }
        .btn-bottom {
            display: block;
            width: 100%;
            margin-top: 20px;
        }
        .form-label {
            font-weight: 500;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <img src="assets/images/iconomuni.png" class="logo-img" onclick="window.location='index.php?action=dashboard'">
    <div class="card">
        <h2>Crear Usuario</h2>
        <!-- Botón Guardar / Crear arriba -->
        <button type="submit" form="crearForm" class="btn btn-success btn-top">Crear Usuario</button>

        <form id="crearForm" action="index.php?action=crearUsuario" method="POST">
            <div class="mb-3">
                <label class="form-label">RUT</label>
                <input type="text" name="rut" class="form-control" placeholder="Ej: 12345678-9" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Nombre</label>
                <input type="text" name="nombre" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Contraseña</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Rol</label>
                <select name="rol" class="form-control">
                    <option value="admin">Admin</option>
                    <option value="consulta">Consulta</option>
                    <option value="registro">Registro</option>
                </select>
            </div>

            <!-- Botón Volver abajo -->
            <a href="index.php?action=usuarios" class="btn btn-secondary btn-bottom">Volver</a>
        </form>
    </div>
</div>
</body>
</html>

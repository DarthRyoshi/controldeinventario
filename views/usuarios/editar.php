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
    <title>Editar Usuario</title>
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
        <h2>Editar Usuario</h2>

        <!-- Botón Guardar / Actualizar arriba -->
        <button type="submit" form="editarForm" class="btn btn-warning btn-top">Actualizar Usuario</button>

        <form id="editarForm" action="index.php?action=editarUsuario&id=<?= $usuarioEditar['id'] ?>" method="POST">
            <div class="mb-3">
                <label class="form-label">RUT</label>
                <input type="text" name="rut" class="form-control" value="<?= htmlspecialchars($usuarioEditar['rut']) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Nombre</label>
                <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($usuarioEditar['nombre']) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($usuarioEditar['email']) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Contraseña (dejar vacío para no cambiar)</label>
                <input type="password" name="password" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Rol</label>
                <select name="rol" class="form-control">
                    <option value="admin" <?= $usuarioEditar['rol']=='admin' ? 'selected' : '' ?>>Admin</option>
                    <option value="consulta" <?= $usuarioEditar['rol']=='consulta' ? 'selected' : '' ?>>Consulta</option>
                    <option value="registro" <?= $usuarioEditar['rol']=='registro' ? 'selected' : '' ?>>Registro</option>
                </select>
            </div>

            <!-- Botón Volver abajo -->
            <a href="index.php?action=usuarios" class="btn btn-secondary btn-bottom">Volver</a>
        </form>
    </div>
</div>
</body>
</html>

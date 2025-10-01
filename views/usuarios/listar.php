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
    <title>Listado de Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            background: #f4f6f9; 
        }
        .logo-img { 
            height: 60px; 
            cursor: pointer; 
            display: block; 
            margin: 20px auto; 
        }
        .card { 
            border-radius: 15px; 
            box-shadow: 0 5px 20px rgba(0,0,0,0.1); 
            padding: 30px; 
            max-width: 900px; 
            margin: auto; 
            background: #fff;
        }
        h2 { 
            text-align: center; 
            margin-bottom: 20px; 
        }
        .btn-success {
            margin-bottom: 20px;
        }
        table {
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
        }
        th, td {
            vertical-align: middle !important;
        }
        /* Botón Volver centrado */
        .btn-back {
            display: block;
            width: 220px;
            margin: 30px auto 0 auto;
            border-radius: 25px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <img src="assets/images/iconomuni.png" class="logo-img" onclick="window.location='index.php?action=dashboard'">
    
    <div class="card">
        <h2>Usuarios Registrados</h2>
        
        <a href="index.php?action=crearUsuario" class="btn btn-success">+ Crear Usuario</a>
        
        <table class="table table-striped">
            <thead class="table-dark">
                <tr>
                    <th>RUT</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $u): ?>
                <tr>
                    <td><?= htmlspecialchars($u['rut']) ?></td>
                    <td><?= htmlspecialchars($u['nombre']) ?></td>
                    <td><?= htmlspecialchars($u['email']) ?></td>
                    <td><?= htmlspecialchars($u['rol']) ?></td>
                    <td>
                        <a href="index.php?action=editarUsuario&id=<?= $u['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                        <a href="index.php?action=eliminarUsuario&id=<?= $u['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas eliminar este usuario?')">Eliminar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <a href="index.php?action=dashboard" class="btn btn-secondary btn-back">Volver a Inicio</a>

</div>
</body>
</html>

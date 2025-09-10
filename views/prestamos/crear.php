<?php
if (!isset($_SESSION['user'])) {
    header("Location: index.php?action=login");
    exit;
}

// Mantener los valores previamente ingresados si hubo error
$nombre = $_POST['nombre'] ?? '';
$email = $_POST['email'] ?? '';
$rol = $_POST['rol'] ?? 'admin';
$rut = $_POST['rut'] ?? '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="card p-4">
        <h2>Crear Usuario</h2>

        <form id="crearForm" action="index.php?action=crearUsuario" method="POST">
            <div class="mb-3">
                <label>RUT</label>
                <input type="text" name="rut" class="form-control" placeholder="Ej: 12345678-9" value="<?= htmlspecialchars($rut) ?>" required>
            </div>
            <div class="mb-3">
                <label>Nombre</label>
                <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($nombre) ?>" required>
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($email) ?>" required>
            </div>
            <div class="mb-3">
                <label>Contraseña</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Rol</label>
                <select name="rol" class="form-control">
                    <option value="admin" <?= $rol=='admin'?'selected':'' ?>>Admin</option>
                    <option value="consulta" <?= $rol=='consulta'?'selected':'' ?>>Consulta</option>
                    <option value="registro" <?= $rol=='registro'?'selected':'' ?>>Registro</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success">Crear Usuario</button>
            <a href="index.php?action=usuarios" class="btn btn-secondary">Volver</a>
        </form>
    </div>
</div>

<?php if (isset($error)): ?>
<script>
    alert("<?= $error ?>");
</script>
<?php endif; ?>
</body>
</html>

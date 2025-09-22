<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Control de Inventario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            height: 100vh;
            margin: 0;
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.3);
        }
        .form-control {
            border-radius: 12px;
        }
        .btn-custom {
            border-radius: 12px;
            background: #1e3c72;
            border: none;
            transition: 0.3s;
        }
        .btn-custom:hover {
            background: #2a5298;
        }
        .logo-img {
            width: 80px;
            height: auto;
            display: block;
            margin: 0 auto;
        }
        /* Botón de destrucción */
        #destroyBtn {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
        }
    </style>
</head>
<body>
    <!-- Botón de destrucción en la esquina derecha -->
    <button id="destroyBtn" class="btn btn-danger">
        <i class="bi bi-x-circle"></i> 
    </button>

    <div class="col-md-4">
        <div class="card p-4">
            <div class="text-center">
                <!-- Imagen del logo -->
                <img src="assets/images/iconomuni.png" alt="Logo" class="logo-img">
                <h3 class="mt-2">Control de Inventario</h3>
                <p class="text-muted">Accede a tu cuenta</p>
            </div>

            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>

            <form method="POST" action="index.php?action=login">
                <div class="mb-3">
                    <label for="email" class="form-label">Correo</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="correo@ejemplo.com" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="********" required>
                </div>
                <button type="submit" class="btn btn-custom w-100 text-white fw-bold">
                    <i class="bi bi-box-arrow-in-right"></i> Ingresar
                </button>
            </form>
        </div>
        <p class="text-center mt-3 text-white-50 small">&copy; <?= date('Y') ?> - Departamento De Educacion</p>
    </div>

    <script>
        // Función del botón de destrucción
        document.getElementById('destroyBtn').addEventListener('click', function() {
            if(confirm("¿Seguro que quieres cerrar el programa?")) {
                // Redirige a logout.php que destruye la sesión
                window.location.href = 'logout.php';
            }
        });
    </script>
</body>
</html>

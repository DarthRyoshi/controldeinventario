<?php
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../config.php';

class UsuarioController {
    public static function handle($action) {
        global $conn;
        $usuarioModel = new Usuario($conn);

        switch($action) {

            case 'login':
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $email = $_POST['email'] ?? '';
                    $password = $_POST['password'] ?? '';
                    $user = $usuarioModel->login($email, $password);
                    if ($user) {
                        $_SESSION['user'] = $user;
                        header("Location: index.php?action=dashboard");
                        exit;
                    } else {
                        $error = "Usuario o contraseña incorrectos";
                        include __DIR__ . '/../views/usuarios/login.php';
                    }
                } else {
                    include __DIR__ . '/../views/usuarios/login.php';
                }
                break;

            case 'dashboard':
                if (!isset($_SESSION['user'])) {
                    header("Location: index.php?action=login");
                    exit;
                }
                $usuario = $_SESSION['user'];
                include __DIR__ . '/../views/usuarios/dashboard.php';
                break;

            case 'usuarios':
                if (!isset($_SESSION['user']) || $usuarioModel->getById($_SESSION['user']['id'])['rol'] !== 'admin') {
                    header("Location: index.php?action=dashboard");
                    exit;
                }
                $usuarios = $usuarioModel->getAll();
                include __DIR__ . '/../views/usuarios/listar.php';
                break;

            case 'crearUsuario':
                $nombre = $_POST['nombre'] ?? '';
                $email  = $_POST['email'] ?? '';
                $rol    = $_POST['rol'] ?? 'admin';
                $rut    = $_POST['rut'] ?? '';

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                    if ($usuarioModel->existsRut($rut)) {
                        $error = "El RUT ingresado ya existe.";
                        include __DIR__ . '/../views/usuarios/crear.php';
                        exit;
                    }

                    $res = $usuarioModel->create($nombre, $email, $_POST['password'], $rol, $rut);

                    if ($res) {
                        header("Location: index.php?action=usuarios");
                        exit;
                    } else {
                        $error = "Error al crear usuario";
                        include __DIR__ . '/../views/usuarios/crear.php';
                        exit;
                    }
                } else {
                    include __DIR__ . '/../views/usuarios/crear.php';
                }
                break;

            case 'editarUsuario':
                $id = $_GET['id'] ?? null;
                if (!$id) {
                    header("Location: index.php?action=usuarios");
                    exit;
                }

                $usuarioEditar = $usuarioModel->getById($id);
                $nombre = $_POST['nombre'] ?? $usuarioEditar['nombre'];
                $email  = $_POST['email'] ?? $usuarioEditar['email'];
                $rol    = $_POST['rol'] ?? $usuarioEditar['rol'];
                $rut    = $_POST['rut'] ?? $usuarioEditar['rut'];

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                    if ($usuarioModel->existsRut($rut, $id)) {
                        $error = "El RUT ingresado ya existe.";
                        include __DIR__ . '/../views/usuarios/editar.php';
                        exit;
                    }

                    $res = $usuarioModel->update($id, $nombre, $email, $_POST['password'], $rol, $rut);

                    if ($res) {
                        // Actualizar sesión si es el mismo usuario
                        if ($id == $_SESSION['user']['id']) {
                            $_SESSION['user'] = $usuarioModel->getById($id);
                        }
                        header("Location: index.php?action=dashboard");
                        exit;
                    } else {
                        $error = "Error al actualizar usuario";
                        include __DIR__ . '/../views/usuarios/editar.php';
                        exit;
                    }
                } else {
                    include __DIR__ . '/../views/usuarios/editar.php';
                }
                break;

            case 'eliminarUsuario':
                $id = $_GET['id'] ?? null;
                if ($id) $usuarioModel->delete($id);
                header("Location: index.php?action=usuarios");
                exit;

            case 'logout':
                session_destroy();
                header("Location: index.php?action=login");
                exit;

            default:
                echo "Acción no válida";
                break;
        }
    }
}
?>

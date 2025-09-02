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
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $rut = $_POST['rut'];
                    $nombre = $_POST['nombre'];
                    $email = $_POST['email'];
                    $contrasena = $_POST['password'];
                    $rol = $_POST['rol'];
                    $usuarioModel->create($nombre, $email, $contrasena, $rol, $rut);
                    header("Location: index.php?action=usuarios");
                    exit;
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

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $rut = $_POST['rut'];
        $nombre = $_POST['nombre'];
        $email = $_POST['email'];
        $contrasena = $_POST['password'];
        $rol = $_POST['rol'];

        $usuarioModel->update($id, $nombre, $email, $contrasena, $rol, $rut);

        // 🔹 Si estoy editando mi propio usuario, actualizo la sesión
        if ($id == $_SESSION['user']['id']) {
            $_SESSION['user'] = $usuarioModel->getById($id);
        }

        header("Location: index.php?action=dashboard");
        exit;
    } else {
        $usuarioEditar = $usuarioModel->getById($id);
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

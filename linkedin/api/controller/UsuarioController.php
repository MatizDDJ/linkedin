<?php
// controller/UsuarioController.php
require_once '../modelo/UsuarioModel.php';
session_start();
class UsuarioController {
    private $model;
    public function __construct() {
        $this->model = new UsuarioModel();
    }
    public function handleRequest() {
        $action = $_POST['action'] ?? $_GET['action'] ?? null;
        switch ($action) {
            case 'register':
                $this->register();
                break;
            case 'login':
                $this->login();
                break;
            case 'logout':
                $this->logout();
                break;
            default:
                header("Location: ../../index.php");
                exit();
        }
    }
    private function register() {
        $nombre = $_POST['nombre'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        if ($this->model->registrarUsuario($nombre, $email, $password)) {
            // Obtener los datos del usuario recién creado para iniciar la sesión
            $usuario = $this->model->obtenerUsuarioPorEmail($email);
            if ($usuario) {
                $_SESSION['user_id'] = $usuario['id'];
                $_SESSION['user_nombre'] = $usuario['nombre'];
                // Redirigir al usuario al perfil.php después de un registro exitoso
                header("Location: ../../perfil.php");
                exit();
            } else {
                // Si por alguna razón no se puede obtener el usuario, redirigir al login
                header("Location: ../../login.html?error=1");
                exit();
            }
        } else {
            // Manejar error en el registro y redirigir con un mensaje de error
            header("Location: ../../registro.html?error=1");
            exit();
        }
    }
    private function login() {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $usuario = $this->model->obtenerUsuarioPorEmail($email);
        if ($usuario && password_verify($password, $usuario['password'])) {
            $_SESSION['user_id'] = $usuario['id'];
            $_SESSION['user_nombre'] = $usuario['nombre'];
            header("Location: ../../perfil.php");
            exit();
        } else {
            header("Location: ../../login.html?error=1");
            exit();
        }
    }
    private function logout() {
        session_destroy();
        header("Location: ../../index.php");
        exit();
    }
}
$controller = new UsuarioController();
$controller->handleRequest();
?>
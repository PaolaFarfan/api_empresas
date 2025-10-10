<?php
require_once '../models/Usuario.php';

class AuthController {
    private $usuario;

    public function __construct() {
        $this->usuario = new Usuario();
    }

    public function login() {
        // Si ya está autenticado, redirigir al dashboard
        if (isset($_SESSION['usuario_id'])) {
            header("Location: index.php?action=dashboard");
            exit();
        }

        if ($_POST) {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            // Validación específica para admin/admin
            if ($username === 'admin' && $password === 'admin') {
                // Obtener datos del usuario admin desde la base de datos
                if ($this->usuario->login('admin@empresas.com', 'admin')) {
                    $_SESSION['usuario_id'] = $this->usuario->id;
                    $_SESSION['usuario_nombre'] = $this->usuario->nombre;
                    $_SESSION['usuario_email'] = $this->usuario->email;
                    
                    header("Location: index.php?action=dashboard");
                    exit();
                } else {
                    $error = "Error en la autenticación";
                }
            } else {
                $error = "Usuario o contraseña incorrectos. Use: admin / admin";
            }
            
            if (isset($error)) {
                require_once '../views/auth/login.php';
            }
        } else {
            require_once '../views/auth/login.php';
        }
    }

    public function registro() {
        // Deshabilitar registro - solo admin permitido
        header("Location: index.php?action=login");
        exit();
    }

    public function logout() {
        session_destroy();
        header("Location: index.php?action=login");
        exit();
    }
}
?>
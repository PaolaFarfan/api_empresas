<?php
// Configuración de la aplicación
define('DB_HOST', 'localhost');
define('DB_NAME', 'cwefycom_empresas_db');
define('DB_USER', 'cwefycom_empresas_user');
define('DB_PASS', '123empresas@');
define('BASE_URL', 'https://empresas.cwefy.com/');
define('PUBLIC_URL', BASE_URL . 'public/');

// Configuración de sesión
session_start();

// Función para redireccionar
function redirect($url) {
    header("Location: " . PUBLIC_URL . $url);
    exit();
}

// Función para verificar autenticación
function authCheck() {
    if (!isset($_SESSION['usuario_id'])) {
        redirect('index.php?action=login');
    }
}

// Función para obtener URL absoluta
function url($path = '') {
    return PUBLIC_URL . $path;
}

// Credenciales por defecto
define('DEFAULT_USERNAME', 'admin');
define('DEFAULT_PASSWORD', 'admin');
?>
<?php
// Front Controller
require_once '../config/config.php';

// Cargar automáticamente los controladores
function cargarControlador($clase) {
    $archivo = '../controllers/' . $clase . '.php';
    if (file_exists($archivo)) {
        require_once $archivo;
    }
}

spl_autoload_register('cargarControlador');

// Obtener acción y método de la URL
$action = $_GET['action'] ?? 'login';
$method = $_GET['method'] ?? 'index';

// Redirigir registro al login (deshabilitado)
if ($action === 'registro') {
    header("Location: index.php?action=login");
    exit();
}

// Si no está autenticado, redirigir al login
if (!isset($_SESSION['usuario_id']) && $action !== 'login') {
    header("Location: index.php?action=login");
    exit();
}

// Routing
switch ($action) {
    case 'login':
        $controller = new AuthController();
        $controller->login();
        break;
        
    case 'logout':
        $controller = new AuthController();
        $controller->logout();
        break;
        
    case 'dashboard':
        authCheck();
        require_once '../views/dashboard.php';
        break;
        
    case 'empresas':
        $controller = new EmpresaController();
        switch ($method) {
            case 'crear': $controller->crear(); break;
            case 'editar': $controller->editar(); break;
            case 'eliminar': $controller->eliminar(); break;
            default: $controller->index(); break;
        }
        break;
        
    case 'client_api':
        $controller = new ClientApiController();
        switch ($method) {
            case 'crear': $controller->crear(); break;
            case 'editar': $controller->editar(); break;
            case 'eliminar': $controller->eliminar(); break;
            default: $controller->index(); break;
        }
        break;
        
    case 'token_api':
        $controller = new TokenApiController();
        switch ($method) {
            case 'crear': $controller->crear(); break;
            case 'editar': $controller->editar(); break;
            case 'eliminar': $controller->eliminar(); break;
            case 'generar': $controller->generar(); break;
            default: $controller->index(); break;
        }
        break;
        
    case 'count_request':
        $controller = new CountRequestController();
        switch ($method) {
            case 'crear': $controller->crear(); break;
            case 'editar': $controller->editar(); break;
            case 'eliminar': $controller->eliminar(); break;
            case 'estadisticas': $controller->estadisticas(); break;
            default: $controller->index(); break;
        }
        break;
        
    default:
        header("Location: index.php?action=login");
        exit();
}
?>
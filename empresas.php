<?php
// empresas.php - Endpoint de la API
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Authorization, Content-Type, Accept');

// Manejar preflight requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once 'config/config.php';
require_once 'models/Conexion.php';
require_once 'models/Empresa.php';
require_once 'models/TokenApi.php';

try {
    $conexion = new Conexion();
    $pdo = $conexion->getConnection();
    
    // Obtener token de la URL
    $token = $_GET['token'] ?? '';
    
    if (empty($token)) {
        http_response_code(401);
        echo json_encode([
            'success' => false,
            'message' => 'Token requerido'
        ]);
        exit;
    }
    
    // Verificar token
    $tokenApi = new TokenApi();
    if (!$tokenApi->obtenerPorToken($token)) {
        http_response_code(401);
        echo json_encode([
            'success' => false,
            'message' => 'Token inválido o expirado'
        ]);
        exit;
    }
    
    // Obtener acción
    $accion = $_GET['accion'] ?? 'listar';
    $empresaModel = new Empresa();
    
    switch ($accion) {
        case 'listar':
            $stmt = $empresaModel->obtenerTodas();
            $empresas = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            echo json_encode([
                'success' => true,
                'data' => $empresas,
                'total' => count($empresas)
            ]);
            break;
            
        case 'buscar':
            $campo = $_GET['campo'] ?? 'nombre';
            $valor = $_GET['valor'] ?? '';
            
            if (empty($valor)) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Valor de búsqueda requerido'
                ]);
                break;
            }
            
            // Buscar empresas según el campo
            $query = "SELECT * FROM empresas WHERE $campo LIKE :valor ORDER BY nombre";
            $stmt = $pdo->prepare($query);
            $stmt->execute([':valor' => "%$valor%"]);
            $empresas = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            echo json_encode([
                'success' => true,
                'data' => $empresas,
                'total' => count($empresas)
            ]);
            break;
            
        default:
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'Acción no válida'
            ]);
    }
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error del servidor: ' . $e->getMessage()
    ]);
}
?>
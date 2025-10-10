<?php
require_once '../models/CountRequest.php';
require_once '../models/TokenApi.php';

class CountRequestController {
    private $countRequest;
    private $tokenApi;

    public function __construct() {
        $this->countRequest = new CountRequest();
        $this->tokenApi = new TokenApi();
    }

    public function index() {
        authCheck();
        $solicitudes = $this->countRequest->obtenerTodas();
        $tokens = $this->tokenApi->obtenerTodos();
        require_once '../views/count_request/index.php';
    }

    public function crear() {
        authCheck();
        
        $tokens = $this->tokenApi->obtenerTodos();
        
        if ($_POST) {
            $this->countRequest->id_token = $_POST['id_token'] ?? '';
            $this->countRequest->tipo = $_POST['tipo'] ?? '';

            // Validaciones
            if (empty($this->countRequest->id_token) || empty($this->countRequest->tipo)) {
                $error = "Token y Tipo son requeridos";
            } else {
                if ($this->countRequest->crear()) {
                    header("Location: index.php?action=count_request&success=1");
                    exit();
                } else {
                    $error = "Error al crear la solicitud";
                }
            }
        }
        
        require_once '../views/count_request/crear.php';
    }

    public function editar() {
        authCheck();
        
        $id = $_GET['id'] ?? 0;
        $tokens = $this->tokenApi->obtenerTodos();
        
        if (!$this->countRequest->obtenerPorId($id)) {
            header("Location: index.php?action=count_request&error=1");
            exit();
        }

        if ($_POST) {
            $this->countRequest->id = $id;
            $this->countRequest->id_token = $_POST['id_token'] ?? '';
            $this->countRequest->tipo = $_POST['tipo'] ?? '';

            if (empty($this->countRequest->id_token) || empty($this->countRequest->tipo)) {
                $error = "Token y Tipo son requeridos";
            } else {
                if ($this->countRequest->actualizar()) {
                    header("Location: index.php?action=count_request&success=2");
                    exit();
                } else {
                    $error = "Error al actualizar la solicitud";
                }
            }
        }
        
        $solicitud = $this->countRequest;
        require_once '../views/count_request/editar.php';
    }

    public function eliminar() {
        authCheck();
        
        $id = $_GET['id'] ?? 0;
        
        if ($this->countRequest->eliminar($id)) {
            header("Location: index.php?action=count_request&success=3");
        } else {
            header("Location: index.php?action=count_request&error=2");
        }
        exit();
    }

    public function estadisticas() {
        authCheck();
        
        $fecha_inicio = $_GET['fecha_inicio'] ?? date('Y-m-01');
        $fecha_fin = $_GET['fecha_fin'] ?? date('Y-m-d');
        
        $estadisticas = $this->countRequest->obtenerEstadisticas($fecha_inicio, $fecha_fin);
        require_once '../views/count_request/estadisticas.php';
    }
}
?>
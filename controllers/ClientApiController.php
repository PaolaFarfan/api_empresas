<?php
require_once '../models/ClientApi.php';

class ClientApiController {
    private $clientApi;

    public function __construct() {
        $this->clientApi = new ClientApi();
    }

    public function index() {
        authCheck();
        $clientes = $this->clientApi->obtenerTodos();
        require_once '../views/client_api/index.php';
    }

    public function crear() {
        authCheck();
        
        if ($_POST) {
            $this->clientApi->ruc = $_POST['ruc'] ?? '';
            $this->clientApi->razon_social = $_POST['razon_social'] ?? '';
            $this->clientApi->telefono = $_POST['telefono'] ?? '';
            $this->clientApi->correo = $_POST['correo'] ?? '';
            $this->clientApi->estado = $_POST['estado'] ?? 1;

            // Validaciones
            if (empty($this->clientApi->ruc) || empty($this->clientApi->razon_social)) {
                $error = "RUC y Razón Social son requeridos";
            } elseif ($this->clientApi->rucExiste($this->clientApi->ruc)) {
                $error = "El RUC ya está registrado";
            } else {
                if ($this->clientApi->crear()) {
                    header("Location: index.php?action=client_api&success=1");
                    exit();
                } else {
                    $error = "Error al crear el cliente API";
                }
            }
        }
        
        require_once '../views/client_api/crear.php';
    }

    public function editar() {
        authCheck();
        
        $id = $_GET['id'] ?? 0;
        
        if (!$this->clientApi->obtenerPorId($id)) {
            header("Location: index.php?action=client_api&error=1");
            exit();
        }

        if ($_POST) {
            $this->clientApi->id = $id;
            $this->clientApi->ruc = $_POST['ruc'] ?? '';
            $this->clientApi->razon_social = $_POST['razon_social'] ?? '';
            $this->clientApi->telefono = $_POST['telefono'] ?? '';
            $this->clientApi->correo = $_POST['correo'] ?? '';
            $this->clientApi->estado = $_POST['estado'] ?? 1;

            if (empty($this->clientApi->ruc) || empty($this->clientApi->razon_social)) {
                $error = "RUC y Razón Social son requeridos";
            } elseif ($this->clientApi->rucExiste($this->clientApi->ruc, $id)) {
                $error = "El RUC ya está registrado en otro cliente";
            } else {
                if ($this->clientApi->actualizar()) {
                    header("Location: index.php?action=client_api&success=2");
                    exit();
                } else {
                    $error = "Error al actualizar el cliente API";
                }
            }
        }
        
        $cliente = $this->clientApi;
        require_once '../views/client_api/editar.php';
    }

    public function eliminar() {
        authCheck();
        
        $id = $_GET['id'] ?? 0;
        
        if ($this->clientApi->eliminar($id)) {
            header("Location: index.php?action=client_api&success=3");
        } else {
            header("Location: index.php?action=client_api&error=2");
        }
        exit();
    }
}
?>
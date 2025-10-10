<?php
require_once '../models/TokenApi.php';
require_once '../models/ClientApi.php';

class TokenApiController {
    private $tokenApi;
    private $clientApi;

    public function __construct() {
        $this->tokenApi = new TokenApi();
        $this->clientApi = new ClientApi();
    }

    public function index() {
        authCheck();
        $tokens = $this->tokenApi->obtenerTodos();
        $clientes = $this->clientApi->obtenerActivos();
        require_once '../views/token_api/index.php';
    }

    public function crear() {
        authCheck();
        
        $clientes = $this->clientApi->obtenerActivos();
        
        if ($_POST) {
            $this->tokenApi->id_client_api = $_POST['id_client_api'] ?? '';
            $this->tokenApi->token = $_POST['token'] ?? $this->tokenApi->generarToken();
            $this->tokenApi->estado = $_POST['estado'] ?? 1;

            // Validaciones
            if (empty($this->tokenApi->id_client_api)) {
                $error = "Cliente API es requerido";
            } elseif ($this->tokenApi->tokenExiste($this->tokenApi->token)) {
                $error = "El token ya existe, genere uno nuevo";
            } else {
                if ($this->tokenApi->crear()) {
                    header("Location: index.php?action=token_api&success=1");
                    exit();
                } else {
                    $error = "Error al crear el token";
                }
            }
        }
        
        require_once '../views/token_api/crear.php';
    }

    public function editar() {
        authCheck();
        
        $id = $_GET['id'] ?? 0;
        $clientes = $this->clientApi->obtenerActivos();
        
        if (!$this->tokenApi->obtenerPorId($id)) {
            header("Location: index.php?action=token_api&error=1");
            exit();
        }

        if ($_POST) {
            $this->tokenApi->id = $id;
            $this->tokenApi->id_client_api = $_POST['id_client_api'] ?? '';
            $this->tokenApi->token = $_POST['token'] ?? '';
            $this->tokenApi->estado = $_POST['estado'] ?? 1;

            if (empty($this->tokenApi->id_client_api)) {
                $error = "Cliente API es requerido";
            } elseif ($this->tokenApi->tokenExiste($this->tokenApi->token, $id)) {
                $error = "El token ya existe en otro registro";
            } else {
                if ($this->tokenApi->actualizar()) {
                    header("Location: index.php?action=token_api&success=2");
                    exit();
                } else {
                    $error = "Error al actualizar el token";
                }
            }
        }
        
        $token = $this->tokenApi;
        require_once '../views/token_api/editar.php';
    }

    public function eliminar() {
        authCheck();
        
        $id = $_GET['id'] ?? 0;
        
        if ($this->tokenApi->eliminar($id)) {
            header("Location: index.php?action=token_api&success=3");
        } else {
            header("Location: index.php?action=token_api&error=2");
        }
        exit();
    }

    public function generar() {
        authCheck();
        
        if ($_POST) {
            $id_client_api = $_POST['id_client_api'] ?? '';
            $cantidad = $_POST['cantidad'] ?? 1;
            
            if (empty($id_client_api)) {
                header("Location: index.php?action=token_api&error=3");
                exit();
            }
            
            $tokensGenerados = 0;
            for ($i = 0; $i < $cantidad; $i++) {
                $this->tokenApi->id_client_api = $id_client_api;
                $this->tokenApi->token = $this->tokenApi->generarToken();
                $this->tokenApi->estado = 1;
                
                if ($this->tokenApi->crear()) {
                    $tokensGenerados++;
                }
            }
            
            if ($tokensGenerados > 0) {
                header("Location: index.php?action=token_api&success=4&cantidad=" . $tokensGenerados);
            } else {
                header("Location: index.php?action=token_api&error=4");
            }
            exit();
        }
        
        $clientes = $this->clientApi->obtenerActivos();
        require_once '../views/token_api/generar.php';
    }
}
?>
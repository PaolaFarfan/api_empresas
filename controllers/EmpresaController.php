<?php
require_once '../models/Empresa.php';

class EmpresaController {
    private $empresa;

    public function __construct() {
        $this->empresa = new Empresa();
    }

    public function index() {
        authCheck();
        $empresas = $this->empresa->obtenerTodas();
        require_once '../views/empresas/index.php';
    }

    public function crear() {
        authCheck();
        
        if ($_POST) {
            $this->empresa->nombre = $_POST['nombre'] ?? '';
            $this->empresa->ruc = $_POST['ruc'] ?? '';
            $this->empresa->direccion = $_POST['direccion'] ?? '';
            $this->empresa->telefono = $_POST['telefono'] ?? '';
            $this->empresa->email = $_POST['email'] ?? '';

            // Validaciones
            if (empty($this->empresa->nombre) || empty($this->empresa->ruc)) {
                $error = "Nombre y RUC son requeridos";
            } elseif ($this->empresa->rucExisteParaCrear($this->empresa->ruc)) {
                $error = "El RUC ya está registrado";
            } else {
                if ($this->empresa->crear()) {
                    header("Location: index.php?action=empresas&success=1");
                    exit();
                } else {
                    $error = "Error al crear la empresa";
                }
            }
        }
        
        require_once '../views/empresas/crear.php';
    }

    public function editar() {
        authCheck();
        
        $id = $_GET['id'] ?? 0;
        
        // Obtener los datos de la empresa primero
        if (!$this->empresa->obtenerPorId($id)) {
            header("Location: index.php?action=empresas&error=1");
            exit();
        }

        if ($_POST) {
            $this->empresa->id = $id;
            $this->empresa->nombre = $_POST['nombre'] ?? '';
            $this->empresa->ruc = $_POST['ruc'] ?? '';
            $this->empresa->direccion = $_POST['direccion'] ?? '';
            $this->empresa->telefono = $_POST['telefono'] ?? '';
            $this->empresa->email = $_POST['email'] ?? '';

            if (empty($this->empresa->nombre) || empty($this->empresa->ruc)) {
                $error = "Nombre y RUC son requeridos";
            } elseif ($this->empresa->rucExisteParaEditar($this->empresa->ruc, $id)) {
                $error = "El RUC ya está registrado en otra empresa";
            } else {
                if ($this->empresa->actualizar()) {
                    header("Location: index.php?action=empresas&success=2");
                    exit();
                } else {
                    $error = "Error al actualizar la empresa";
                }
            }
        }
        
        // Pasar la empresa a la vista - IMPORTANTE
        $empresa = $this->empresa;
        require_once '../views/empresas/editar.php';
    }

    public function eliminar() {
        authCheck();
        
        $id = $_GET['id'] ?? 0;
        
        if ($this->empresa->eliminar($id)) {
            header("Location: index.php?action=empresas&success=3");
        } else {
            header("Location: index.php?action=empresas&error=2");
        }
        exit();
    }
}
?>
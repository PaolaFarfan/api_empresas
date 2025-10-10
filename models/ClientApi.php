<?php
require_once 'Conexion.php';

class ClientApi {
    private $conn;
    private $table = 'client_api';

    public $id;
    public $ruc;
    public $razon_social;
    public $telefono;
    public $correo;
    public $fecha_registro;
    public $estado;

    public function __construct() {
        $db = new Conexion();
        $this->conn = $db->getConnection();
    }

    // Obtener todos los clientes API
    public function obtenerTodos() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY fecha_registro DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Obtener un cliente por ID
    public function obtenerPorId($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        
        if ($stmt->rowCount() == 1) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $row['id'];
            $this->ruc = $row['ruc'];
            $this->razon_social = $row['razon_social'];
            $this->telefono = $row['telefono'];
            $this->correo = $row['correo'];
            $this->fecha_registro = $row['fecha_registro'];
            $this->estado = $row['estado'];
            return true;
        }
        return false;
    }

    // Crear nuevo cliente API
    public function crear() {
        $query = "INSERT INTO " . $this->table . " 
                  SET ruc=:ruc, razon_social=:razon_social, telefono=:telefono, 
                      correo=:correo, estado=:estado";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":ruc", $this->ruc);
        $stmt->bindParam(":razon_social", $this->razon_social);
        $stmt->bindParam(":telefono", $this->telefono);
        $stmt->bindParam(":correo", $this->correo);
        $stmt->bindParam(":estado", $this->estado);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Actualizar cliente API
    public function actualizar() {
        $query = "UPDATE " . $this->table . " 
                  SET ruc=:ruc, razon_social=:razon_social, telefono=:telefono, 
                      correo=:correo, estado=:estado 
                  WHERE id=:id";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":ruc", $this->ruc);
        $stmt->bindParam(":razon_social", $this->razon_social);
        $stmt->bindParam(":telefono", $this->telefono);
        $stmt->bindParam(":correo", $this->correo);
        $stmt->bindParam(":estado", $this->estado);
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Eliminar cliente API
    public function eliminar($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Verificar si RUC existe
    public function rucExiste($ruc, $excluirId = null) {
        $query = "SELECT id FROM " . $this->table . " WHERE ruc = :ruc";
        
        if ($excluirId) {
            $query .= " AND id != :excluir_id";
        }
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":ruc", $ruc);
        
        if ($excluirId) {
            $stmt->bindParam(":excluir_id", $excluirId);
        }
        
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    // Obtener clientes activos
    public function obtenerActivos() {
        $query = "SELECT * FROM " . $this->table . " WHERE estado = 1 ORDER BY razon_social";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}
?>
<?php
require_once 'Conexion.php';

class Empresa {
    private $conn;
    private $table = 'empresas';

    public $id;
    public $nombre;
    public $ruc;
    public $direccion;
    public $telefono;
    public $email;

    public function __construct() {
        $db = new Conexion();
        $this->conn = $db->getConnection();
    }

    // Obtener todas las empresas
    public function obtenerTodas() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY fecha_creacion DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Obtener una empresa por ID
    public function obtenerPorId($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        
        if ($stmt->rowCount() == 1) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $row['id'];
            $this->nombre = $row['nombre'];
            $this->ruc = $row['ruc'];
            $this->direccion = $row['direccion'];
            $this->telefono = $row['telefono'];
            $this->email = $row['email'];
            return true;
        }
        return false;
    }

    // Crear nueva empresa
    public function crear() {
        $query = "INSERT INTO " . $this->table . " 
                  SET nombre=:nombre, ruc=:ruc, direccion=:direccion, 
                      telefono=:telefono, email=:email";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":ruc", $this->ruc);
        $stmt->bindParam(":direccion", $this->direccion);
        $stmt->bindParam(":telefono", $this->telefono);
        $stmt->bindParam(":email", $this->email);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Actualizar empresa
    public function actualizar() {
        $query = "UPDATE " . $this->table . " 
                  SET nombre=:nombre, ruc=:ruc, direccion=:direccion, 
                      telefono=:telefono, email=:email 
                  WHERE id=:id";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":ruc", $this->ruc);
        $stmt->bindParam(":direccion", $this->direccion);
        $stmt->bindParam(":telefono", $this->telefono);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Eliminar empresa
    public function eliminar($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Verificar si RUC existe (excluyendo el ID actual para edición)
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

    // Verificar si RUC existe para creación (sin excluir)
    public function rucExisteParaCrear($ruc) {
        return $this->rucExiste($ruc);
    }

    // Verificar si RUC existe para edición (excluyendo el ID actual)
    public function rucExisteParaEditar($ruc, $id) {
        return $this->rucExiste($ruc, $id);
    }

    public function obtenerTotalEmpresas() {
    $query = "SELECT COUNT(*) as total FROM " . $this->table;
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['total'] ?? 0;
}
}
?>
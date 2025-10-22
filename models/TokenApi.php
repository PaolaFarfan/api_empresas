<?php
require_once 'Conexion.php';

class TokenApi {
    private $conn;
    private $table = 'tokens_api';

    public $id;
    public $id_client_api;
    public $token;
    public $fecha_registro;
    public $estado;

    public function __construct() {
        $db = new Conexion();
        $this->conn = $db->getConnection();
    }

    // Obtener todos los tokens
    public function obtenerTodos() {
        $query = "SELECT t.*, c.razon_social, c.ruc 
                  FROM " . $this->table . " t 
                  LEFT JOIN client_api c ON t.id_client_api = c.id 
                  ORDER BY t.fecha_registro DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Obtener un token por ID
    public function obtenerPorId($id) {
        $query = "SELECT t.*, c.razon_social, c.ruc 
                  FROM " . $this->table . " t 
                  LEFT JOIN client_api c ON t.id_client_api = c.id 
                  WHERE t.id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        
        if ($stmt->rowCount() == 1) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $row['id'];
            $this->id_client_api = $row['id_client_api'];
            $this->token = $row['token'];
            $this->fecha_registro = $row['fecha_registro'];
            $this->estado = $row['estado'];
            return true;
        }
        return false;
    }

    // Crear nuevo token
    public function crear() {
        $query = "INSERT INTO " . $this->table . " 
                  SET id_client_api=:id_client_api, token=:token, estado=:estado";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":id_client_api", $this->id_client_api);
        $stmt->bindParam(":token", $this->token);
        $stmt->bindParam(":estado", $this->estado);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Actualizar token
    public function actualizar() {
        $query = "UPDATE " . $this->table . " 
                  SET id_client_api=:id_client_api, token=:token, estado=:estado 
                  WHERE id=:id";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":id_client_api", $this->id_client_api);
        $stmt->bindParam(":token", $this->token);
        $stmt->bindParam(":estado", $this->estado);
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Eliminar token
    public function eliminar($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Verificar si token existe
    public function tokenExiste($token, $excluirId = null) {
        $query = "SELECT id FROM " . $this->table . " WHERE token = :token";
        
        if ($excluirId) {
            $query .= " AND id != :excluir_id";
        }
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":token", $token);
        
        if ($excluirId) {
            $stmt->bindParam(":excluir_id", $excluirId);
        }
        
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    // Generar token único
    public function generarToken() {
        return 'tok_' . bin2hex(random_bytes(16));
    }

    // Obtener tokens por cliente
    public function obtenerPorCliente($id_client_api) {
        $query = "SELECT * FROM " . $this->table . " 
                  WHERE id_client_api = :id_client_api 
                  ORDER BY fecha_registro DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id_client_api", $id_client_api);
        $stmt->execute();
        return $stmt;
    }

    // En TokenApi.php - Agregar este método
public function obtenerPorToken($token) {
    $query = "SELECT t.*, c.razon_social, c.ruc 
              FROM " . $this->table . " t 
              LEFT JOIN client_api c ON t.id_client_api = c.id 
              WHERE t.token = :token AND t.estado = 1 LIMIT 1";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":token", $token);
    $stmt->execute();
    
    if ($stmt->rowCount() == 1) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->id = $row['id'];
        $this->id_client_api = $row['id_client_api'];
        $this->token = $row['token'];
        $this->fecha_registro = $row['fecha_registro'];
        $this->estado = $row['estado'];
        return true;
    }
    return false;
}

public function obtenerTotalTokensActivos() {
    $query = "SELECT COUNT(*) as total FROM " . $this->table . " WHERE estado = 1";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['total'] ?? 0;
}
}
?>
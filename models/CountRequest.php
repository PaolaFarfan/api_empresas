<?php
require_once 'Conexion.php';

class CountRequest {
    private $conn;
    private $table = 'count_request';

    public $id;
    public $id_token;
    public $tipo;
    public $fecha;

    public function __construct() {
        $db = new Conexion();
        $this->conn = $db->getConnection();
    }

    // Obtener todas las solicitudes
    public function obtenerTodas() {
        $query = "SELECT cr.*, t.token, c.razon_social 
                  FROM " . $this->table . " cr 
                  LEFT JOIN tokens_api t ON cr.id_token = t.id 
                  LEFT JOIN client_api c ON t.id_client_api = c.id 
                  ORDER BY cr.fecha DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Obtener una solicitud por ID
    public function obtenerPorId($id) {
        $query = "SELECT cr.*, t.token, c.razon_social 
                  FROM " . $this->table . " cr 
                  LEFT JOIN tokens_api t ON cr.id_token = t.id 
                  LEFT JOIN client_api c ON t.id_client_api = c.id 
                  WHERE cr.id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        
        if ($stmt->rowCount() == 1) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $row['id'];
            $this->id_token = $row['id_token'];
            $this->tipo = $row['tipo'];
            $this->fecha = $row['fecha'];
            return true;
        }
        return false;
    }

    // Crear nueva solicitud
    public function crear() {
        $query = "INSERT INTO " . $this->table . " 
                  SET id_token=:id_token, tipo=:tipo";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":id_token", $this->id_token);
        $stmt->bindParam(":tipo", $this->tipo);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Actualizar solicitud
    public function actualizar() {
        $query = "UPDATE " . $this->table . " 
                  SET id_token=:id_token, tipo=:tipo 
                  WHERE id=:id";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":id_token", $this->id_token);
        $stmt->bindParam(":tipo", $this->tipo);
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Eliminar solicitud
    public function eliminar($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Obtener estadísticas
    public function obtenerEstadisticas($fecha_inicio = null, $fecha_fin = null) {
        $query = "SELECT tipo, COUNT(*) as total, DATE(fecha) as dia 
                  FROM " . $this->table;
        
        $where = [];
        if ($fecha_inicio) {
            $where[] = "fecha >= :fecha_inicio";
        }
        if ($fecha_fin) {
            $where[] = "fecha <= :fecha_fin";
        }
        
        if (!empty($where)) {
            $query .= " WHERE " . implode(" AND ", $where);
        }
        
        $query .= " GROUP BY tipo, DATE(fecha) ORDER BY dia DESC, tipo";
        
        $stmt = $this->conn->prepare($query);
        
        if ($fecha_inicio) {
            $stmt->bindParam(":fecha_inicio", $fecha_inicio);
        }
        if ($fecha_fin) {
            $stmt->bindParam(":fecha_fin", $fecha_fin);
        }
        
        $stmt->execute();
        return $stmt;
    }

    public function obtenerSolicitudesHoy() {
    $query = "SELECT COUNT(*) as total FROM " . $this->table . " WHERE DATE(fecha) = CURDATE()";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['total'] ?? 0;
}
}
?>
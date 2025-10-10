<?php
require_once 'Conexion.php';

class Usuario {
    private $conn;
    private $table = 'usuarios';

    public $id;
    public $nombre;
    public $email;
    public $password;

    public function __construct() {
        $db = new Conexion();
        $this->conn = $db->getConnection();
    }

    // Login de usuario
    public function login($email, $password) {
        // Para el usuario admin, verificar contraseña en texto plano
        if ($email === 'admin@empresas.com') {
            $query = "SELECT id, nombre, email, password FROM " . $this->table . " 
                      WHERE email = :email LIMIT 1";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":email", $email);
            $stmt->execute();

            if ($stmt->rowCount() == 1) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                
                // Si la contraseña es 'admin', permitir acceso
                if ($password === 'admin' || password_verify($password, $row['password'])) {
                    $this->id = $row['id'];
                    $this->nombre = $row['nombre'];
                    $this->email = $row['email'];
                    return true;
                }
            }
        }
        return false;
    }

    // Registrar nuevo usuario (deshabilitado)
    public function registrar($nombre, $email, $password) {
        return false; // Registro deshabilitado
    }

    // Verificar si email existe
    public function emailExiste($email) {
        return false; // Registro deshabilitado
    }
}
?>
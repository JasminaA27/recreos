<?php
class User {
    private $conn;
    private $table_name = "usuarios";

    public $id;
    public $username;
    public $password_hash;
    public $nombre_completo;
    public $email;
    public $rol;
    public $estado;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function login($username, $password) {
        $query = "SELECT id, username, password_hash, nombre_completo, email, rol, estado 
                  FROM " . $this->table_name . " 
                  WHERE username = :username AND estado = 'activo'";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($password, $row['password_hash'])) {
                $this->id = $row['id'];
                $this->username = $row['username'];
                $this->nombre_completo = $row['nombre_completo'];
                $this->email = $row['email'];
                $this->rol = $row['rol'];
                $this->estado = $row['estado'];
                return true;
            }
        }
        return false;
    }
}
?>
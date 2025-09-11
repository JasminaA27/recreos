<?php
// models/User.php

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
    public $fecha_creacion;
    public $fecha_actualizacion;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Registrar nuevo usuario
    public function register() {
        // Verificar si el usuario ya existe
        if ($this->userExists()) {
            return false;
        }

        $query = "INSERT INTO " . $this->table_name . " 
                  SET username=:username, password_hash=:password_hash, 
                  nombre_completo=:nombre_completo, email=:email, 
                  rol=:rol, estado=:estado, fecha_creacion=NOW(), fecha_actualizacion=NOW()";
        
        $stmt = $this->conn->prepare($query);
        
        // Limpiar datos
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->password_hash = password_hash($this->password_hash, PASSWORD_DEFAULT);
        $this->nombre_completo = htmlspecialchars(strip_tags($this->nombre_completo));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->rol = htmlspecialchars(strip_tags($this->rol));
        $this->estado = htmlspecialchars(strip_tags($this->estado));
        
        // Vincular parámetros
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':password_hash', $this->password_hash);
        $stmt->bindParam(':nombre_completo', $this->nombre_completo);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':rol', $this->rol);
        $stmt->bindParam(':estado', $this->estado);
        
        if ($stmt->execute()) {
            $this->id = $this->conn->lastInsertId();
            return true;
        }
        return false;
    }

    // Verificar si el usuario existe
    public function userExists() {
        $query = "SELECT id FROM " . $this->table_name . " 
                  WHERE username = :username OR email = :email 
                  LIMIT 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':email', $this->email);
        $stmt->execute();
        
        return $stmt->rowCount() > 0;
    }

    // Login de usuario
    public function login($username, $password) {
        $query = "SELECT * FROM " . $this->table_name . " 
                  WHERE username = :username AND estado = 'activo' 
                  LIMIT 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (password_verify($password, $user['password_hash'])) {
                // Asignar propiedades
                $this->id = $user['id'];
                $this->username = $user['username'];
                $this->nombre_completo = $user['nombre_completo'];
                $this->email = $user['email'];
                $this->rol = $user['rol'];
                $this->estado = $user['estado'];
                
                // Actualizar última conexión
                $this->updateLastLogin();
                
                return true;
            }
        }
        return false;
    }

    // Actualizar última conexión
    private function updateLastLogin() {
        $query = "UPDATE " . $this->table_name . " 
                  SET fecha_actualizacion = NOW() 
                  WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
    }

    // Obtener todos los usuarios
    public function getAll() {
        $query = "SELECT * FROM " . $this->table_name . " 
                  ORDER BY fecha_creacion DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener usuario por ID
    public function getById() {
        $query = "SELECT * FROM " . $this->table_name . " 
                  WHERE id = :id 
                  LIMIT 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Actualizar usuario
    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                  SET nombre_completo=:nombre_completo, email=:email, 
                  rol=:rol, estado=:estado, fecha_actualizacion=NOW()";
        
        // Si se proporciona una nueva contraseña, actualizarla
        if (!empty($this->password_hash)) {
            $query .= ", password_hash=:password_hash";
        }
        
        $query .= " WHERE id=:id";
        
        $stmt = $this->conn->prepare($query);
        
        // Limpiar datos
        $this->nombre_completo = htmlspecialchars(strip_tags($this->nombre_completo));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->rol = htmlspecialchars(strip_tags($this->rol));
        $this->estado = htmlspecialchars(strip_tags($this->estado));
        
        // Vincular parámetros
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':nombre_completo', $this->nombre_completo);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':rol', $this->rol);
        $stmt->bindParam(':estado', $this->estado);
        
        // Si se proporciona una nueva contraseña, hashearla y vincularla
        if (!empty($this->password_hash)) {
            $password_hash = password_hash($this->password_hash, PASSWORD_DEFAULT);
            $stmt->bindParam(':password_hash', $password_hash);
        }
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Eliminar usuario
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " 
                  WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Contar usuarios por rol
    public function countByRole($role) {
        $query = "SELECT COUNT(*) as total FROM " . $this->table_name . " 
                  WHERE rol = :role AND estado = 'activo'";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':role', $role);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }
}
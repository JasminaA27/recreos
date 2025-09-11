<?php
// models/Recreo.php

class Recreo {
    private $conn;
    private $table_name = "recreos";

    public $id;
    public $nombre;
    public $direccion;
    public $referencia;
    public $telefono;
    public $ubicacion;
    public $especialidad;
    public $precio;
    public $estado;
    public $fecha_creacion;
    public $fecha_actualizacion;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Obtener todos los recreos
    public function getAll() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY fecha_creacion DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener todos los recreos ordenados por ID descendente (para numeración correlativa)
    public function getAllOrdered() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener un recreo por ID
    public function getById() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Crear un nuevo recreo
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET nombre=:nombre, direccion=:direccion, referencia=:referencia, 
                  telefono=:telefono, ubicacion=:ubicacion, especialidad=:especialidad, 
                  precio=:precio, estado=:estado, fecha_creacion=NOW(), fecha_actualizacion=NOW()";
        
        $stmt = $this->conn->prepare($query);
        
        // Limpiar datos
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->direccion = htmlspecialchars(strip_tags($this->direccion));
        $this->referencia = htmlspecialchars(strip_tags($this->referencia));
        $this->telefono = htmlspecialchars(strip_tags($this->telefono));
        $this->ubicacion = htmlspecialchars(strip_tags($this->ubicacion));
        $this->especialidad = htmlspecialchars(strip_tags($this->especialidad));
        $this->precio = htmlspecialchars(strip_tags($this->precio));
        $this->estado = htmlspecialchars(strip_tags($this->estado));
        
        // Vincular parámetros
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':direccion', $this->direccion);
        $stmt->bindParam(':referencia', $this->referencia);
        $stmt->bindParam(':telefono', $this->telefono);
        $stmt->bindParam(':ubicacion', $this->ubicacion);
        $stmt->bindParam(':especialidad', $this->especialidad);
        $stmt->bindParam(':precio', $this->precio);
        $stmt->bindParam(':estado', $this->estado);
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Actualizar un recreo
    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                  SET nombre=:nombre, direccion=:direccion, referencia=:referencia, 
                  telefono=:telefono, ubicacion=:ubicacion, especialidad=:especialidad, 
                  precio=:precio, estado=:estado, fecha_actualizacion=NOW()
                  WHERE id=:id";
        
        $stmt = $this->conn->prepare($query);
        
        // Limpiar datos
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->direccion = htmlspecialchars(strip_tags($this->direccion));
        $this->referencia = htmlspecialchars(strip_tags($this->referencia));
        $this->telefono = htmlspecialchars(strip_tags($this->telefono));
        $this->ubicacion = htmlspecialchars(strip_tags($this->ubicacion));
        $this->especialidad = htmlspecialchars(strip_tags($this->especialidad));
        $this->precio = htmlspecialchars(strip_tags($this->precio));
        $this->estado = htmlspecialchars(strip_tags($this->estado));
        
        // Vincular parámetros
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':direccion', $this->direccion);
        $stmt->bindParam(':referencia', $this->referencia);
        $stmt->bindParam(':telefono', $this->telefono);
        $stmt->bindParam(':ubicacion', $this->ubicacion);
        $stmt->bindParam(':especialidad', $this->especialidad);
        $stmt->bindParam(':precio', $this->precio);
        $stmt->bindParam(':estado', $this->estado);
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Eliminar un recreo
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Métodos para el dashboard
    public function countAll() {
        $query = "SELECT COUNT(*) as total FROM " . $this->table_name . " WHERE estado = 'activo'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }

    public function countByUbicacion($ubicacion) {
        $query = "SELECT COUNT(*) as total FROM " . $this->table_name . " WHERE ubicacion = :ubicacion AND estado = 'activo'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':ubicacion', $ubicacion);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }

    public function getRecent($limit = 5) {
        $query = "SELECT * FROM " . $this->table_name . " 
                  WHERE estado = 'activo' 
                  ORDER BY fecha_creacion DESC 
                  LIMIT :limit";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Contar total de recreos para numeración correlativa
    public function getTotalCount() {
        $query = "SELECT COUNT(*) as total FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }
}
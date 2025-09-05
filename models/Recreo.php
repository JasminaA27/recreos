<?php
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

    public function __construct($db) {
        $this->conn = $db;
    }

    public function countAll() {
        $query = "SELECT COUNT(*) as total FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }

    public function countByUbicacion($ubicacion) {
        $query = "SELECT COUNT(*) as total FROM " . $this->table_name . " WHERE ubicacion = :ubicacion";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':ubicacion', $ubicacion);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }

    public function readAll() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY nombre";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET nombre=:nombre, direccion=:direccion, referencia=:referencia, 
                  telefono=:telefono, ubicacion=:ubicacion, especialidad=:especialidad, 
                  precio=:precio, estado=:estado";

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

    // Otros métodos para actualizar y eliminar recreos
}
?>
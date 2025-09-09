<?php
class Oferta {
    private $conn;
    private $table_name = "ofertas";

    public $id;
    public $recreo_id;
    public $tipo_oferta;
    public $nombre;
    public $descripcion;
    public $precio;
    public $disponible;
    public $fecha_creacion;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function readAll() {
        $query = "SELECT o.*, r.nombre as recreo_nombre 
                  FROM " . $this->table_name . " o 
                  LEFT JOIN recreos r ON o.recreo_id = r.id 
                  ORDER BY o.nombre";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    // Agregar este método a la clase Oferta

public function countActive() {
    $query = "SELECT COUNT(*) as total FROM ofertas WHERE disponible = 1";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row['total'];
}

    // Otros métodos para crear, actualizar y eliminar ofertas
}
?>
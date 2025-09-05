<?php
class Horario {
    private $conn;
    private $table_name = "horarios";

    public $id;
    public $recreo_id;
    public $dia_semana;
    public $hora_apertura;
    public $hora_cierre;
    public $activo;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function readAll() {
        $query = "SELECT h.*, r.nombre as recreo_nombre 
                  FROM " . $this->table_name . " h 
                  LEFT JOIN recreos r ON h.recreo_id = r.id 
                  ORDER BY r.nombre, h.dia_semana";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Otros métodos para crear, actualizar y eliminar horarios
}
?>
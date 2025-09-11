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

    // Listar todos los horarios (con nombre del recreo)
    public function readAll() {
        $query = "SELECT h.*, r.nombre as recreo_nombre 
                  FROM " . $this->table_name . " h 
                  LEFT JOIN recreos r ON h.recreo_id = r.id 
                  ORDER BY r.nombre, h.dia_semana";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // 🔹 Obtener horarios por recreo
    public function getByRecreo($recreo_id) {
        $query = "SELECT * FROM " . $this->table_name . " 
                  WHERE recreo_id = ? 
                  ORDER BY FIELD(dia_semana, 'lunes','martes','miercoles','jueves','viernes','sabado','domingo')";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$recreo_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 🔹 Buscar un horario por id
    public function find($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // 🔹 Crear un horario
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  (recreo_id, dia_semana, hora_apertura, hora_cierre, activo) 
                  VALUES (:recreo_id, :dia_semana, :hora_apertura, :hora_cierre, :activo)";
        $stmt = $this->conn->prepare($query);

        return $stmt->execute([
            ':recreo_id'    => $this->recreo_id,
            ':dia_semana'   => $this->dia_semana,
            ':hora_apertura'=> $this->hora_apertura,
            ':hora_cierre'  => $this->hora_cierre,
            ':activo'       => $this->activo
        ]);
    }

    // 🔹 Actualizar un horario
    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                  SET dia_semana = :dia_semana, 
                      hora_apertura = :hora_apertura, 
                      hora_cierre = :hora_cierre, 
                      activo = :activo 
                  WHERE id = :id AND recreo_id = :recreo_id";
        $stmt = $this->conn->prepare($query);

        return $stmt->execute([
            ':dia_semana'   => $this->dia_semana,
            ':hora_apertura'=> $this->hora_apertura,
            ':hora_cierre'  => $this->hora_cierre,
            ':activo'       => $this->activo,
            ':id'           => $this->id,
            ':recreo_id'    => $this->recreo_id
        ]);
    }

    // 🔹 Eliminar un horario
    public function delete($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }
}
?>

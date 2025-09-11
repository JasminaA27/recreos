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

    // Obtener todas las ofertas (con nombre del recreo)
    public function readAll() {
        $query = "SELECT o.*, r.nombre as recreo_nombre 
                  FROM " . $this->table_name . " o 
                  LEFT JOIN recreos r ON o.recreo_id = r.id 
                  ORDER BY o.nombre";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Contar cuántas ofertas activas hay
    public function countActive() {
        $query = "SELECT COUNT(*) as total FROM " . $this->table_name . " WHERE disponible = 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }

    // 🔹 Obtener ofertas por recreo
    public function getByRecreo($recreo_id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE recreo_id = ? ORDER BY nombre";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$recreo_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 🔹 Buscar una oferta por id
    public function find($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // 🔹 Crear una oferta
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  (recreo_id, tipo_oferta, nombre, descripcion, precio, disponible) 
                  VALUES (:recreo_id, :tipo_oferta, :nombre, :descripcion, :precio, :disponible)";
        $stmt = $this->conn->prepare($query);

        return $stmt->execute([
            ':recreo_id'   => $this->recreo_id,
            ':tipo_oferta' => $this->tipo_oferta,
            ':nombre'      => $this->nombre,
            ':descripcion' => $this->descripcion,
            ':precio'      => $this->precio,
            ':disponible'  => $this->disponible
        ]);
    }

    // 🔹 Actualizar una oferta
    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                  SET tipo_oferta = :tipo_oferta, 
                      nombre = :nombre, 
                      descripcion = :descripcion, 
                      precio = :precio, 
                      disponible = :disponible 
                  WHERE id = :id AND recreo_id = :recreo_id";
        $stmt = $this->conn->prepare($query);

        return $stmt->execute([
            ':tipo_oferta' => $this->tipo_oferta,
            ':nombre'      => $this->nombre,
            ':descripcion' => $this->descripcion,
            ':precio'      => $this->precio,
            ':disponible'  => $this->disponible,
            ':id'          => $this->id,
            ':recreo_id'   => $this->recreo_id
        ]);
    }

    // 🔹 Eliminar una oferta
    public function delete($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }
}
?>

<?php
require_once 'models/Database.php';
require_once 'models/Horario.php';

class HorarioController {
    private $db;
    private $horario;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->horario = new Horario($this->db);
    }

    public function index() {
        $stmt = $this->horario->readAll();
        $horarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        require_once 'includes/header.php';
        require_once 'views/horarios/index.php';
        require_once 'includes/footer.php';
    }

    // Otros métodos para crear, editar y eliminar horarios
}
?>
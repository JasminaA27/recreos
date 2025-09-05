<?php
require_once 'models/Database.php';
require_once 'models/Oferta.php';

class OfertaController {
    private $db;
    private $oferta;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->oferta = new Oferta($this->db);
    }

    public function index() {
        $stmt = $this->oferta->readAll();
        $ofertas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        require_once 'includes/header.php';
        require_once 'views/ofertas/index.php';
        require_once 'includes/footer.php';
    }

    // Otros métodos para crear, editar y eliminar ofertas
}
?>
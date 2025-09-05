<?php
require_once 'models/Database.php';
require_once 'models/Recreo.php';

class DashboardController {
    private $db;
    private $recreo;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->recreo = new Recreo($this->db);
    }

    public function index() {
        $total_recreos = $this->recreo->countAll();
        $recreos_huanta = $this->recreo->countByUbicacion('Huanta');
        $recreos_luricocha = $this->recreo->countByUbicacion('Luricocha');
        
        require_once 'includes/header.php';
        require_once 'views/dashboard/index.php';
        require_once 'includes/footer.php';
    }
}
?>
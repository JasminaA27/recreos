<?php
require_once 'models/Database.php';
require_once 'models/Recreo.php';

class RecreoController {
    private $db;
    private $recreo;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->recreo = new Recreo($this->db);
    }

    public function index() {
        $stmt = $this->recreo->readAll();
        $recreos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        require_once 'includes/header.php';
        require_once 'views/recreos/index.php';
        require_once 'includes/footer.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Asignar valores desde el formulario
            $this->recreo->nombre = $_POST['nombre'];
            $this->recreo->direccion = $_POST['direccion'];
            $this->recreo->referencia = $_POST['referencia'];
            $this->recreo->telefono = $_POST['telefono'];
            $this->recreo->ubicacion = $_POST['ubicacion'];
            $this->recreo->especialidad = $_POST['especialidad'];
            $this->recreo->precio = $_POST['precio'];
            $this->recreo->estado = $_POST['estado'];

            if ($this->recreo->create()) {
                header('Location: index.php?controller=Recreo&action=index');
                exit();
            } else {
                $error = "Error al crear el recreo";
            }
        }
        
        require_once 'includes/header.php';
        require_once 'views/recreos/create.php';
        require_once 'includes/footer.php';
    }

    // Otros métodos para editar y eliminar
}
?>
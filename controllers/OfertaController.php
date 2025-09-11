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

    // Listar todas las ofertas (no lo usarás mucho si van dentro de recreos)
    public function index() {
        $stmt = $this->oferta->readAll();
        $ofertas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        require_once 'includes/header.php';
        require_once 'views/ofertas/index.php';
        require_once 'includes/footer.php';
    }

    // Mostrar formulario para crear una oferta vinculada a un recreo
    public function create() {
        if (!isset($_GET['recreo_id'])) {
            die("Error: recreo_id es obligatorio");
        }

        $recreo_id = $_GET['recreo_id'];

        require_once 'includes/header.php';
        require_once 'views/ofertas/create.php';
        require_once 'includes/footer.php';
    }

    // Guardar la oferta en la BD
    public function store() {
        if (!isset($_POST['recreo_id'])) {
            die("Error: recreo_id es obligatorio");
        }

        $this->oferta->recreo_id   = $_POST['recreo_id'];
        $this->oferta->tipo_oferta = $_POST['tipo_oferta'];
        $this->oferta->nombre      = $_POST['nombre'];
        $this->oferta->descripcion = $_POST['descripcion'];
        $this->oferta->precio      = $_POST['precio'];
        $this->oferta->disponible  = isset($_POST['disponible']) ? 1 : 0;

        if ($this->oferta->create()) {
            // Redirigir al edit del recreo al que pertenece
            header("Location: index.php?controller=Recreo&action=edit&id=" . $_POST['recreo_id']);
            exit;
        } else {
            echo "Error al crear la oferta.";
        }
    }

    // Formulario de edición de una oferta
    public function edit() {
        if (!isset($_GET['id'])) {
            die("Error: ID de oferta requerido");
        }

        $oferta = $this->oferta->find($_GET['id']);

        if (!$oferta) {
            die("Oferta no encontrada");
        }

        require_once 'includes/header.php';
        require_once 'views/ofertas/edit.php';
        require_once 'includes/footer.php';
    }

    // Actualizar la oferta
    public function update() {
        if (!isset($_POST['id']) || !isset($_POST['recreo_id'])) {
            die("Error: datos insuficientes");
        }

        $this->oferta->id          = $_POST['id'];
        $this->oferta->recreo_id   = $_POST['recreo_id'];
        $this->oferta->tipo_oferta = $_POST['tipo_oferta'];
        $this->oferta->nombre      = $_POST['nombre'];
        $this->oferta->descripcion = $_POST['descripcion'];
        $this->oferta->precio      = $_POST['precio'];
        $this->oferta->disponible  = isset($_POST['disponible']) ? 1 : 0;

        if ($this->oferta->update()) {
            header("Location: index.php?controller=Recreo&action=edit&id=" . $_POST['recreo_id']);
            exit;
        } else {
            echo "Error al actualizar la oferta.";
        }
    }

    // Eliminar una oferta
    public function delete() {
        if (!isset($_GET['id']) || !isset($_GET['recreo_id'])) {
            die("Error: datos insuficientes para eliminar");
        }

        if ($this->oferta->delete($_GET['id'])) {
            header("Location: index.php?controller=Recreo&action=edit&id=" . $_GET['recreo_id']);
            exit;
        } else {
            echo "Error al eliminar la oferta.";
        }
    }
}
?>

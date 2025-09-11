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

    // Listar todos los horarios (general, casi no lo usarás si van dentro de recreos)
    public function index() {
        $stmt = $this->horario->readAll();
        $horarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        require_once 'includes/header.php';
        require_once 'views/horarios/index.php';
        require_once 'includes/footer.php';
    }

    // Mostrar formulario para crear un horario vinculado a un recreo
    public function create() {
        if (!isset($_GET['recreo_id'])) {
            die("Error: recreo_id es obligatorio");
        }

        $recreo_id = $_GET['recreo_id'];

        require_once 'includes/header.php';
        require_once 'views/horarios/create.php';
        require_once 'includes/footer.php';
    }

    // Guardar horario
    public function store() {
        if (!isset($_POST['recreo_id'])) {
            die("Error: recreo_id es obligatorio");
        }

        $this->horario->recreo_id    = $_POST['recreo_id'];
        $this->horario->dia_semana   = $_POST['dia_semana'];
        $this->horario->hora_apertura = $_POST['hora_apertura'];
        $this->horario->hora_cierre   = $_POST['hora_cierre'];
        $this->horario->activo       = isset($_POST['activo']) ? 1 : 0;

        if ($this->horario->create()) {
            // Volver al edit del recreo
            header("Location: index.php?controller=Recreo&action=edit&id=" . $_POST['recreo_id']);
            exit;
        } else {
            echo "Error al crear el horario.";
        }
    }

    // Formulario de edición de un horario
    public function edit() {
        if (!isset($_GET['id'])) {
            die("Error: ID de horario requerido");
        }

        $horario = $this->horario->find($_GET['id']);

        if (!$horario) {
            die("Horario no encontrado");
        }

        require_once 'includes/header.php';
        require_once 'views/horarios/edit.php';
        require_once 'includes/footer.php';
    }

    // Actualizar un horario
    public function update() {
        if (!isset($_POST['id']) || !isset($_POST['recreo_id'])) {
            die("Error: datos insuficientes");
        }

        $this->horario->id            = $_POST['id'];
        $this->horario->recreo_id     = $_POST['recreo_id'];
        $this->horario->dia_semana    = $_POST['dia_semana'];
        $this->horario->hora_apertura = $_POST['hora_apertura'];
        $this->horario->hora_cierre   = $_POST['hora_cierre'];
        $this->horario->activo        = isset($_POST['activo']) ? 1 : 0;

        if ($this->horario->update()) {
            header("Location: index.php?controller=Recreo&action=edit&id=" . $_POST['recreo_id']);
            exit;
        } else {
            echo "Error al actualizar el horario.";
        }
    }

    // Eliminar un horario
    public function delete() {
        if (!isset($_GET['id']) || !isset($_GET['recreo_id'])) {
            die("Error: datos insuficientes para eliminar");
        }

        if ($this->horario->delete($_GET['id'])) {
            header("Location: index.php?controller=Recreo&action=edit&id=" . $_GET['recreo_id']);
            exit;
        } else {
            echo "Error al eliminar el horario.";
        }
    }
}
?>

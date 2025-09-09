<?php
// controllers/RecreoController.php

require_once 'models/Recreo.php';

class RecreoController {
    private $recreo;

    public function __construct() {
        $db = (new Database())->getConnection();
        $this->recreo = new Recreo($db);
    }

    // Listar todos los recreos
    public function index() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?controller=Auth&action=login');
            exit;
        }

        $recreos = $this->recreo->getAll();
        include 'views/recreos/index.php';
    }

    // Mostrar formulario de creación
    public function create() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?controller=Auth&action=login');
            exit;
        }

        include 'views/recreos/create.php';
    }

    // Guardar nuevo recreo
    public function store() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?controller=Auth&action=login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->recreo->nombre = $_POST['nombre'];
            $this->recreo->direccion = $_POST['direccion'];
            $this->recreo->referencia = $_POST['referencia'];
            $this->recreo->telefono = $_POST['telefono'];
            $this->recreo->ubicacion = $_POST['ubicacion'];
            $this->recreo->especialidad = $_POST['especialidad'];
            $this->recreo->precio = $_POST['precio'];
            $this->recreo->estado = $_POST['estado'];

            if ($this->recreo->create()) {
                $_SESSION['success'] = "Recreo creado exitosamente.";
                header('Location: index.php?controller=Recreo&action=index');
                exit;
            } else {
                $_SESSION['error'] = "Error al crear el recreo.";
                header('Location: index.php?controller=Recreo&action=create');
                exit;
            }
        }
    }

    // Mostrar formulario de edición
    public function edit() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?controller=Auth&action=login');
            exit;
        }

        if (isset($_GET['id'])) {
            $this->recreo->id = $_GET['id'];
            $recreo = $this->recreo->getById();
            
            if ($recreo) {
                include 'views/recreos/edit.php';
            } else {
                $_SESSION['error'] = "Recreo no encontrado.";
                header('Location: index.php?controller=Recreo&action=index');
                exit;
            }
        } else {
            $_SESSION['error'] = "ID de recreo no especificado.";
            header('Location: index.php?controller=Recreo&action=index');
            exit;
        }
    }

    // Actualizar recreo
    public function update() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?controller=Auth&action=login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->recreo->id = $_POST['id'];
            $this->recreo->nombre = $_POST['nombre'];
            $this->recreo->direccion = $_POST['direccion'];
            $this->recreo->referencia = $_POST['referencia'];
            $this->recreo->telefono = $_POST['telefono'];
            $this->recreo->ubicacion = $_POST['ubicacion'];
            $this->recreo->especialidad = $_POST['especialidad'];
            $this->recreo->precio = $_POST['precio'];
            $this->recreo->estado = $_POST['estado'];

            if ($this->recreo->update()) {
                $_SESSION['success'] = "Recreo actualizado exitosamente.";
                header('Location: index.php?controller=Recreo&action=index');
                exit;
            } else {
                $_SESSION['error'] = "Error al actualizar el recreo.";
                header('Location: index.php?controller=Recreo&action=edit&id=' . $_POST['id']);
                exit;
            }
        }
    }

    // Eliminar recreo
    public function delete() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?controller=Auth&action=login');
            exit;
        }

        if (isset($_GET['id'])) {
            $this->recreo->id = $_GET['id'];
            
            if ($this->recreo->delete()) {
                $_SESSION['success'] = "Recreo eliminado exitosamente.";
            } else {
                $_SESSION['error'] = "Error al eliminar el recreo.";
            }
            
            header('Location: index.php?controller=Recreo&action=index');
            exit;
        } else {
            $_SESSION['error'] = "ID de recreo no especificado.";
            header('Location: index.php?controller=Recreo&action=index');
            exit;
        }
    }
}
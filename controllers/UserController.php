<?php
// controllers/UserController.php


class UserController {
    private $user;

    public function __construct() {
        // Verificar autenticación y permisos
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?controller=Auth&action=login');
            exit;
        }
        
        // Solo administradores pueden gestionar usuarios
        if ($_SESSION['user_role'] !== 'administrador') {
            header('Location: index.php?controller=Dashboard&action=index');
            exit;
        }

        $database = new Database();
        $db = $database->getConnection();
        $this->user = new User($db);
    }

    // Listar todos los usuarios
    public function index() {
        $users = $this->user->getAll();
        include 'views/users/index.php';
    }

    // Mostrar formulario de creación
    public function create() {
        include 'views/users/create.php';
    }

    // Guardar nuevo usuario
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->user->username = $_POST['username'];
            $this->user->password_hash = $_POST['password'];
            $this->user->nombre_completo = $_POST['nombre_completo'];
            $this->user->email = $_POST['email'];
            $this->user->rol = $_POST['rol'];
            $this->user->estado = $_POST['estado'];
            
            // Validar contraseña
            if (strlen($_POST['password']) < 6) {
                $_SESSION['error'] = "La contraseña debe tener al menos 6 caracteres";
                header('Location: index.php?controller=User&action=create');
                exit;
            }
            
            if ($this->user->register()) {
                $_SESSION['success'] = "Usuario creado exitosamente.";
                header('Location: index.php?controller=User&action=index');
                exit;
            } else {
                $_SESSION['error'] = "Error al crear el usuario. El nombre de usuario o email ya existe.";
                header('Location: index.php?controller=User&action=create');
                exit;
            }
        }
    }

    // Mostrar formulario de edición
    public function edit() {
        if (isset($_GET['id'])) {
            $this->user->id = $_GET['id'];
            $user = $this->user->getById();
            
            if ($user) {
                include 'views/users/edit.php';
            } else {
                $_SESSION['error'] = "Usuario no encontrado.";
                header('Location: index.php?controller=User&action=index');
                exit;
            }
        } else {
            $_SESSION['error'] = "ID de usuario no especificado.";
            header('Location: index.php?controller=User&action=index');
            exit;
        }
    }

    // Actualizar usuario
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->user->id = $_POST['id'];
            $this->user->nombre_completo = $_POST['nombre_completo'];
            $this->user->email = $_POST['email'];
            $this->user->rol = $_POST['rol'];
            $this->user->estado = $_POST['estado'];
            
            // Si se proporciona una nueva contraseña, actualizarla
            if (!empty($_POST['password'])) {
                if (strlen($_POST['password']) < 6) {
                    $_SESSION['error'] = "La contraseña debe tener al menos 6 caracteres";
                    header('Location: index.php?controller=User&action=edit&id=' . $_POST['id']);
                    exit;
                }
                $this->user->password_hash = $_POST['password'];
            }
            
            if ($this->user->update()) {
                $_SESSION['success'] = "Usuario actualizado exitosamente.";
                header('Location: index.php?controller=User&action=index');
                exit;
            } else {
                $_SESSION['error'] = "Error al actualizar el usuario.";
                header('Location: index.php?controller=User&action=edit&id=' . $_POST['id']);
                exit;
            }
        }
    }

    // Eliminar usuario
    public function delete() {
        if (isset($_GET['id'])) {
            $this->user->id = $_GET['id'];
            
            // No permitir auto-eliminación
            if ($this->user->id == $_SESSION['user_id']) {
                $_SESSION['error'] = "No puede eliminar su propio usuario.";
                header('Location: index.php?controller=User&action=index');
                exit;
            }
            
            if ($this->user->delete()) {
                $_SESSION['success'] = "Usuario eliminado exitosamente.";
            } else {
                $_SESSION['error'] = "Error al eliminar el usuario.";
            }
            
            header('Location: index.php?controller=User&action=index');
            exit;
        } else {
            $_SESSION['error'] = "ID de usuario no especificado.";
            header('Location: index.php?controller=User&action=index');
            exit;
        }
    }
}
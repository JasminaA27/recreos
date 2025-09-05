<?php
require_once 'models/Database.php';
require_once 'models/User.php';

class AuthController {
    private $db;
    private $user;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->user = new User($this->db);
    }

    public function login() {
        session_start();
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            if ($this->user->login($username, $password)) {
                $_SESSION['user_id'] = $this->user->id;
                $_SESSION['user_name'] = $this->user->nombre_completo;
                $_SESSION['user_role'] = $this->user->rol;
                
                header('Location: index.php?controller=Dashboard&action=index');
                exit();
            } else {
                $error = "Usuario o contraseña incorrectos";
                require_once 'views/auth/login.php';
            }
        } else {
            require_once 'views/auth/login.php';
        }
    }

    public function logout() {
        session_start();
        session_destroy();
        header('Location: index.php?controller=Auth&action=login');
        exit();
    }
}
?>
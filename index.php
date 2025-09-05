<?php
session_start();

// Cargar configuración
require_once 'config/config.php';

// Cargar clases esenciales
require_once 'models/Database.php';

// Autoload para controladores y modelos
spl_autoload_register(function($class) {
    if (file_exists('controllers/' . $class . '.php')) {
        require_once 'controllers/' . $class . '.php';
    } elseif (file_exists('models/' . $class . '.php')) {
        require_once 'models/' . $class . '.php';
    }
});

// Obtener controlador y acción
$controller = isset($_GET['controller']) ? $_GET['controller'] : 'Auth';
$action = isset($_GET['action']) ? $_GET['action'] : 'login';

// Verificar autenticación
if ($controller != 'Auth' && !isset($_SESSION['user_id'])) {
    header('Location: index.php?controller=Auth&action=login');
    exit();
}

// Instanciar controlador
$controllerName = $controller . 'Controller';
if (class_exists($controllerName)) {
    $controllerInstance = new $controllerName();
    
    if (method_exists($controllerInstance, $action)) {
        $controllerInstance->$action();
    } else {
        die('Acción no encontrada: ' . $action);
    }
} else {
    die('Controlador no encontrado: ' . $controllerName);
}
?>
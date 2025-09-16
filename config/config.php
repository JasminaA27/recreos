<?php
// Configuración de la base de datos

use function PHPSTORM_META\map;

define('DB_HOST', 'localhost');
define('DB_NAME', 'recreoss');
define('DB_USER', 'root');
define('DB_PASS', '');

// Configuración de la aplicación
define('BASE_URL', 'http://localhost:8888/recreos');
define('SITE_NAME', 'Sistema de Gestión de Recreos');

// Configuración de sesión
ini_set('session.cookie_lifetime', 0);
session_set_cookie_params(0);

?>
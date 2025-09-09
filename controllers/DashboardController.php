<?php
// controllers/DashboardController.php

require_once 'models/Database.php';
require_once 'models/Recreo.php';
require_once 'models/Oferta.php';

class DashboardController {
    private $db;
    private $recreo;
    private $oferta;

    public function __construct() {
        $this->db = (new Database())->getConnection();
        $this->recreo = new Recreo($this->db);
        $this->oferta = new Oferta($this->db);
    }

    public function index() {
        // Verificar si el usuario está logueado
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?controller=Auth&action=login');
            exit;
        }

        // Obtener estadísticas
        $total_recreos = $this->recreo->countAll();
        $recreos_huanta = $this->recreo->countByUbicacion('Huanta');
        $recreos_luricocha = $this->recreo->countByUbicacion('Luricocha');
        $ofertas_activas = $this->oferta->countActive();

        // Cargar la vista del dashboard
        include 'views/dashboard/index.php';
    }
}
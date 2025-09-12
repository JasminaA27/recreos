<?php
// views/dashboard/index.php

// Incluir cabecera
include 'includes/header.php';
?>

<link rel="stylesheet" href="assets/css/dashboard.css">

<div class="dashboard">
    <!-- Sidebar -->

    <div class="sidebar">
        <div class="sidebar-header">
            <h3><i class="fas fa-utensils"></i> RECREOS HUANTA LURICOCHA</h3>
        </div>
        <ul class="sidebar-menu">
            <li class="active">
                <a href="index.php?controller=Dashboard&action=index">
                    <i class="fas fa-home"></i> 
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="index.php?controller=Recreo&action=index">
                    <i class="fas fa-store"></i> 
                    <span>Recreos</span>
                </a>
            </li>
            <li>
                <a href="index.php?controller=Oferta&action=index">
                    <i class="fas fa-concierge-bell"></i> 
                    <span>Ofertas</span>
                </a>
            </li>
            <li>
                <a href="index.php?controller=Horario&action=index">
                    <i class="fas fa-clock"></i> 
                    <span>Horarios</span>
                </a>
            </li>
            <li><a href="index.php?controller=User&action=index"><i class="fas fa-users"></i> Usuarios</a></li>
     
            <li class="logout">
                <a href="index.php?controller=Auth&action=logout">
                    <i class="fas fa-sign-out-alt"></i> 
                    <span>Cerrar Sesión</span>
                </a>
            </li>
        </ul>
    </div>
    
    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <div class="content-header">
            <div class="header-left">
                <h1></h1>
                <p>Bienvenido de vuelta, aquí tienes un resumen de tus recreos</p>
            </div>
            <div class="header-actions">
                <div class="search-container">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Buscar recreos..." id="searchInput">
                </div>
                <a href="index.php?controller=Recreo&action=create" class="btn btn-primary">
                    <i class="fas fa-plus"></i>
                    <span>Agregar Recreo</span>
                </a>
            </div>
        </div>
        
        <!-- Stats Grid -->
        <div class="stats-grid">
            <div class="stat-card" data-aos="fade-up" data-aos-delay="100">
                <div class="stat-icon blue">
                    <i class="fas fa-store"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-number"><?php echo $total_recreos; ?></div>
                    <div class="stat-label">Recreos Totales</div>
                    <div class="stat-trend">
                        <i class="fas fa-arrow-up"></i>
                        <span>+12% este mes</span>
                    </div>
                </div>
            </div>
            
            <div class="stat-card" data-aos="fade-up" data-aos-delay="200">
                <div class="stat-icon green">
                    <i class="fas fa-utensils"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-number"><?php echo $ofertas_activas; ?></div>
                    <div class="stat-label">Ofertas Activas</div>
                    <div class="stat-trend">
                        <i class="fas fa-arrow-up"></i>
                        <span>+8% esta semana</span>
                    </div>
                </div>
            </div>
            
            <div class="stat-card" data-aos="fade-up" data-aos-delay="300">
                <div class="stat-icon orange">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-number"><?php echo $recreos_huanta; ?></div>
                    <div class="stat-label">En Huanta</div>
                    <div class="stat-trend">
                        <i class="fas fa-minus"></i>
                        <span>Sin cambios</span>
                    </div>
                </div>
            </div>
            
            <div class="stat-card" data-aos="fade-up" data-aos-delay="400">
                <div class="stat-icon purple">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-number"><?php echo $recreos_luricocha; ?></div>
                    <div class="stat-label">En Luricocha</div>
                    <div class="stat-trend">
                        <i class="fas fa-arrow-up"></i>
                        <span>+5% este mes</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Content Grid -->
        <div class="content-grid">
            <!-- Recent Activities -->
            <div class="card recent-activities" data-aos="fade-up" data-aos-delay="500">
                <div class="card-header">
                    <h3><i class="fas fa-clock"></i> Recreos Recientes</h3>
                    <a href="index.php?controller=Recreo&action=index" class="btn-link">
                        Ver todos <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                <div class="card-body">
                    <?php
                    $recreos_recientes = $this->recreo->getRecent(5);
                    if ($recreos_recientes) {
                        foreach ($recreos_recientes as $recreo) {
                            echo '<div class="activity-item">';
                            echo '<div class="activity-avatar">';
                            echo '<i class="fas fa-store"></i>';
                            echo '</div>';
                            echo '<div class="activity-content">';
                            echo '<h4>' . htmlspecialchars($recreo['nombre']) . '</h4>';
                            echo '<p>' . htmlspecialchars($recreo['direccion']) . ' - ' . htmlspecialchars($recreo['ubicacion']) . '</p>';
                              echo '</div>';
                            echo '<div class="activity-actions">';
                            echo '<span class="activity-time">' . date('d/m/Y H:i', strtotime($recreo['fecha_creacion'])) . '</span>';
                            echo '</div>';
                            echo '<div class="activity-actions">';
                       
                            echo '</div>';
                            echo '</div>';
                        }
                    } else {
                        echo '<div class="empty-state">';
                        echo '<i class="fas fa-store-slash"></i>';
                        echo '<h4>No hay recreos registrados</h4>';
                        echo '<p>Comienza agregando tu primer recreo</p>';
                        echo '<a href="index.php?controller=Recreo&action=create" class="btn btn-primary">Agregar Recreo</a>';
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>
            
            <!-- Quick Actions -->
         
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="assets/js/script.js"></script>

<?php
// Incluir pie de página
include 'includes/footer.php';
?>
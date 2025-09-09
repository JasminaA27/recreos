<?php
// views/dashboard/index.php

// Incluir cabecera
include 'includes/header.php';
?>

<div class="dashboard">
    <!-- Sidebar -->
    <div class="sidebar">
        <ul class="sidebar-menu">
            <li><a href="index.php?controller=Dashboard&action=index" class="active"><i class="fas fa-home"></i> Dashboard</a></li>
            <li><a href="index.php?controller=Recreo&action=index"><i class="fas fa-store"></i> Recreos</a></li>
            <li><a href="index.php?controller=Oferta&action=index"><i class="fas fa-concierge-bell"></i> Ofertas</a></li>
            <li><a href="index.php?controller=Horario&action=index"><i class="fas fa-clock"></i> Horarios</a></li>
            <li><a href="#"><i class="fas fa-cog"></i> Configuración</a></li>
            <li><a href="index.php?controller=Auth&action=logout"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a></li>
        </ul>
    </div>
    
    <!-- Main Content -->
    <div class="main-content">
        <div class="content-header">
            <h2>Dashboard</h2>
            <div class="header-actions">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Buscar recreos...">
                </div>
                <a href="index.php?controller=Recreo&action=create" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Agregar Recreo
                </a>
            </div>
        </div>
        
        <!-- Stats -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon blue">
                    <i class="fas fa-store"></i>
                </div>
                <div class="stat-info">
                    <h3><?php echo $total_recreos; ?></h3>
                    <p>Recreos Totales</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon green">
                    <i class="fas fa-utensils"></i>
                </div>
                <div class="stat-info">
                    <h3><?php echo $ofertas_activas; ?></h3>
                    <p>Ofertas Activas</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon orange">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <div class="stat-info">
                    <h3><?php echo $recreos_huanta; ?></h3>
                    <p>En Huanta</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon red">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <div class="stat-info">
                    <h3><?php echo $recreos_luricocha; ?></h3>
                    <p>En Luricocha</p>
                </div>
            </div>
        </div>
        
        <!-- Resto del contenido del dashboard -->
        <div class="recent-activities">
            <div class="card">
                <div class="card-header">
                    <h3>Recreos Recientes</h3>
                    <a href="index.php?controller=Recreo&action=index" class="btn-link">Ver todos</a>
                </div>
                <div class="card-body">
                    <?php
                    $recreos_recientes = $this->recreo->getRecent(5);
                    if ($recreos_recientes) {
                        foreach ($recreos_recientes as $recreo) {
                            echo '<div class="activity-item">';
                            echo '<div class="activity-info">';
                            echo '<h4>' . $recreo['nombre'] . '</h4>';
                            echo '<p>' . $recreo['direccion'] . ' - ' . $recreo['ubicacion'] . '</p>';
                            echo '</div>';
                            echo '<div class="activity-time">' . date('d/m/Y', strtotime($recreo['fecha_creacion'])) . '</div>';
                            echo '</div>';
                        }
                    } else {
                        echo '<p>No hay recreos registrados.</p>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// Incluir pie de página
include 'includes/footer.php';
?>
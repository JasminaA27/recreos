<?php
// views/ofertas/index.php


// Verificar si las variables están definidas
$ofertas = $ofertas ?? [];
?>

<div class="dashboard">
    <!-- Sidebar -->
    <div class="sidebar">
        <ul class="sidebar-menu">
            <li><a href="index.php?controller=Dashboard&action=index"><i class="fas fa-home"></i> Dashboard</a></li>
            <li><a href="index.php?controller=Recreo&action=index"><i class="fas fa-store"></i> Recreos</a></li>
            <li><a href="index.php?controller=Oferta&action=index" class="active"><i class="fas fa-concierge-bell"></i> Ofertas</a></li>
            <li><a href="index.php?controller=Horario&action=index"><i class="fas fa-clock"></i> Horarios</a></li>
            <li><a href="index.php?controller=User&action=index"><i class="fas fa-users"></i> Usuarios</a></li>
            <li><a href="index.php?controller=Auth&action=logout"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a></li>
            
        </ul>
    </div>
    
    <!-- Main Content -->
    <div class="main-content">
        <div class="content-header">
            <h2>Gestión de Ofertas</h2>
            <div class="header-actions">
                <form method="GET" action="index.php" class="search-form">
                    <input type="hidden" name="controller" value="Oferta">
                    <input type="hidden" name="action" value="index">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" name="search" placeholder="Buscar ofertas..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                    </div>
                    <button type="submit" class="btn-search">Buscar</button>
                </form>
                <a href="index.php?controller=Oferta&action=create" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Agregar Oferta
                </a>
            </div>
        </div>

        <!-- Estadísticas de Ofertas -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon blue">
                    <i class="fas fa-utensils"></i>
                </div>
                <div class="stat-info">
                    <h3><?php echo count($ofertas); ?></h3>
                    <p>Total Ofertas</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon green">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-info">
                    <h3><?php echo array_reduce($ofertas, function($carry, $item) { return $carry + ($item['disponible'] ? 1 : 0); }, 0); ?></h3>
                    <p>Ofertas Activas</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon red">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div class="stat-info">
                    <h3><?php echo array_reduce($ofertas, function($carry, $item) { return $carry + (!$item['disponible'] ? 1 : 0); }, 0); ?></h3>
                    <p>Ofertas Inactivas</p>
                </div>
            </div>
        </div>

        <!-- Tabla de Ofertas -->
        <div class="card">
            <div class="card-header">
                <h3>Lista de Ofertas</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Recreo</th>
                                <th>Oferta</th>
                                <th>Tipo</th>
                                <th>Precio (S/)</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($ofertas) > 0): ?>
                                <?php foreach ($ofertas as $oferta): ?>
                                    <tr>
                                        <td>
                                            <div class="recreo-info">
                                                <strong><?php echo $oferta['recreo_nombre']; ?></strong>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="oferta-info">
                                                <strong><?php echo $oferta['nombre']; ?></strong>
                                                <?php if ($oferta['descripcion']): ?>
                                                    <div class="descripcion"><?php echo $oferta['descripcion']; ?></div>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-<?php echo strtolower($oferta['tipo_oferta']); ?>">
                                                <?php echo ucfirst($oferta['tipo_oferta']); ?>
                                            </span>
                                        </td>
                                        <td>S/ <?php echo number_format($oferta['precio'], 2); ?></td>
                                        <td>
                                            <span class="status status-<?php echo $oferta['disponible'] ? 'activo' : 'inactivo'; ?>">
                                                <?php echo $oferta['disponible'] ? 'Activa' : 'Inactiva'; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                <a href="index.php?controller=Oferta&action=edit&id=<?php echo $oferta['id']; ?>" class="btn-action btn-edit" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="index.php?controller=Oferta&action=delete&id=<?php echo $oferta['id']; ?>" class="btn-action btn-delete" title="Eliminar" onclick="return confirm('¿Estás seguro de eliminar esta oferta?');">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center no-data">
                                        No hay ofertas registradas
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include 'includes/footer.php';
?>
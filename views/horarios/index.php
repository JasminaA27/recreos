<?php
// views/horarios/index.php


// Verificar si las variables están definidas
$horarios = $horarios ?? [];
?>

<div class="dashboard">
    <!-- Sidebar -->
    <div class="sidebar">
        <ul class="sidebar-menu">
            <li><a href="index.php?controller=Dashboard&action=index"><i class="fas fa-home"></i> Dashboard</a></li>
            <li><a href="index.php?controller=Recreo&action=index"><i class="fas fa-store"></i> Recreos</a></li>
            <li><a href="index.php?controller=Oferta&action=index"><i class="fas fa-concierge-bell"></i> Ofertas</a></li>
            <li><a href="index.php?controller=Horario&action=index" class="active"><i class="fas fa-clock"></i> Horarios</a></li>
            <li><a href="index.php?controller=User&action=index"><i class="fas fa-users"></i> Usuarios</a></li>
            <li><a href="index.php?controller=Auth&action=logout"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a></li>
            
        </ul>
    </div>
    
    <!-- Main Content -->
    <div class="main-content">
        <div class="content-header">
            <h2>Gestión de Horarios</h2>
            <div class="header-actions">
                <form method="GET" action="index.php" class="search-form">
                    <input type="hidden" name="controller" value="Horario">
                    <input type="hidden" name="action" value="index">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" name="search" placeholder="Buscar horarios..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                    </div>
                    <button type="submit" class="btn-search">Buscar</button>
                </form>
                <a href="index.php?controller=Horario&action=create" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Agregar Horario
                </a>
            </div>
        </div>

        <!-- Estadísticas de Horarios -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon blue">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-info">
                    <h3><?php echo count($horarios); ?></h3>
                    <p>Total Horarios</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon green">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-info">
                    <h3><?php echo array_reduce($horarios, function($carry, $item) { return $carry + ($item['activo'] ? 1 : 0); }, 0); ?></h3>
                    <p>Horarios Activos</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon red">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div class="stat-info">
                    <h3><?php echo array_reduce($horarios, function($carry, $item) { return $carry + (!$item['activo'] ? 1 : 0); }, 0); ?></h3>
                    <p>Horarios Inactivos</p>
                </div>
            </div>
        </div>

        <!-- Tabla de Horarios -->
        <div class="card">
            <div class="card-header">
                <h3>Lista de Horarios</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Recreo</th>
                                <th>Día</th>
                                <th>Horario</th>
                                <th>Duración</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($horarios) > 0): ?>
                                <?php foreach ($horarios as $horario): ?>
                                    <tr>
                                        <td>
                                            <div class="recreo-info">
                                                <strong><?php echo $horario['recreo_nombre']; ?></strong>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="dia-semana">
                                                <?php echo ucfirst($horario['dia_semana']); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="horario-info">
                                                <span class="hora"><?php echo date('H:i', strtotime($horario['hora_apertura'])); ?></span>
                                                <span class="separador">-</span>
                                                <span class="hora"><?php echo date('H:i', strtotime($horario['hora_cierre'])); ?></span>
                                            </div>
                                        </td>
                                        <td>
                                            <?php
                                            $apertura = new DateTime($horario['hora_apertura']);
                                            $cierre = new DateTime($horario['hora_cierre']);
                                            $diferencia = $apertura->diff($cierre);
                                            echo $diferencia->format('%h h %i min');
                                            ?>
                                        </td>
                                        <td>
                                            <span class="status status-<?php echo $horario['activo'] ? 'activo' : 'inactivo'; ?>">
                                                <?php echo $horario['activo'] ? 'Activo' : 'Inactivo'; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                <a href="index.php?controller=Horario&action=edit&id=<?php echo $horario['id']; ?>" class="btn-action btn-edit" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="index.php?controller=Horario&action=delete&id=<?php echo $horario['id']; ?>" class="btn-action btn-delete" title="Eliminar" onclick="return confirm('¿Estás seguro de eliminar este horario?');">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center no-data">
                                        No hay horarios registrados
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
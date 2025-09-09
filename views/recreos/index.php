<?php
// views/recreos/index.php

include 'includes/header.php';
?>

<div class="dashboard">
    <!-- Sidebar -->
    <div class="sidebar">
        <ul class="sidebar-menu">
            <li><a href="index.php?controller=Dashboard&action=index"><i class="fas fa-home"></i> Dashboard</a></li>
            <li><a href="index.php?controller=Recreo&action=index" class="active"><i class="fas fa-store"></i> Recreos</a></li>
            <li><a href="index.php?controller=Oferta&action=index"><i class="fas fa-concierge-bell"></i> Ofertas</a></li>
            <li><a href="index.php?controller=Horario&action=index"><i class="fas fa-clock"></i> Horarios</a></li>
            <li><a href="#"><i class="fas fa-cog"></i> Configuración</a></li>
            <li><a href="index.php?controller=Auth&action=logout"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a></li>
        </ul>
    </div>
    
    <!-- Main Content -->
    <div class="main-content">
        <div class="content-header">
            <h2>Gestión de Recreos</h2>
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

        <!-- Mensajes de alerta -->
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-error">
                <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <!-- Tabla de recreos -->
        <div class="card">
            <div class="card-header">
                <h3>Lista de Recreos</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Dirección</th>
                                <th>Ubicación</th>
                                <th>Teléfono</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($recreos) > 0): ?>
                                <?php foreach ($recreos as $recreo): ?>
                                    <tr>
                                        <td><?php echo $recreo['id']; ?></td>
                                        <td><?php echo $recreo['nombre']; ?></td>
                                        <td><?php echo $recreo['direccion']; ?></td>
                                        <td>
                                            <span class="badge badge-<?php echo $recreo['ubicacion'] == 'Huanta' ? 'blue' : 'green'; ?>">
                                                <?php echo $recreo['ubicacion']; ?>
                                            </span>
                                        </td>
                                        <td><?php echo $recreo['telefono']; ?></td>
                                        <td>
                                            <span class="badge badge-<?php echo $recreo['estado'] == 'activo' ? 'success' : 'danger'; ?>">
                                                <?php echo $recreo['estado']; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                <a href="index.php?controller=Recreo&action=edit&id=<?php echo $recreo['id']; ?>" class="btn btn-sm btn-info">
                                                    <i class="fas fa-edit"></i> Editar
                                                </a>
                                                <a href="index.php?controller=Recreo&action=delete&id=<?php echo $recreo['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar este recreo?');">
                                                    <i class="fas fa-trash"></i> Eliminar
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center">No hay recreos registrados.</td>
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
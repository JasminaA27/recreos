<?php
// views/users/index.php

include '../includes/header.php';
?>

<div class="dashboard">
    <!-- Sidebar -->
    <div class="sidebar">
        <ul class="sidebar-menu">
            <li><a href="index.php?controller=Dashboard&action=index"><i class="fas fa-home"></i> Dashboard</a></li>
            <li><a href="index.php?controller=Recreo&action=index"><i class="fas fa-store"></i> Recreos</a></li>
            <li><a href="index.php?controller=Oferta&action=index"><i class="fas fa-concierge-bell"></i> Ofertas</a></li>
            <li><a href="index.php?controller=Horario&action=index"><i class="fas fa-clock"></i> Horarios</a></li>
            <li><a href="index.php?controller=User&action=index" class="active"><i class="fas fa-users"></i> Usuarios</a></li>
            <li><a href="index.php?controller=Auth&action=logout"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a></li>
           
        </ul>
    </div>
    
    <!-- Main Content -->
    <div class="main-content">
        <div class="content-header">
            <h2>Gestión de Usuarios</h2>
            <div class="header-actions">
                <a href="index.php?controller=User&action=create" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Nuevo Usuario
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

        <!-- Tabla de usuarios -->
        <div class="card">
            <div class="card-header">
                <h3>Lista de Usuarios</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Usuario</th>
                                <th>Nombre Completo</th>
                                <th>Email</th>
                                <th>Rol</th>
                                <th>Estado</th>
                                <th>Fecha Registro</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($users) > 0): ?>
                                <?php foreach ($users as $user): ?>
                                    <tr>
                                        <td><?php echo $user['id']; ?></td>
                                        <td><?php echo $user['username']; ?></td>
                                        <td><?php echo $user['nombre_completo']; ?></td>
                                        <td><?php echo $user['email']; ?></td>
                                        <td>
                                            <span class="badge badge-<?php echo strtolower($user['rol']); ?>">
                                                <?php echo ucfirst($user['rol']); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="status status-<?php echo $user['estado']; ?>">
                                                <?php echo ucfirst($user['estado']); ?>
                                            </span>
                                        </td>
                                        <td><?php echo date('d/m/Y', strtotime($user['fecha_creacion'])); ?></td>
                                        <td>
                                            <div class="action-buttons">
                                                <a href="index.php?controller=User&action=edit&id=<?php echo $user['id']; ?>" class="btn-action btn-edit" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <?php if ($user['id'] != $_SESSION['user_id']): ?>
                                                    <a href="index.php?controller=User&action=delete&id=<?php echo $user['id']; ?>" class="btn-action btn-delete" title="Eliminar" onclick="return confirm('¿Estás seguro de eliminar este usuario?');">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="text-center no-data">
                                        No hay usuarios registrados
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

<?php include '../includes/footer.php'; ?>
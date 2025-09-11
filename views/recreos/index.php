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
          <li><a href="index.php?controller=User&action=index"><i class="fas fa-users"></i> Usuarios</a></li>
            <li><a href="index.php?controller=Auth&action=logout"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a></li>
            
        </ul>
    </div>
    
    <!-- Main Content -->
    <div class="main-content">
        <div class="content-header">
            <h2>Lista de Recreos</h2>
            <div class="header-actions">
                <a href="index.php?controller=Recreo&action=create" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Nuevo Recreo
                </a>
            </div>
        </div>

        <!-- Búsqueda simple -->
        <div class="search-section">
            <input type="text" id="searchInput" placeholder="Buscar recreos..." class="search-input">
            <select id="statusFilter" class="status-filter">
                <option value="">Todos</option>
                <option value="activo">Activo</option>
                <option value="inactivo">Inactivo</option>
            </select>
        </div>

        <!-- Tabla de recreos -->
        <div class="card">
            <div class="card-body">
                <?php if (empty($recreos)): ?>
                    <div class="empty-message">
                        <p>No hay recreos registrados.</p>
                        <a href="index.php?controller=Recreo&action=create" class="btn btn-primary">Agregar Recreo</a>
                    </div>
                <?php else: ?>
                    <table class="simple-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Ubicación</th>
                                <th>Dirección</th>
                                <th>Teléfono</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="recreosTable">
                            <?php 
                            $totalRecreos = count($recreos);
                            foreach ($recreos as $index => $recreo): 
                            ?>
                            <tr data-status="<?php echo $recreo['estado']; ?>">
                                <td><?php echo $totalRecreos - $index; ?></td>
                                <td class="recreo-name"><strong><?php echo htmlspecialchars($recreo['nombre']); ?></strong></td>
                                <td><?php echo htmlspecialchars($recreo['ubicacion']); ?></td>
                                <td><?php echo htmlspecialchars($recreo['direccion']); ?></td>
                                <td><?php echo htmlspecialchars($recreo['telefono'] ?? '-'); ?></td>
                                <td>
                                    <span class="status <?php echo $recreo['estado']; ?>">
                                        <?php echo ucfirst($recreo['estado']); ?>
                                    </span>
                                </td>
                                <td class="actions">
                                    <a href="index.php?controller=Recreo&action=edit&id=<?php echo $recreo['id']; ?>" 
                                       class="btn-small btn-edit">Editar</a>
                                    <button onclick="confirmDelete(<?php echo $recreo['id']; ?>)" 
                                            class="btn-small btn-delete">Eliminar</button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
// Búsqueda simple
document.getElementById('searchInput').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const rows = document.querySelectorAll('#recreosTable tr');
    
    rows.forEach(row => {
        const name = row.querySelector('.recreo-name').textContent.toLowerCase();
        row.style.display = name.includes(searchTerm) ? '' : 'none';
    });
});

// Filtro de estado
document.getElementById('statusFilter').addEventListener('change', function() {
    const status = this.value;
    const rows = document.querySelectorAll('#recreosTable tr');
    
    rows.forEach(row => {
        if (!status || row.dataset.status === status) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});

// Confirmación simple
function confirmDelete(id) {
    if (confirm('¿Eliminar este recreo?')) {
        window.location.href = `index.php?controller=Recreo&action=delete&id=${id}`;
    }
}
</script>

<?php
include 'includes/footer.php';
?>
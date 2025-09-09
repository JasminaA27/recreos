<?php
// views/recreos/edit.php

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
            <h2>Editar Recreo</h2>
            <div class="header-actions">
                <a href="index.php?controller=Recreo&action=index" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>
        </div>

        <!-- Formulario de edición -->
        <div class="card">
            <div class="card-header">
                <h3>Información del Recreo</h3>
            </div>
            <div class="card-body">
                <form action="index.php?controller=Recreo&action=update" method="POST">
                    <input type="hidden" name="id" value="<?php echo $recreo['id']; ?>">
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="nombre">Nombre *</label>
                            <input type="text" id="nombre" name="nombre" value="<?php echo $recreo['nombre']; ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="ubicacion">Ubicación *</label>
                            <select id="ubicacion" name="ubicacion" required>
                                <option value="Huanta" <?php echo $recreo['ubicacion'] == 'Huanta' ? 'selected' : ''; ?>>Huanta</option>
                                <option value="Luricocha" <?php echo $recreo['ubicacion'] == 'Luricocha' ? 'selected' : ''; ?>>Luricocha</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="direccion">Dirección *</label>
                            <input type="text" id="direccion" name="direccion" value="<?php echo $recreo['direccion']; ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="referencia">Referencia</label>
                            <textarea id="referencia" name="referencia" rows="2"><?php echo $recreo['referencia']; ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="telefono">Teléfono</label>
                            <input type="text" id="telefono" name="telefono" value="<?php echo $recreo['telefono']; ?>">
                        </div>

                        <div class="form-group">
                            <label for="especialidad">Especialidad</label>
                            <input type="text" id="especialidad" name="especialidad" value="<?php echo $recreo['especialidad']; ?>">
                        </div>

                        <div class="form-group">
                            <label for="precio">Rango de Precio</label>
                            <input type="text" id="precio" name="precio" value="<?php echo $recreo['precio']; ?>" placeholder="Ej: S/ 25-35">
                        </div>

                        <div class="form-group">
                            <label for="estado">Estado *</label>
                            <select id="estado" name="estado" required>
                                <option value="activo" <?php echo $recreo['estado'] == 'activo' ? 'selected' : ''; ?>>Activo</option>
                                <option value="inactivo" <?php echo $recreo['estado'] == 'inactivo' ? 'selected' : ''; ?>>Inactivo</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Actualizar Recreo
                        </button>
                        <a href="index.php?controller=Recreo&action=index" class="btn btn-secondary">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
include 'includes/footer.php';
?>
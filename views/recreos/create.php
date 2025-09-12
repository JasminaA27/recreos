<?php
// views/recreos/create.php

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
     
            <li><a href="index.php?controller=Auth&action=logout"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a></li>
        </ul>
    </div>
    
    <!-- Main Content -->
    <div class="main-content">
        <div class="content-header">
            <h2>Agregar Nuevo Recreo</h2>
            <div class="header-actions">
                <a href="index.php?controller=Recreo&action=index" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>
        </div>

        <!-- Formulario de creación -->
        <div class="card">
            <div class="card-header">
                <h3><i class="fas fa-store"></i> Información del Recreo</h3>
            </div>
            <div class="card-body">
                <form action="index.php?controller=Recreo&action=store" method="POST" class="recreo-form">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" id="nombre" name="nombre" required placeholder="Ingrese el nombre del recreo" class="form-input">
                        </div>

                        <div class="form-group">
                            <label for="ubicacion">Ubicación</label>
                            <select id="ubicacion" name="ubicacion" required class="form-select">
                                <option value="">Seleccionar ubicación</option>
                                <option value="Huanta">🏔️ Huanta</option>
                                <option value="Luricocha">🌄 Luricocha</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="direccion">Dirección</label>
                            <input type="text" id="direccion" name="direccion" required placeholder="Dirección completa del recreo" class="form-input">
                        </div>

                        <div class="form-group">
                            <label for="referencia">Referencia</label>
                            <textarea id="referencia" name="referencia" rows="2" placeholder="Puntos de referencia cercanos..." class="form-textarea"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="telefono">Teléfono</label>
                            <input type="text" id="telefono" name="telefono" placeholder="Número de contacto" class="form-input">
                        </div>

                        <div class="form-group">
                            <label for="especialidad">Servicios</label>
                            <input type="text" id="especialidad" name="especialidad" placeholder="Especialidad gastronómica" class="form-input">
                        </div>

                        <div class="form-group">
                            <label for="precio">Rango de Precio</label>
                            <input type="text" id="precio" name="precio" placeholder="Ej: S/ 25-35" class="form-input">
                        </div>

                        <div class="form-group">
                            <label for="estado">Estado</label>
                            <select id="estado" name="estado" required class="form-select">
                                <option value="activo">✅ Activo</option>
                                <option value="inactivo">❌ Inactivo</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Guardar Recreo
                        </button>
                        <a href="index.php?controller=Recreo&action=index" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancelar
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
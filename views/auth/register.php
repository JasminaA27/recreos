<?php
// views/auth/register.php

// Si ya está logueado, redirigir al dashboard
if (isset($_SESSION['user_id'])) {
    header('Location: index.php?controller=Dashboard&action=index');
    exit;
}

include '../includes/header.php';
?>

<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <h2>Crear Cuenta</h2>
            <p>Regístrate para comenzar</p>
        </div>
        
        <div class="auth-body">
            <?php if (isset($error)): ?>
                <div class="alert alert-error">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
            
            <form action="index.php?controller=Auth&action=register" method="POST">
                <div class="form-group">
                    <label for="nombre_completo">Nombre Completo</label>
                    <input type="text" id="nombre_completo" name="nombre_completo" required>
                </div>
                
                <div class="form-group">
                    <label for="username">Usuario</label>
                    <input type="text" id="username" name="username" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" required>
                    <small>Mínimo 6 caracteres</small>
                </div>
                
                <div class="form-group">
                    <label for="confirm_password">Confirmar Contraseña</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>
                
                <button type="submit" class="btn btn-primary btn-block">Registrarse</button>
            </form>
        </div>
        
        <div class="auth-footer">
            <p>¿Ya tienes una cuenta? <a href="index.php?controller=Auth&action=login">Inicia sesión aquí</a></p>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
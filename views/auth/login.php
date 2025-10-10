<?php require_once '../views/layouts/header.php'; ?>

<style>
.login-container {
    min-height: 100vh;
    background: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
}

.login-card {
    border: none;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    width: 100%;
    max-width: 400px;
}

.login-header {
    background: #2c3e50;
    color: white;
    padding: 2rem;
    text-align: center;
    border-radius: 12px 12px 0 0;
}

.login-header h4 {
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.login-body {
    padding: 2rem;
    background: white;
    border-radius: 0 0 12px 12px;
}

.form-control {
    border-radius: 8px;
    padding: 0.75rem;
    border: 1px solid #ddd;
    margin-bottom: 1rem;
}

.form-control:focus {
    border-color: #2c3e50;
    box-shadow: 0 0 0 2px rgba(44, 62, 80, 0.1);
}

.btn-login {
    background: #2c3e50;
    border: none;
    border-radius: 8px;
    padding: 0.75rem;
    font-weight: 600;
    color: white;
    width: 100%;
    margin-top: 1rem;
}

.btn-login:hover {
    background: #34495e;
    transform: translateY(-1px);
}

.credential-hint {
    background: #e8f4fd;
    border: 1px solid #b8daff;
    border-radius: 8px;
    padding: 1rem;
    margin-bottom: 1.5rem;
}

.system-info {
    text-align: center;
    margin-top: 1.5rem;
    padding-top: 1.5rem;
    border-top: 1px solid #e9ecef;
}

.badge-simple {
    background: #2c3e50;
    color: white;
    border-radius: 15px;
    padding: 0.4rem 0.8rem;
    font-size: 0.75rem;
    font-weight: 500;
}
</style>

<div class="login-container">
    <div class="login-card">
        <!-- Header -->
        <div class="login-header">
            <h4>ControlEmpresas</h4>
            <p class="mb-0">Sistema de Gestión</p>
        </div>

        <!-- Body -->
        <div class="login-body">
            <!-- Alertas de error -->
            <?php if (isset($error)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <?php echo $error; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Credenciales -->
            <div class="credential-hint">
                <div class="text-center small">
                    <strong>Credenciales de prueba</strong><br>
                    Usuario: <strong>admin</strong> | Contraseña: <strong>admin</strong>
                </div>
            </div>

            <!-- Formulario -->
            <form method="POST">
                <div class="mb-3">
                    <label for="username" class="form-label">Usuario</label>
                    <input type="text" class="form-control" id="username" name="username" 
                           value="admin" required>
                </div>
                
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" id="password" name="password" 
                           value="admin" required>
                </div>

                <button type="submit" class="btn btn-login">
                    <i class="fas fa-sign-in-alt me-2"></i>
                    Iniciar Sesión
                </button>
            </form>

            <!-- Información del sistema -->
            <div class="system-info">
                <span class="badge-simple">
                    Acceso Restringido
                </span>
            </div>
        </div>
    </div>
</div>

<script>
// Recordar credenciales
document.addEventListener('DOMContentLoaded', function() {
    const savedUsername = localStorage.getItem('rememberedUsername');
    const savedPassword = localStorage.getItem('rememberedPassword');
    
    if (savedUsername && savedPassword) {
        document.getElementById('username').value = savedUsername;
        document.getElementById('password').value = savedPassword;
    }
    
    // Guardar credenciales al enviar el formulario
    document.querySelector('form').addEventListener('submit', function() {
        localStorage.setItem('rememberedUsername', document.getElementById('username').value);
        localStorage.setItem('rememberedPassword', document.getElementById('password').value);
    });
});
</script>

<?php require_once '../views/layouts/footer.php'; ?>
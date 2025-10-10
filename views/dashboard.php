<?php 
require_once 'layouts/header.php';
authCheck();
?>

<style>
.dashboard-card {
    border: none;
    border-radius: 15px;
    transition: all 0.3s ease;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    overflow: hidden;
}

.dashboard-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}

.card-icon {
    font-size: 2.5rem;
    margin-bottom: 15px;
    opacity: 0.9;
}

.stats-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 15px;
    color: white;
    padding: 25px;
    margin-bottom: 25px;
}

.stats-number {
    font-size: 2.5rem;
    font-weight: bold;
    margin-bottom: 5px;
}

.stats-label {
    font-size: 0.9rem;
    opacity: 0.9;
}

.welcome-section {
    background: linear-gradient(135deg, #8e8fc2ff 0%, #3c46a0ff 100%);
    color: white;
    border-radius: 15px;
    padding: 30px;
    margin-bottom: 30px;
}

.quick-actions {
    background: white;
    border-radius: 15px;
    padding: 25px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
}

.action-btn {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    border: none;
    border-radius: 10px;
    padding: 12px 20px;
    color: white;
    text-decoration: none;
    display: block;
    text-align: center;
    transition: all 0.3s ease;
    margin-bottom: 10px;
}

.action-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(79, 172, 254, 0.4);
    color: white;
    text-decoration: none;
}

.badge-modern {
    border-radius: 20px;
    padding: 8px 15px;
    font-weight: 500;
}
</style>

<div class="container-fluid">
    <!-- Welcome Section -->
    <div class="welcome-section">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h2 class="mb-3">¡Bienvenido de vuelta, <?php echo $_SESSION['usuario_nombre']; ?>! 👋</h2>
                <p class="mb-0">Has ingresado al sistema de control de empresas y API. Gestiona todos tus recursos desde aquí.</p>
            </div>
            <div class="col-md-4 text-end">
                <div class="bg-white rounded-pill px-4 py-2 d-inline-block">
                    <small class="text-muted">Último acceso:</small>
                    <strong class="text-dark"><?php echo date('d/m/Y H:i'); ?></strong>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stats-card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="stats-number" id="empresas-count">-</div>
                <div class="stats-label">Empresas Registradas</div>
                <i class="fas fa-building card-icon mt-3"></i>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                <div class="stats-number" id="clientes-count">-</div>
                <div class="stats-label">Clientes API</div>
                <i class="fas fa-users card-icon mt-3"></i>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                <div class="stats-number" id="tokens-count">-</div>
                <div class="stats-label">Tokens Activos</div>
                <i class="fas fa-key card-icon mt-3"></i>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                <div class="stats-number" id="solicitudes-count">-</div>
                <div class="stats-label">Solicitudes Hoy</div>
                <i class="fas fa-chart-line card-icon mt-3"></i>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Main Actions -->
        <div class="col-md-8">
            <div class="row">
                <!-- Empresas Card -->
                <div class="col-md-6 mb-4">
                    <div class="dashboard-card card bg-primary text-white h-100">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <i class="fas fa-building card-icon"></i>
                                <span class="badge badge-modern bg-light text-primary">GESTIÓN</span>
                            </div>
                            <h4 class="card-title">Empresas</h4>
                            <p class="card-text flex-grow-1">Administra el registro completo de empresas, incluyendo datos comerciales y de contacto.</p>
                            <div class="mt-auto">
                                <a href="index.php?action=empresas" class="btn btn-light btn-sm me-2">
                                    <i class="fas fa-list me-1"></i>Ver Todas
                                </a>
                                <a href="index.php?action=empresas&method=crear" class="btn btn-outline-light btn-sm">
                                    <i class="fas fa-plus me-1"></i>Nueva
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Clientes API Card -->
                <div class="col-md-6 mb-4">
                    <div class="dashboard-card card bg-success text-white h-100">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <i class="fas fa-users card-icon"></i>
                                <span class="badge badge-modern bg-light text-success">API</span>
                            </div>
                            <h4 class="card-title">Clientes API</h4>
                            <p class="card-text flex-grow-1">Gestiona los clientes autorizados para consumir los servicios de API del sistema.</p>
                            <div class="mt-auto">
                                <a href="index.php?action=client_api" class="btn btn-light btn-sm me-2">
                                    <i class="fas fa-list me-1"></i>Ver Clientes
                                </a>
                                <a href="index.php?action=client_api&method=crear" class="btn btn-outline-light btn-sm">
                                    <i class="fas fa-plus me-1"></i>Nuevo
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tokens API Card -->
                <div class="col-md-6 mb-4">
                    <div class="dashboard-card card bg-warning text-white h-100">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <i class="fas fa-key card-icon"></i>
                                <span class="badge badge-modern bg-light text-warning">SEGURIDAD</span>
                            </div>
                            <h4 class="card-title">Tokens API</h4>
                            <p class="card-text flex-grow-1">Administra los tokens de acceso y genera nuevas credenciales para los clientes API.</p>
                            <div class="mt-auto">
                                <a href="index.php?action=token_api" class="btn btn-light btn-sm me-2">
                                    <i class="fas fa-list me-1"></i>Ver Tokens
                                </a>
                                <a href="index.php?action=token_api&method=generar" class="btn btn-outline-light btn-sm">
                                    <i class="fas fa-bolt me-1"></i>Generar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Solicitudes Card -->
                <div class="col-md-6 mb-4">
                    <div class="dashboard-card card bg-info text-white h-100">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <i class="fas fa-chart-line card-icon"></i>
                                <span class="badge badge-modern bg-light text-info">ANÁLISIS</span>
                            </div>
                            <h4 class="card-title">Solicitudes API</h4>
                            <p class="card-text flex-grow-1">Monitorea y analiza el uso de la API con estadísticas detalladas y reportes.</p>
                            <div class="mt-auto">
                                <a href="index.php?action=count_request" class="btn btn-light btn-sm me-2">
                                    <i class="fas fa-list me-1"></i>Ver Todas
                                </a>
                                <a href="index.php?action=count_request&method=estadisticas" class="btn btn-outline-light btn-sm">
                                    <i class="fas fa-chart-bar me-1"></i>Estadísticas
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions & System Info -->
        <div class="col-md-4">
            <!-- Quick Actions -->
            <div class="quick-actions mb-4">
                <h5 class="mb-3">📋 Acciones Rápidas</h5>
                <a href="index.php?action=empresas&method=crear" class="action-btn">
                    <i class="fas fa-plus-circle me-2"></i>Nueva Empresa
                </a>
                <a href="index.php?action=client_api&method=crear" class="action-btn">
                    <i class="fas fa-user-plus me-2"></i>Nuevo Cliente API
                </a>
                <a href="index.php?action=token_api&method=generar" class="action-btn">
                    <i class="fas fa-key me-2"></i>Generar Tokens
                </a>
                <a href="index.php?action=count_request&method=estadisticas" class="action-btn">
                    <i class="fas fa-chart-pie me-2"></i>Ver Estadísticas
                </a>
            </div>

            <!-- System Status -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h6 class="mb-0"><i class="fas fa-server me-2"></i>Estado del Sistema</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span>Base de Datos</span>
                        <span class="badge bg-success">En Línea</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span>Servidor API</span>
                        <span class="badge bg-success">Activo</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span>Autenticación</span>
                        <span class="badge bg-success">Operativa</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span>Última Actualización</span>
                        <span class="badge bg-info"><?php echo date('H:i'); ?></span>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-header bg-dark text-white">
                    <h6 class="mb-0"><i class="fas fa-clock me-2"></i>Actividad Reciente</h6>
                </div>
                <div class="card-body">
                    <div class="activity-item mb-3">
                        <small class="text-muted">Hoy, <?php echo date('H:i'); ?></small>
                        <div class="fw-bold">Sesión iniciada</div>
                        <small>Usuario: <?php echo $_SESSION['usuario_nombre']; ?></small>
                    </div>
                    <div class="activity-item mb-3">
                        <small class="text-muted">Sistema</small>
                        <div class="fw-bold">Dashboard cargado</div>
                        <small>Todas las funciones disponibles</small>
                    </div>
                    <a href="#" class="btn btn-outline-primary btn-sm w-100">
                        <i class="fas fa-history me-1"></i>Ver Historial Completo
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Función para cargar estadísticas (puedes implementar AJAX después)
document.addEventListener('DOMContentLoaded', function() {
    // Simular carga de estadísticas
    setTimeout(() => {
        document.getElementById('empresas-count').textContent = '12';
        document.getElementById('clientes-count').textContent = '8';
        document.getElementById('tokens-count').textContent = '24';
        document.getElementById('solicitudes-count').textContent = '156';
    }, 1000);
});

// Efectos hover mejorados
document.querySelectorAll('.dashboard-card').forEach(card => {
    card.addEventListener('mouseenter', function() {
        this.style.transform = 'translateY(-5px)';
    });
    
    card.addEventListener('mouseleave', function() {
        this.style.transform = 'translateY(0)';
    });
});
</script>

<!-- Font Awesome para íconos -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<?php require_once 'layouts/footer.php'; ?>
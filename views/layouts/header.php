<!DOCTYPE html>
<html lang="es" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Control de Empresas</title>
    
    <!-- Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
    
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --success-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --dark-gradient: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .navbar {
            background: var(--dark-gradient) !important;
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
            padding: 1rem 0;
        }
        
        .nav-link {
            font-weight: 500;
            transition: all 0.3s ease;
            border-radius: 8px;
            margin: 0 2px;
        }
        
        .nav-link:hover {
            background: rgba(255,255,255,0.1);
            transform: translateY(-1px);
        }
        
        .user-welcome {
            background: rgba(255,255,255,0.1);
            border-radius: 20px;
            padding: 8px 15px;
            border: 1px solid rgba(255,255,255,0.2);
        }
        
        .alert-modern {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            border-left: 4px solid;
        }
        
        .alert-success {
            border-left-color: #28a745;
            background: linear-gradient(135deg, #d4edda, #c3e6cb);
        }
        
        .alert-danger {
            border-left-color: #dc3545;
            background: linear-gradient(135deg, #f8d7da, #f5c6cb);
        }
        
        .alert-info {
            border-left-color: #17a2b8;
            background: linear-gradient(135deg, #d1ecf1, #bee5eb);
        }
        
        .btn-close:focus {
            box-shadow: none;
        }
        
        .theme-toggle {
            background: none;
            border: none;
            color: white;
            font-size: 1.2rem;
            margin-right: 10px;
            transition: all 0.3s ease;
        }
        
        .theme-toggle:hover {
            transform: rotate(180deg);
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="index.php?action=dashboard">
                <i class="fas fa-chart-network me-2"></i>
                ControlEmpresas
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <?php if (isset($_SESSION['usuario_id'])): ?>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?action=dashboard">
                            <i class="fas fa-home me-1"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-building me-1"></i>Empresas
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="index.php?action=empresas">Ver Empresas</a></li>
                            <li><a class="dropdown-item" href="index.php?action=empresas&method=crear">Nueva Empresa</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-code me-1"></i>API
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="index.php?action=client_api">Clientes API</a></li>
                            <li><a class="dropdown-item" href="index.php?action=token_api">Tokens API</a></li>
                            <li><a class="dropdown-item" href="index.php?action=count_request">Solicitudes</a></li>
                        </ul>
                    </li>
                </ul>
                
                <div class="navbar-nav ms-auto d-flex align-items-center">
                    <!-- Theme Toggle -->
                    <button class="theme-toggle" id="themeToggle" title="Cambiar tema">
                        <i class="fas fa-moon"></i>
                    </button>
                    
                    <!-- User Welcome -->
                    <div class="user-welcome me-3">
                        <i class="fas fa-user-circle me-2"></i>
                        <span class="d-none d-md-inline">Hola, <?php echo $_SESSION['usuario_nombre']; ?></span>
                    </div>
                    
                    <!-- Logout -->
                    <a class="nav-link btn-logout" href="index.php?action=logout">
                        <i class="fas fa-sign-out-alt me-1"></i>
                        <span class="d-none d-md-inline">Cerrar Sesión</span>
                    </a>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container mt-4">
        <!-- Alert Messages -->
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success alert-modern alert-dismissible fade show" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-check-circle me-3 fs-4"></i>
                    <div>
                        <h6 class="alert-heading mb-1">¡Operación Exitosa!</h6>
                        <?php
                        switch ($_GET['success']) {
                            case 1: echo "Empresa creada correctamente"; break;
                            case 2: echo "Empresa actualizada correctamente"; break;
                            case 3: echo "Empresa eliminada correctamente"; break;
                            case 4: echo "Cliente API creado correctamente"; break;
                            case 5: echo "Token generado correctamente"; break;
                            case 6: echo "Solicitud registrada correctamente"; break;
                            default: echo "Operación completada con éxito"; break;
                        }
                        ?>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger alert-modern alert-dismissible fade show" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-exclamation-triangle me-3 fs-4"></i>
                    <div>
                        <h6 class="alert-heading mb-1">¡Error en la Operación!</h6>
                        <?php
                        switch ($_GET['error']) {
                            case 1: echo "Registro no encontrado"; break;
                            case 2: echo "Error al eliminar el registro"; break;
                            case 3: echo "Datos inválidos o incompletos"; break;
                            case 4: echo "Error de validación"; break;
                            case 5: echo "Acceso denegado"; break;
                            default: echo "Ha ocurrido un error inesperado"; break;
                        }
                        ?>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['info'])): ?>
            <div class="alert alert-info alert-modern alert-dismissible fade show" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-info-circle me-3 fs-4"></i>
                    <div>
                        <h6 class="alert-heading mb-1">Información</h6>
                        <?php
                        switch ($_GET['info']) {
                            case 1: echo "Operación completada con advertencias"; break;
                            case 2: echo "Algunos datos fueron modificados"; break;
                            default: echo "Información del sistema"; break;
                        }
                        ?>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
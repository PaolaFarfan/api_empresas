    </main>

    <!-- Footer Simplificado -->
    <footer class="bg-dark text-white mt-5">
        <div class="container py-4">
            <div class="row align-items-center">
                <!-- Información principal -->
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    <div class="d-flex align-items-center justify-content-center justify-content-md-start">
                        <i class="fas fa-chart-network me-2 text-primary"></i>
                        <h5 class="mb-0 fw-bold">ControlEmpresas</h5>
                    </div>
                    <p class="mb-0 mt-2 text-light small">
                        Sistema de gestión empresarial y API
                    </p>
                </div>
                
                <!-- Enlaces rápidos -->
                <div class="col-md-6 text-center text-md-end">
                    <div class="mb-2">
                        <a href="index.php?action=dashboard" class="text-light text-decoration-none me-3 small">
                            <i class="fas fa-home me-1"></i>Dashboard
                        </a>
                        <a href="index.php?action=empresas" class="text-light text-decoration-none me-3 small">
                            <i class="fas fa-building me-1"></i>Empresas
                        </a>
                        <a href="index.php?action=client_api" class="text-light text-decoration-none small">
                            <i class="fas fa-code me-1"></i>API
                        </a>
                    </div>
                    
                    <!-- Copyright y versión -->
                    <div class="d-flex flex-column flex-md-row justify-content-center justify-content-md-end align-items-center">
                        <span class="small text-light me-2">
                            &copy; 2024 ControlEmpresas
                        </span>
                        <span class="small text-muted d-none d-md-block mx-2">•</span>
                        <span class="small text-muted">
                            v2.1.0
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Theme Toggle (mantenemos esta funcionalidad)
        document.getElementById('themeToggle').addEventListener('click', function() {
            const currentTheme = document.documentElement.getAttribute('data-bs-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            
            document.documentElement.setAttribute('data-bs-theme', newTheme);
            this.innerHTML = newTheme === 'dark' ? 
                '<i class="fas fa-sun"></i>' : 
                '<i class="fas fa-moon"></i>';
                
            localStorage.setItem('theme', newTheme);
        });
        
        // Cargar tema guardado
        const savedTheme = localStorage.getItem('theme') || 'light';
        document.documentElement.setAttribute('data-bs-theme', savedTheme);
        document.getElementById('themeToggle').innerHTML = savedTheme === 'dark' ? 
            '<i class="fas fa-sun"></i>' : 
            '<i class="fas fa-moon"></i>';
            
        // Auto-dismiss alerts después de 5 segundos
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            });
        });
    </script>
    
    <style>
        /* Estilos específicos para el footer simplificado */
        footer {
            border-top: 1px solid rgba(255,255,255,0.1);
        }
        
        footer a {
            transition: all 0.3s ease;
        }
        
        footer a:hover {
            color: #667eea !important;
            text-decoration: underline !important;
        }
        
        /* Asegurar que el contenido principal tenga suficiente espacio */
        main {
            min-height: calc(100vh - 200px);
        }
    </style>
</body>
</html>
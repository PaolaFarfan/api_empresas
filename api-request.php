<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API de Empresas - Consulta</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background-color: #f5f5f5; }
        .container { max-width: 1200px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input, textarea, select { 
            width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; 
            box-sizing: border-box; 
        }
        button { 
            background-color: #007bff; color: white; padding: 10px 20px; 
            border: none; border-radius: 4px; cursor: pointer; font-size: 16px; 
            margin: 5px;
        }
        button:hover { background-color: #0056b3; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #f8f9fa; }
        .loading, .error { text-align: center; padding: 20px; }
        .error { color: #dc3545; }
        .success { color: #28a745; background-color: #d4edda; border: 1px solid #c3e6cb; }
        .info { color: #856404; background-color: #fff3cd; border: 1px solid #ffeaa7; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Consulta de Empresas - API</h1>
        
        <div class="form-group">
            <label for="ruta_api">URL de la API:</label>
            <input type="text" id="ruta_api" value="http://localhost:8888/api_empresas" placeholder="http://localhost:8888/api_empresas">
            <small style="color: #666;">Asegúrate de que la URL termine con /</small>
        </div>
        
        <form id="frmApi">
            <div class="form-group">
                <label for="token">Token de autenticación:</label>
                <input type="text" name="token" id="token" value="tok_e2356534bb700782b9e4588bb8b8e526" placeholder="Ingresa tu token">
            </div>
            
            <div class="form-group">
                <label for="tipo_consulta">Tipo de consulta:</label>
                <select name="tipo" id="tipo_consulta">
                    <option value="listar">Listar todas las empresas</option>
                    <option value="buscarPorNombre">Buscar por nombre</option>
                    <option value="buscarPorRUC">Buscar por RUC</option>
                </select>
            </div>
            
            <div class="form-group" id="grupo_busqueda" style="display: none;">
                <label for="valor_busqueda">Valor de búsqueda:</label>
                <input type="text" name="valor_busqueda" id="valor_busqueda" placeholder="Ingresa el valor a buscar">
            </div>
        </form>
        
        <button id="btn_buscar">Consultar Empresas</button>
        <button id="btn_limpiar" type="button">Limpiar Resultados</button>
        <button id="btn_probar_conexion" type="button">Probar Conexión</button>
        
        <div id="mensaje" style="margin: 10px 0; padding: 10px; border-radius: 4px; display: none;"></div>
        
        <div style="overflow-x: auto; margin-top: 20px;">
            <table>
                <thead>
                    <tr>
                        <th>Nro</th>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>RUC</th>
                        <th>Dirección</th>
                        <th>Teléfono</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody id="contenido">
                    <tr>
                        <td colspan="7" class="loading">Realice una consulta para ver los resultados</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // ========== CÓDIGO JAVASCRIPT CORREGIDO ==========
        
        console.log('✅ JavaScript cargado correctamente');
        
        async function llamar_api() {
            console.log('🔍 Iniciando consulta a la API...');
            
            const formulario = document.getElementById('frmApi');
            const datos = new FormData(formulario);
            let ruta_api = document.getElementById('ruta_api').value.trim();
            
            // Limpiar mensajes anteriores
            document.getElementById('mensaje').style.display = 'none';
            
            // Validaciones básicas
            if (!ruta_api) {
                mostrarError(' Por favor, ingresa la URL de la API');
                return;
            }
            
            // Asegurar que la URL termine con /
            if (!ruta_api.endsWith('/')) {
                ruta_api += '/';
                document.getElementById('ruta_api').value = ruta_api;
            }
            
            const token = datos.get('token');
            if (!token) {
                mostrarError('❌ El token de autenticación es requerido');
                return;
            }
            
            // Construir URL según el tipo de consulta
            const tipoConsulta = datos.get('tipo');
            let endpoint = '';
            let parametros = '';
            
            switch(tipoConsulta) {
                case 'listar':
                    endpoint = 'empresas.php';
                    parametros = '?accion=listar';
                    break;
                case 'buscarPorNombre':
                    const nombre = datos.get('valor_busqueda');
                    if (!nombre) {
                        mostrarError('❌ Ingrese un nombre para buscar');
                        return;
                    }
                    endpoint = 'empresas.php';
                    parametros = `?accion=buscar&campo=nombre&valor=${encodeURIComponent(nombre)}`;
                    break;
                case 'buscarPorRUC':
                    const ruc = datos.get('valor_busqueda');
                    if (!ruc) {
                        mostrarError('❌ Ingrese un RUC para buscar');
                        return;
                    }
                    endpoint = 'empresas.php';
                    parametros = `?accion=buscar&campo=ruc&valor=${encodeURIComponent(ruc)}`;
                    break;
                default:
                    endpoint = 'empresas.php';
                    parametros = '?accion=listar';
            }
            
            // Agregar token a los parámetros
            parametros += `&token=${encodeURIComponent(token)}`;
            
            const urlCompleta = ruta_api + endpoint + parametros;
            console.log('🌐 URL completa:', urlCompleta);
            
            try {
                // Mostrar estado de carga
                mostrarCarga();
                mostrarMensaje('⏳ Conectando con la API...', 'info');
                
                // Realizar la petición con timeout
                const controller = new AbortController();
                const timeoutId = setTimeout(() => controller.abort(), 10000); // 10 segundos timeout
                
                const respuesta = await fetch(urlCompleta, {
                    method: 'GET',
                    mode: 'cors',
                    cache: 'no-cache',
                    headers: {
                        'Accept': 'application/json',
                    },
                    signal: controller.signal
                });
                
                clearTimeout(timeoutId);
                
                console.log('📨 Estado de respuesta:', respuesta.status, respuesta.statusText);
                
                // Verificar si la respuesta es exitosa
                if (!respuesta.ok) {
                    throw new Error(`Error HTTP ${respuesta.status}: ${respuesta.statusText}`);
                }
                
                // Verificar que la respuesta sea JSON
                const contentType = respuesta.headers.get('content-type');
                if (!contentType || !contentType.includes('application/json')) {
                    throw new Error('La respuesta no es JSON válido');
                }
                
                const json = await respuesta.json();
                console.log('📊 Datos recibidos:', json);
                
                // Verificar si la API retornó éxito
                if (!json.success) {
                    throw new Error(json.message || 'Error en la respuesta de la API');
                }
                
                // Mostrar los resultados
                mostrarResultados(json.data || []);
                mostrarMensaje(`✅ Consulta exitosa - Se encontraron ${json.total || json.data?.length || 0} empresas`, 'success');
                
            } catch (error) {
                console.error('❌ Error completo:', error);
                
                if (error.name === 'AbortError') {
                    mostrarError('⏰ Timeout: La solicitud tardó demasiado tiempo');
                } else if (error.name === 'TypeError' && error.message.includes('Failed to fetch')) {
                    mostrarError('🔌 Error de conexión: No se pudo conectar con el servidor. Verifica:<br>' +
                                '1. Que el servidor esté ejecutándose<br>' +
                                '2. Que la URL sea correcta<br>' +
                                '3. Que no haya problemas de CORS');
                } else {
                    mostrarError(`❌ Error: ${error.message}`);
                }
            }
        }

        function mostrarResultados(empresas) {
            let contenidoHTML = '';
            
            if (!empresas || empresas.length === 0) {
                contenidoHTML = '<tr><td colspan="7" class="loading">No se encontraron empresas</td></tr>';
            } else {
                empresas.forEach((empresa, index) => {
                    contenidoHTML += `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${empresa.id || 'N/A'}</td>
                            <td>${empresa.nombre || 'N/A'}</td>
                            <td>${empresa.ruc || 'N/A'}</td>
                            <td>${empresa.direccion || 'N/A'}</td>
                            <td>${empresa.telefono || 'N/A'}</td>
                            <td>${empresa.email || 'N/A'}</td>
                        </tr>
                    `;
                });
            }
            
            document.getElementById('contenido').innerHTML = contenidoHTML;
        }

        function mostrarCarga() {
            document.getElementById('contenido').innerHTML = '<tr><td colspan="7" class="loading">🔄 Cargando empresas...</td></tr>';
        }

        function mostrarMensaje(mensaje, tipo = 'info') {
            const mensajeDiv = document.getElementById('mensaje');
            mensajeDiv.innerHTML = mensaje;
            mensajeDiv.className = tipo;
            mensajeDiv.style.display = 'block';
        }

        function mostrarError(mensaje) {
            document.getElementById('contenido').innerHTML = `<tr><td colspan="7" class="error">${mensaje}</td></tr>`;
            mostrarMensaje(mensaje, 'error');
        }

        function limpiarResultados() {
            document.getElementById('contenido').innerHTML = '<tr><td colspan="7" class="loading">Realice una consulta para ver los resultados</td></tr>';
            document.getElementById('mensaje').style.display = 'none';
            document.getElementById('valor_busqueda').value = '';
        }

        async function probarConexion() {
            const ruta_api = document.getElementById('ruta_api').value.trim();
            const token = document.getElementById('token').value.trim();
            
            if (!ruta_api || !token) {
                mostrarMensaje('❌ Ingresa URL y token primero', 'error');
                return;
            }
            
            try {
                mostrarMensaje('🔍 Probando conexión...', 'info');
                
                const url = ruta_api + 'empresas.php?accion=listar&token=' + encodeURIComponent(token);
                const respuesta = await fetch(url, { method: 'GET' });
                
                if (respuesta.ok) {
                    mostrarMensaje('✅ Conexión exitosa - El servidor responde correctamente', 'success');
                } else {
                    mostrarMensaje(`⚠️ Servidor responde con error: ${respuesta.status}`, 'error');
                }
            } catch (error) {
                mostrarMensaje(`❌ Error de conexión: ${error.message}`, 'error');
            }
        }

        // Eventos cuando se carga la página
        document.addEventListener('DOMContentLoaded', function() {
            console.log('✅ Página cargada correctamente');
            
            // Asignar eventos a los botones
            document.getElementById('btn_buscar').addEventListener('click', llamar_api);
            document.getElementById('btn_limpiar').addEventListener('click', limpiarResultados);
            document.getElementById('btn_probar_conexion').addEventListener('click', probarConexion);
            
            // Manejar cambio en el tipo de consulta
            document.getElementById('tipo_consulta').addEventListener('change', function() {
                const tipo = this.value;
                const grupoBusqueda = document.getElementById('grupo_busqueda');
                
                if (tipo === 'listar') {
                    grupoBusqueda.style.display = 'none';
                } else {
                    grupoBusqueda.style.display = 'block';
                    
                    // Establecer placeholder según el tipo
                    const placeholder = tipo === 'buscarPorRUC' ? 
                        'Ingrese RUC (11 dígitos)' : 'Ingrese nombre de la empresa';
                    document.getElementById('valor_busqueda').placeholder = placeholder;
                }
            });
            
            // Inicializar estado del formulario
            document.getElementById('tipo_consulta').dispatchEvent(new Event('change'));
            
            // Mensaje de bienvenida
            mostrarMensaje('👋 Bienvenido. Configura la URL y token, luego haz una consulta.', 'info');
        });

    </script>
</body>
</html>
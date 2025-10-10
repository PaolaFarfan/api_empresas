<?php 
require_once '../views/layouts/header.php';
authCheck();
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Registro de Solicitudes API</h2>
    <div>
        <a href="index.php?action=count_request&method=crear" class="btn btn-success">Nueva Solicitud</a>
        <a href="index.php?action=count_request&method=estadisticas" class="btn btn-info">Estadísticas</a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <?php if ($solicitudes->rowCount() > 0): ?>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Token</th>
                            <th>Cliente</th>
                            <th>Tipo</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($solicitud = $solicitudes->fetch(PDO::FETCH_ASSOC)): ?>
                        <tr>
                            <td><?php echo $solicitud['id']; ?></td>
                            <td>
                                <code class="text-truncate" style="max-width: 120px; display: inline-block;">
                                    <?php echo htmlspecialchars($solicitud['token']); ?>
                                </code>
                            </td>
                            <td><?php echo htmlspecialchars($solicitud['razon_social']); ?></td>
                            <td>
                                <span class="badge bg-<?php 
                                    switch($solicitud['tipo']) {
                                        case 'consulta': echo 'primary'; break;
                                        case 'registro': echo 'success'; break;
                                        case 'actualizacion': echo 'warning'; break;
                                        case 'eliminacion': echo 'danger'; break;
                                        default: echo 'secondary';
                                    }
                                ?>">
                                    <?php echo ucfirst($solicitud['tipo']); ?>
                                </span>
                            </td>
                            <td><?php echo date('d/m/Y H:i', strtotime($solicitud['fecha'])); ?></td>
                            <td>
                                <a href="index.php?action=count_request&method=editar&id=<?php echo $solicitud['id']; ?>" 
                                   class="btn btn-sm btn-warning">Editar</a>
                                <a href="index.php?action=count_request&method=eliminar&id=<?php echo $solicitud['id']; ?>" 
                                   class="btn btn-sm btn-danger" 
                                   onclick="return confirm('¿Estás seguro de eliminar esta solicitud?')">Eliminar</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-info text-center">
                No hay solicitudes registradas. <a href="index.php?action=count_request&method=crear">Registra la primera</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once '../views/layouts/footer.php'; ?>
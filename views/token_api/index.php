<?php 
require_once '../views/layouts/header.php';
authCheck();
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Gestión de Tokens API</h2>
    <div>
        <a href="index.php?action=token_api&method=crear" class="btn btn-success">Nuevo Token</a>
        <a href="index.php?action=token_api&method=generar" class="btn btn-info">Generar Múltiples</a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <?php if ($tokens->rowCount() > 0): ?>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Token</th>
                            <th>Cliente API</th>
                            <th>RUC Cliente</th>
                            <th>Estado</th>
                            <th>Fecha Registro</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($token = $tokens->fetch(PDO::FETCH_ASSOC)): ?>
                        <tr>
                            <td><?php echo $token['id']; ?></td>
                            <td>
                                <code class="" style="max-width: 150px; display: inline-block;">
                                    <?php echo htmlspecialchars($token['token']); ?>
                                </code>
                            </td>
                            <td><?php echo htmlspecialchars($token['razon_social']); ?></td>
                            <td><?php echo htmlspecialchars($token['ruc']); ?></td>
                            <td>
                                <span class="badge bg-<?php echo $token['estado'] ? 'success' : 'danger'; ?>">
                                    <?php echo $token['estado'] ? 'Activo' : 'Inactivo'; ?>
                                </span>
                            </td>
                            <td><?php echo date('d/m/Y H:i', strtotime($token['fecha_registro'])); ?></td>
                            <td>
                                <a href="index.php?action=token_api&method=editar&id=<?php echo $token['id']; ?>" 
                                   class="btn btn-sm btn-warning">Editar</a>
                                <a href="index.php?action=token_api&method=eliminar&id=<?php echo $token['id']; ?>" 
                                   class="btn btn-sm btn-danger" 
                                   onclick="return confirm('¿Estás seguro de eliminar este token?')">Eliminar</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-info text-center">
                No hay tokens registrados. <a href="index.php?action=token_api&method=crear">Crea el primero</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once '../views/layouts/footer.php'; ?>
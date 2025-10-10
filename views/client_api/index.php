<?php 
require_once '../views/layouts/header.php';
authCheck();
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Gestión de Clientes API</h2>
    <a href="index.php?action=client_api&method=crear" class="btn btn-success">Nuevo Cliente</a>
</div>

<div class="card">
    <div class="card-body">
        <?php if ($clientes->rowCount() > 0): ?>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>RUC</th>
                            <th>Razón Social</th>
                            <th>Teléfono</th>
                            <th>Correo</th>
                            <th>Estado</th>
                            <th>Fecha Registro</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($cliente = $clientes->fetch(PDO::FETCH_ASSOC)): ?>
                        <tr>
                            <td><?php echo $cliente['id']; ?></td>
                            <td><?php echo htmlspecialchars($cliente['ruc']); ?></td>
                            <td><?php echo htmlspecialchars($cliente['razon_social']); ?></td>
                            <td><?php echo htmlspecialchars($cliente['telefono']); ?></td>
                            <td><?php echo htmlspecialchars($cliente['correo']); ?></td>
                            <td>
                                <span class="badge bg-<?php echo $cliente['estado'] ? 'success' : 'danger'; ?>">
                                    <?php echo $cliente['estado'] ? 'Activo' : 'Inactivo'; ?>
                                </span>
                            </td>
                            <td><?php echo date('d/m/Y', strtotime($cliente['fecha_registro'])); ?></td>
                            <td>
                                <a href="index.php?action=client_api&method=editar&id=<?php echo $cliente['id']; ?>" 
                                   class="btn btn-sm btn-warning">Editar</a>
                                <a href="index.php?action=client_api&method=eliminar&id=<?php echo $cliente['id']; ?>" 
                                   class="btn btn-sm btn-danger" 
                                   onclick="return confirm('¿Estás seguro de eliminar este cliente?')">Eliminar</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-info text-center">
                No hay clientes API registrados. <a href="index.php?action=client_api&method=crear">Agrega el primero</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once '../views/layouts/footer.php'; ?>
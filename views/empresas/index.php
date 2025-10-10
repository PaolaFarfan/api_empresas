<?php 
require_once '../views/layouts/header.php';
authCheck();
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Gestión de Empresas</h2>
    <a href="index.php?action=empresas&method=crear" class="btn btn-success">Nueva Empresa</a>
</div>

<div class="card">
    <div class="card-body">
        <?php if ($empresas->rowCount() > 0): ?>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>RUC</th>
                            <th>Teléfono</th>
                            <th>Email</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($empresa = $empresas->fetch(PDO::FETCH_ASSOC)): ?>
                        <tr>
                            <td><?php echo $empresa['id']; ?></td>
                            <td><?php echo htmlspecialchars($empresa['nombre']); ?></td>
                            <td><?php echo htmlspecialchars($empresa['ruc']); ?></td>
                            <td><?php echo htmlspecialchars($empresa['telefono']); ?></td>
                            <td><?php echo htmlspecialchars($empresa['email']); ?></td>
                            <td>
                                <a href="index.php?action=empresas&method=editar&id=<?php echo $empresa['id']; ?>" 
                                   class="btn btn-sm btn-warning">Editar</a>
                                <a href="index.php?action=empresas&method=eliminar&id=<?php echo $empresa['id']; ?>" 
                                   class="btn btn-sm btn-danger" 
                                   onclick="return confirm('¿Estás seguro de eliminar esta empresa?')">Eliminar</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-info text-center">
                No hay empresas registradas. <a href="index.php?action=empresas&method=crear">Agrega la primera</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once '../views/layouts/footer.php'; ?>
<?php 
require_once '../views/layouts/header.php';
authCheck();
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Estadísticas de Solicitudes API</h2>
</div>

<div class="card mb-4">
    <div class="card-header">
        <h5>Filtros</h5>
    </div>
    <div class="card-body">
        <form method="GET" class="row">
            <input type="hidden" name="action" value="count_request">
            <input type="hidden" name="method" value="estadisticas">
            
            <div class="col-md-4">
                <label for="fecha_inicio" class="form-label">Fecha Inicio</label>
                <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" 
                       value="<?php echo htmlspecialchars($fecha_inicio); ?>">
            </div>
            <div class="col-md-4">
                <label for="fecha_fin" class="form-label">Fecha Fin</label>
                <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" 
                       value="<?php echo htmlspecialchars($fecha_fin); ?>">
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">Filtrar</button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <?php if ($estadisticas->rowCount() > 0): ?>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Tipo</th>
                            <th>Total Solicitudes</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $totalGeneral = 0;
                        while ($estadistica = $estadisticas->fetch(PDO::FETCH_ASSOC)): 
                            $totalGeneral += $estadistica['total'];
                        ?>
                        <tr>
                            <td><?php echo date('d/m/Y', strtotime($estadistica['dia'])); ?></td>
                            <td>
                                <span class="badge bg-<?php 
                                    switch($estadistica['tipo']) {
                                        case 'consulta': echo 'primary'; break;
                                        case 'registro': echo 'success'; break;
                                        case 'actualizacion': echo 'warning'; break;
                                        case 'eliminacion': echo 'danger'; break;
                                        default: echo 'secondary';
                                    }
                                ?>">
                                    <?php echo ucfirst($estadistica['tipo']); ?>
                                </span>
                            </td>
                            <td><?php echo $estadistica['total']; ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                    <tfoot>
                        <tr class="table-primary">
                            <td colspan="2"><strong>Total General</strong></td>
                            <td><strong><?php echo $totalGeneral; ?></strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-info text-center">
                No hay estadísticas disponibles para el período seleccionado.
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once '../views/layouts/footer.php'; ?>
<?php 
require_once '../views/layouts/header.php';
authCheck();
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h4>Generar Múltiples Tokens</h4>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label for="id_client_api" class="form-label">Cliente API *</label>
                        <select class="form-control" id="id_client_api" name="id_client_api" required>
                            <option value="">Seleccione un cliente</option>
                            <?php while ($cliente = $clientes->fetch(PDO::FETCH_ASSOC)): ?>
                                <option value="<?php echo $cliente['id']; ?>">
                                    <?php echo htmlspecialchars($cliente['razon_social'] . ' - ' . $cliente['ruc']); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="cantidad" class="form-label">Cantidad de Tokens *</label>
                        <input type="number" class="form-control" id="cantidad" name="cantidad" 
                               min="1" max="50" value="1" required>
                        <small class="form-text text-muted">Máximo 50 tokens por vez</small>
                    </div>

                    <div class="alert alert-info">
                        <strong>Nota:</strong> Se generarán tokens únicos automáticamente con el formato: tok_xxxxxxxxxxxxxxxx
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="index.php?action=token_api" class="btn btn-secondary me-md-2">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Generar Tokens</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once '../views/layouts/footer.php'; ?>
<?php 
require_once '../views/layouts/header.php';
authCheck();
?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4>Nuevo Token API</h4>
            </div>
            <div class="card-body">
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>

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
                        <label for="token" class="form-label">Token</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="token" name="token" 
                                   value="<?php echo (new TokenApi())->generarToken(); ?>" 
                                   placeholder="Token generado automáticamente">
                            <button type="button" class="btn btn-outline-secondary" onclick="generarToken()">
                                Generar Nuevo
                            </button>
                        </div>
                        <small class="form-text text-muted">Deje en blanco para generar automáticamente</small>
                    </div>

                    <div class="mb-3">
                        <label for="estado" class="form-label">Estado</label>
                        <select class="form-control" id="estado" name="estado">
                            <option value="1" selected>Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="index.php?action=token_api" class="btn btn-secondary me-md-2">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Guardar Token</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function generarToken() {
    const chars = 'abcdefghijklmnopqrstuvwxyz0123456789';
    let token = 'tok_';
    for (let i = 0; i < 16; i++) {
        token += chars.charAt(Math.floor(Math.random() * chars.length));
    }
    document.getElementById('token').value = token;
}
</script>

<?php require_once '../views/layouts/footer.php'; ?>
<?php 
require_once '../views/layouts/header.php';
authCheck();
?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4>Editar Token API</h4>
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
                            <?php 
                            $clientes->execute(); // Reiniciar el cursor
                            while ($cliente = $clientes->fetch(PDO::FETCH_ASSOC)): 
                            ?>
                                <option value="<?php echo $cliente['id']; ?>" 
                                    <?php echo (isset($token->id_client_api) && $token->id_client_api == $cliente['id']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($cliente['razon_social'] . ' - ' . $cliente['ruc']); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="token" class="form-label">Token *</label>
                        <input type="text" class="form-control" id="token" name="token" required
                               value="<?php echo isset($token->token) ? htmlspecialchars($token->token) : ''; ?>">
                    </div>

                    <div class="mb-3">
                        <label for="estado" class="form-label">Estado</label>
                        <select class="form-control" id="estado" name="estado">
                            <option value="1" <?php echo (isset($token->estado) && $token->estado == 1) ? 'selected' : ''; ?>>Activo</option>
                            <option value="0" <?php echo (isset($token->estado) && $token->estado == 0) ? 'selected' : ''; ?>>Inactivo</option>
                        </select>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="index.php?action=token_api" class="btn btn-secondary me-md-2">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Actualizar Token</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once '../views/layouts/footer.php'; ?>
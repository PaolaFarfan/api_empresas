<?php 
require_once '../views/layouts/header.php';
authCheck();
?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4>Editar Solicitud API</h4>
            </div>
            <div class="card-body">
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>

                <form method="POST">
                    <div class="mb-3">
                        <label for="id_token" class="form-label">Token *</label>
                        <select class="form-control" id="id_token" name="id_token" required>
                            <option value="">Seleccione un token</option>
                            <?php 
                            $tokens->execute(); // Reiniciar el cursor
                            while ($token = $tokens->fetch(PDO::FETCH_ASSOC)): 
                            ?>
                                <option value="<?php echo $token['id']; ?>" 
                                    <?php echo (isset($solicitud->id_token) && $solicitud->id_token == $token['id']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($token['token'] . ' - ' . $token['razon_social']); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="tipo" class="form-label">Tipo de Solicitud *</label>
                        <select class="form-control" id="tipo" name="tipo" required>
                            <option value="">Seleccione el tipo</option>
                            <option value="consulta" <?php echo (isset($solicitud->tipo) && $solicitud->tipo == 'consulta') ? 'selected' : ''; ?>>Consulta</option>
                            <option value="registro" <?php echo (isset($solicitud->tipo) && $solicitud->tipo == 'registro') ? 'selected' : ''; ?>>Registro</option>
                            <option value="actualizacion" <?php echo (isset($solicitud->tipo) && $solicitud->tipo == 'actualizacion') ? 'selected' : ''; ?>>Actualización</option>
                            <option value="eliminacion" <?php echo (isset($solicitud->tipo) && $solicitud->tipo == 'eliminacion') ? 'selected' : ''; ?>>Eliminación</option>
                            <option value="autenticacion" <?php echo (isset($solicitud->tipo) && $solicitud->tipo == 'autenticacion') ? 'selected' : ''; ?>>Autenticación</option>
                        </select>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="index.php?action=count_request" class="btn btn-secondary me-md-2">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Actualizar Solicitud</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once '../views/layouts/footer.php'; ?>
<?php 
require_once '../views/layouts/header.php';
authCheck();
?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4>Editar Empresa</h4>
            </div>
            <div class="card-body">
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>

                <form method="POST">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre de la Empresa *</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" 
                                       value="<?php echo isset($empresa->nombre) ? htmlspecialchars($empresa->nombre) : ''; ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="ruc" class="form-label">RUC *</label>
                                <input type="text" class="form-control" id="ruc" name="ruc" 
                                       value="<?php echo isset($empresa->ruc) ? htmlspecialchars($empresa->ruc) : ''; ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="direccion" class="form-label">Dirección</label>
                        <textarea class="form-control" id="direccion" name="direccion" rows="3"><?php echo isset($empresa->direccion) ? htmlspecialchars($empresa->direccion) : ''; ?></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="text" class="form-control" id="telefono" name="telefono" 
                                       value="<?php echo isset($empresa->telefono) ? htmlspecialchars($empresa->telefono) : ''; ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" 
                                       value="<?php echo isset($empresa->email) ? htmlspecialchars($empresa->email) : ''; ?>">
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="index.php?action=empresas" class="btn btn-secondary me-md-2">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Actualizar Empresa</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once '../views/layouts/footer.php'; ?>
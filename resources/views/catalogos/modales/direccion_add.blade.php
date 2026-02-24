<div class="modal fade" id="addDireccionModal" tabindex="-1" aria-labelledby="addDireccionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="addDireccionModalLabel">Nueva Dirección</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addDireccionForm">
                    @csrf
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción *</label>
                        <input type="text" class="form-control" id="descripcion" name="descripcion" maxlength="150" required>
                        <div class="invalid-feedback" id="descripcionError"></div>
                        <small class="text-muted">Máximo 150 caracteres</small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="saveDireccionBtn">Guardar</button>
            </div>
        </div>
    </div>
</div>
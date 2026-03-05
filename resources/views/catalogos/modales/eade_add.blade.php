<div class="modal fade" id="addEadeModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title">Nuevo EADE</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form id="addEadeForm">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Descripción *</label>
                        <input type="text" class="form-control" name="descripcion" required>
                        <div class="invalid-feedback" id="descripcionError"></div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button class="btn btn-primary" id="saveEadeBtn">Guardar</button>
            </div>
        </div>
    </div>
</div>
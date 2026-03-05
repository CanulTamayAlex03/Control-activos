<div class="modal fade" id="editEadeModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title">Editar EAD</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form id="editEadeForm">
                    @csrf
                    @method('PUT')

                    <input type="hidden" id="edit_id">

                    <div class="mb-3">
                        <label class="form-label">Descripción *</label>
                        <input type="text" class="form-control" id="edit_descripcion" required>
                        <div class="invalid-feedback" id="editDescripcionError"></div>
                    </div>

                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="edit_active">
                        <label class="form-check-label">
                            <strong>Activo</strong>
                        </label>
                    </div>

                </form>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button class="btn btn-primary" id="updateEadeBtn">Guardar Cambios</button>
            </div>
        </div>
    </div>
</div>
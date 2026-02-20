<div class="modal fade" id="editEdificioModal" tabindex="-1" aria-labelledby="editEdificioModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="editEdificioModalLabel">Editar Edificio</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editEdificioForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_id" name="id">

                    <div class="mb-3">
                        <label for="edit_descripcion" class="form-label">Descripción *</label>
                        <input type="text" class="form-control" id="edit_descripcion" name="descripcion" required>
                        <div class="invalid-feedback" id="editDescripcionError"></div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch"
                                id="edit_active" name="active" value="1">
                            <label class="form-check-label" for="edit_active">
                                <strong>Activo</strong>
                            </label>
                        </div>
                        <div class="form-text">
                            <span id="statusHelp" class="text-muted">
                                <i class="bi bi-info-circle me-1"></i>
                                Desmarca para inactivar el edificio
                            </span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="updateEdificioBtn">Guardar Cambios</button>
            </div>
        </div>
    </div>
</div>
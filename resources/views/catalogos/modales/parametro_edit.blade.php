<div class="modal fade" id="editParametroModal" tabindex="-1" aria-labelledby="editParametroModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="editParametroModalLabel">Editar Parámetro de Firma</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editParametroForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_id" name="id">

                    <div class="mb-3">
                        <label for="edit_nombre_completo" class="form-label">Nombre Completo *</label>
                        <input type="text" class="form-control" id="edit_nombre_completo" name="nombre_completo" required>
                        <div class="invalid-feedback" id="editNombre_completoError"></div>
                    </div>

                    <div class="mb-3">
                        <label for="edit_descripcion" class="form-label">Descripción</label>
                        <textarea class="form-control" id="edit_descripcion" name="descripcion" rows="3"></textarea>
                        <div class="invalid-feedback" id="editDescripcionError"></div>
                    </div>

                    <div class="mb-3">
                        <label for="edit_formato" class="form-label">Formato</label>
                        <input type="text" class="form-control" id="edit_formato" name="formato">
                        <div class="invalid-feedback" id="editFormatoError"></div>
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
                                Desmarca para inactivar el parámetro
                            </span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="updateParametroBtn">Guardar Cambios</button>
            </div>
        </div>
    </div>
</div>
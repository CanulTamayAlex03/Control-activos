<div class="modal fade" id="editDepartamentoModal" tabindex="-1" aria-labelledby="editDepartamentoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="editDepartamentoModalLabel">Editar Departamento</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editDepartamentoForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_id" name="id">

                    <div class="mb-3">
                        <label for="edit_descripcion" class="form-label">Descripción *</label>
                        <input type="text" class="form-control" id="edit_descripcion" name="descripcion" maxlength="255" required>
                        <div class="invalid-feedback" id="editDescripcionError"></div>
                        <small class="text-muted">Máximo 255 caracteres</small>
                    </div>

                    <div class="mb-3">
                        <label for="edit_id_edif" class="form-label">Edificio</label>
                        <select class="form-select" id="edit_id_edif" name="id_edif">
                            <option value="">Seleccione un edificio</option>
                            @foreach($edificios as $edificio)
                            <option value="{{ $edificio->id }}">{{ $edificio->descripcion }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback" id="editId_edifError"></div>
                    </div>

                    <div class="mb-3">
                        <label for="edit_direccion_id" class="form-label">Dirección</label>
                        <select class="form-select" id="edit_direccion_id" name="direccion_id">
                            <option value="">Seleccione una dirección</option>
                            @foreach($direcciones as $direccion)
                            <option value="{{ $direccion->id }}">{{ $direccion->descripcion }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback" id="editDireccion_idError"></div>
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
                                Desmarca para inactivar el departamento
                            </span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="updateDepartamentoBtn">Guardar Cambios</button>
            </div>
        </div>
    </div>
</div>
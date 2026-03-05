<div class="modal fade" id="editUbrModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title">Editar UBR</h5>
                <button type="button"
                        class="btn-close btn-close-white"
                        data-bs-dismiss="modal">
                </button>
            </div>

            <div class="modal-body">
                <form id="editUbrForm">
                    @csrf
                    @method('PUT')

                    <input type="hidden" id="edit_id">

                    <div class="mb-3">
                        <label class="form-label">Descripción *</label>
                        <input type="text"
                               class="form-control"
                               id="edit_descripcion"
                               required>
                        <div class="invalid-feedback" id="editDescripcionError"></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Municipio *</label>
                        <select class="form-select"
                                id="edit_mun"
                                required>
                            <option value="">Seleccione...</option>
                            @foreach($municipios as $mun)
                                <option value="{{ $mun->id }}">
                                    {{ $mun->descripcion }}
                                </option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback" id="editMunicipioError"></div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input"
                                   type="checkbox"
                                   id="edit_active">
                            <label class="form-check-label">
                                <strong>Activo</strong>
                            </label>
                        </div>
                        <div class="form-text">
                            Desmarca para inactivar la UBR
                        </div>
                    </div>

                </form>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary"
                        data-bs-dismiss="modal">
                    Cancelar
                </button>
                <button class="btn btn-primary"
                        id="updateUbrBtn">
                    Guardar Cambios
                </button>
            </div>

        </div>
    </div>
</div>
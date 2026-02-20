<div class="modal fade" id="editEmpleadoModal" tabindex="-1" aria-labelledby="editEmpleadoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="editEmpleadoModalLabel">Editar Empleado</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editEmpleadoForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_id" name="id">

                    <div class="mb-3">
                        <label for="edit_nombre" class="form-label">Nombre *</label>
                        <input type="text" class="form-control" id="edit_nombre" name="nombre" required>
                        <div class="invalid-feedback" id="editNombreError"></div>
                    </div>

                    <div class="mb-3">
                        <label for="edit_no_nomi" class="form-label">Número de Nómina</label>
                        <input type="text" class="form-control" id="edit_no_nomi" name="no_nomi">
                        <div class="invalid-feedback" id="editNo_nomiError"></div>
                    </div>

                    <div class="mb-3">
                        <label for="edit_id_depto" class="form-label">Departamento</label>
                        <select class="form-select" id="edit_id_depto" name="id_depto">
                            <option value="">Seleccione un departamento</option>
                            @foreach($departamentos as $departamento)
                                <option value="{{ $departamento->id }}">{{ $departamento->descripcion }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback" id="editId_deptoError"></div>
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
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch"
                                id="edit_active" name="active" value="1" checked>
                            <label class="form-check-label" for="edit_active">
                                <strong>Activo</strong>
                            </label>
                        </div>
                        <div class="form-text">
                            <span id="statusHelp" class="text-muted">
                                <i class="bi bi-info-circle me-1"></i>
                                Desmarca para inactivar el empleado
                            </span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="updateEmpleadoBtn">Guardar Cambios</button>
            </div>
        </div>
    </div>
</div>
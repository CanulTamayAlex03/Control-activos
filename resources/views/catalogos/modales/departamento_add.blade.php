<div class="modal fade" id="addDepartamentoModal" tabindex="-1" aria-labelledby="addDepartamentoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="addDepartamentoModalLabel">Nuevo Departamento</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addDepartamentoForm">
                    @csrf
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción *</label>
                        <input type="text" class="form-control" id="descripcion" name="descripcion" maxlength="255" required>
                        <div class="invalid-feedback" id="descripcionError"></div>
                        <small class="text-muted">Máximo 255 caracteres</small>
                    </div>

                    <div class="mb-3">
                        <label for="id_edif" class="form-label">Edificio</label>
                        <select class="form-select" id="id_edif" name="id_edif">
                            <option value="">Seleccione un edificio</option>
                            @foreach($edificios as $edificio)
                            <option value="{{ $edificio->id }}">{{ $edificio->descripcion }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback" id="id_edifError"></div>
                    </div>

                    <div class="mb-3">
                        <label for="direccion_id" class="form-label">Dirección</label>
                        <select class="form-select" id="direccion_id" name="direccion_id">
                            <option value="">Seleccione una dirección</option>
                            @foreach($direcciones as $direccion)
                            <option value="{{ $direccion->id }}">{{ $direccion->descripcion }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback" id="direccion_idError"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="saveDepartamentoBtn">Guardar</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="addEmpleadoModal" tabindex="-1" aria-labelledby="addEmpleadoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="addEmpleadoModalLabel">Nuevo Empleado</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addEmpleadoForm">
                    @csrf
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre *</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                        <div class="invalid-feedback" id="nombreError"></div>
                    </div>

                    <div class="mb-3">
                        <label for="no_nomi" class="form-label">Número de Nómina</label>
                        <input type="text" class="form-control" id="no_nomi" name="no_nomi">
                        <div class="invalid-feedback" id="no_nomiError"></div>
                    </div>

                    <div class="mb-3">
                        <label for="id_depto" class="form-label">Departamento</label>
                        <select class="form-select" id="id_depto" name="id_depto">
                            <option value="">Seleccione un departamento</option>
                            @foreach($departamentos as $departamento)
                                <option value="{{ $departamento->id }}">{{ $departamento->descripcion }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback" id="id_deptoError"></div>
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
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="saveEmpleadoBtn">Guardar</button>
            </div>
        </div>
    </div>
</div>
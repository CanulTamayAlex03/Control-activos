<div class="modal fade" id="addUbrModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5>Nueva UBR</h5>
                <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form id="addUbrForm">
                    @csrf

                    <div class="mb-3">
                        <label>Descripción *</label>
                        <input type="text" name="descripcion" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Municipio *</label>
                        <select name="mun_id" class="form-select" required>
                            <option value="">Seleccione...</option>
                            @foreach($municipios as $mun)
                                <option value="{{ $mun->id }}">
                                    {{ $mun->descripcion }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button class="btn btn-primary" id="saveUbrBtn">Guardar</button>
            </div>
        </div>
    </div>
</div>
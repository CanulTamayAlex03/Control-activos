<div class="modal fade" id="modalRecibidoPor" tabindex="-1">
    <div class="modal-dialog">
        <form method="GET"
            action="{{ $activo ? route('activos.print.formato_baja', ['folio' => $activo->folio]) : '#' }}" target="_blank">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Parámetros del formato</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        
                        <strong>{{ $vobo->nombre_completo ?? '-' }}</strong><br>
                        <span class="text-muted">
                            Jefa de Depto. de Recursos Materiales, Control Vehicular y Almacén
                        </span>
                    </div>

                    <div class="mb-3">
                        <strong>{{ $elaboro->nombre_completo ?? '-' }}</strong><br>
                        <span class="text-muted">
                            Autorización Dirección Administrativa
                        </span>
                    </div>
                </div>

                <div class="modal-body">
                    <label class="form-label">Nombre de quien recibe</label>
                    <input type="text"
                        name="recibido_por"
                        id="recibido_por"
                        class="form-control"
                        placeholder="Ej. JUAN PÉREZ"
                        required>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                        Cancelar
                    </button>
                    <button type="submit" class="btn btn-success">
                        Generar Formato
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('recibido_por').addEventListener('input', function() {
        this.value = this.value.toUpperCase();
    });
</script>
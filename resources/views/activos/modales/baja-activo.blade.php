<div class="modal fade" id="modalConfirmarBaja" tabindex="-1" aria-labelledby="modalConfirmarBajaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="modalConfirmarBajaLabel">
                    <i class="fas fa-file-circle-minus me-2"></i>
                    Confirmar Baja de Activo
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            
            <div class="modal-body p-4">
                <div class="text-center mb-3">
                    <h6 class="fw-bold mb-2">¿Está seguro de dar de baja este activo?</h6>
                    <p class="text-muted mb-0">Esta acción no se puede deshacer</p>
                </div>

                <div class="bg-light rounded-3 p-3 mb-3">
                    <div class="d-flex align-items-center mb-2">
                        <i class="fas fa-box text-muted me-2" style="width: 20px;"></i>
                        <span class="fw-bold">{{ $activo->numero_inventario ?? 'N/A' }}</span>
                    </div>
                    <div class="d-flex align-items-center mb-2">
                        <i class="fas fa-tag text-muted me-2" style="width: 20px;"></i>
                        <span>{{ $activo->descripcion_corta ?? 'Sin descripción' }}</span>
                    </div>
                </div>

                <div class="mb-3 mt-3">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-user me-2 text-muted"></i>
                        Recibido por
                    </label>
                    <input type="text"
                        name="recibido_por"
                        id="recibido_por_modal"
                        form="formBajaActivo"
                        class="form-control"
                        style="text-transform: uppercase;"
                        placeholder="Ej. JUAN PÉREZ"
                        required>
                </div>
            </div>

            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>
                    Cancelar
                </button>
                <button type="button" class="btn btn-danger" id="btnConfirmarBaja">
                    <i class="fas fa-trash-alt me-2"></i>
                    Sí, dar de baja
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = new bootstrap.Modal(document.getElementById('modalConfirmarBaja'));
    const btnConfirmar = document.getElementById('btnConfirmarBaja');
    const formBaja = document.getElementById('formBajaActivo');

btnConfirmar.addEventListener('click', function() {

    const recibido = document.getElementById('recibido_por_modal');

    if (!recibido.value.trim()) {
        recibido.classList.add('is-invalid');
        recibido.focus();
        return;
    }

    recibido.value = recibido.value.toUpperCase();

    const formData = new FormData(formBaja);

    fetch(formBaja.action, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
        },
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            window.open(data.pdf_url, '_blank');

            location.reload();
        }
    });
});

    window.formBajaActivo = formBaja;
});
</script>
@endpush
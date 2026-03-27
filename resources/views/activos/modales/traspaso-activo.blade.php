{{-- Modal de Confirmación de Traspaso --}}
<div class="modal fade" id="modalConfirmarTraspaso" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-white text-dark">
                <h5 class="modal-title">
                    <i class="fas fa-exchange-alt me-2"></i>
                    Confirmar Traspaso
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            
            <div class="modal-body">
                <div class="text-center mb-3">
                    <i class="fas fa-exchange-alt fa-3x text-primary mb-3"></i>
                    <h6>¿Está seguro de realizar el traspaso?</h6>
                    <p class="text-muted small">Esta acción cambiará la ubicación del activo</p>
                </div>

                {{-- Información básica del activo --}}
                <div class="bg-light rounded p-3 mb-3">
                    <div class="mb-2">
                        <strong>Activo:</strong> {{ $activo->numero_inventario ?? 'N/A' }}
                    </div>
                    <div class="mb-2">
                        <strong>Descripción:</strong> {{ $activo->descripcion_corta ?? 'Sin descripción' }}
                    </div>
                    <div class="mb-2">
                        <strong>Departamento origen:</strong> 
                        {{ $activo->departamento->descripcion ?? 'NO ASIGNADO' }}
                    </div>
                    <div class="mb-2">
                        <strong>Departamento destino:</strong> 
                        <span id="destinoDepartamento">{{ $departamentoDestino->descripcion ?? 'No seleccionado' }}</span>
                    </div>
                    <div>
                        <strong>Empleado destino:</strong> 
                        <span id="destinoEmpleado">{{ $empleadoDestino->nombre ?? 'No seleccionado' }}</span>
                    </div>
                </div>

                {{-- Formulario oculto para enviar los datos --}}
                <form id="formTraspasoModal" action="{{ route('activos.traspasos.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="numero_inventario" value="{{ $activo->numero_inventario ?? '' }}">
                    <input type="hidden" name="empleado_id" id="modal_empleado_id">
                    <input type="hidden" name="departamento_id" id="modal_departamento_id">
                    <input type="hidden" name="edificio_id" id="modal_edificio_id">
                    <input type="hidden" name="fecha_traspaso" id="modal_fecha_traspaso">
                    <input type="hidden" name="motivo_traspaso" id="modal_motivo_traspaso">
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnConfirmarTraspaso">
                    <i class="fas fa-exchange-alt me-2"></i>Confirmar
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const modalElement = document.getElementById('modalConfirmarTraspaso');
    const modal = new bootstrap.Modal(modalElement);
    const btnConfirmar = document.getElementById('btnConfirmarTraspaso');
    const formModal = document.getElementById('formTraspasoModal');
    const formPrincipal = document.getElementById('formTraspaso');
    
    if (modalElement) {
        modalElement.addEventListener('show.bs.modal', function() {
            const empleado = document.querySelector('select[name="empleado_id"]');
            const depto = document.querySelector('select[name="departamento_id"]');
            const edificio = document.querySelector('select[name="edificio_id"]');
            const fecha = document.querySelector('input[name="fecha_traspaso"]');
            const motivo = document.querySelector('textarea[name="motivo_traspaso"]');
            
            if (empleado) {
                document.getElementById('modal_empleado_id').value = empleado.value;
                const textoEmpleado = empleado.options[empleado.selectedIndex]?.text || '';
                document.getElementById('destinoEmpleado').innerHTML = textoEmpleado.split(' - ')[0] || 'No seleccionado';
            }
            if (depto) {
                document.getElementById('modal_departamento_id').value = depto.value;
                const textoDepto = depto.options[depto.selectedIndex]?.text || '';
                document.getElementById('destinoDepartamento').innerHTML = textoDepto || 'No seleccionado';
            }
            if (edificio) document.getElementById('modal_edificio_id').value = edificio.value;
            if (fecha) document.getElementById('modal_fecha_traspaso').value = fecha.value;
            if (motivo) document.getElementById('modal_motivo_traspaso').value = motivo.value;
        });
    }
    
    if (btnConfirmar && formModal) {
        btnConfirmar.addEventListener('click', function() {
            btnConfirmar.disabled = true;
            btnConfirmar.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Procesando...';
            
            const formData = new FormData(formModal);
            
            fetch(formModal.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    modal.hide();
                    
                    if (data.pdf_url) {
                        window.open(data.pdf_url, '_blank');
                    }
                    
                    mostrarMensajeExito('¡Traspaso realizado con éxito!');
                    
                    setTimeout(() => {
                        window.location.href = window.location.pathname;
                    }, 2000);
                } else {
                    throw new Error(data.message || 'Error al procesar');
                }
            })
            .catch(error => {
                mostrarMensajeError(error.message);
                btnConfirmar.disabled = false;
                btnConfirmar.innerHTML = '<i class="fas fa-exchange-alt me-2"></i>Confirmar';
            });
        });
    }
    
    function mostrarMensajeExito(mensaje) {
        const alertHtml = `
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert" style="position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
                <div class="d-flex align-items-center">
                    <i class="fas fa-check-circle fa-2x me-3"></i>
                    <div class="flex-grow-1">
                        <h5 class="alert-heading mb-1">¡Éxito!</h5>
                        <p class="mb-0">${mensaje}</p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        `;
        
        document.body.insertAdjacentHTML('beforeend', alertHtml);
        
        setTimeout(() => {
            const alert = document.querySelector('.alert-success');
            if (alert) alert.remove();
        }, 3000);
    }
    
    function mostrarMensajeError(mensaje) {
        const alertHtml = `
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert" style="position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
                <div class="d-flex align-items-center">
                    <i class="fas fa-exclamation-circle fa-2x me-3"></i>
                    <div class="flex-grow-1">
                        <h5 class="alert-heading mb-1">¡Error!</h5>
                        <p class="mb-0">${mensaje}</p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        `;
        
        document.body.insertAdjacentHTML('beforeend', alertHtml);
        
        setTimeout(() => {
            const alert = document.querySelector('.alert-danger');
            if (alert) alert.remove();
        }, 5000);
    }
});
</script>
@endpush
@extends('layouts.app')

@section('content')
<div class="container py-4">

    <div class="d-flex align-items-center mb-4">
        <div>
            <h4 class="mb-1 fw-bold">Módulo de Activos Fijos</h4>
            <p class="text-muted mb-0">Traspasos múltiples de activos</p>
        </div>
    </div>

    @include('activos.partials.menu-movimientos')

    <ul class="nav nav-tabs custom-tabs mb-4" id="traspasoTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="empleado-tab" data-bs-toggle="tab" data-bs-target="#empleado" type="button" role="tab">
                <i class="fas fa-user me-2"></i>Traspaso Múltiple por Empleado
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="departamento-tab" data-bs-toggle="tab" data-bs-target="#departamento" type="button" role="tab">
                <i class="fas fa-building me-2"></i>Traspaso Múltiple por Departamento
            </button>
        </li>
    </ul>

    <div class="tab-content" id="traspasoTabContent">
        {{-- TAB 1: Traspaso por Empleado --}}
        <div class="tab-pane fade show active" id="empleado" role="tabpanel">
            @include('activos.partials.traspaso-empleado', ['empleados' => $empleados, 'departamentos' => $departamentos, 'edificios' => $edificios])
        </div>

        {{-- TAB 2: Traspaso por Departamento --}}
        <div class="tab-pane fade" id="departamento" role="tabpanel">
            @include('activos.partials.traspaso-departamento', ['empleados' => $empleados, 'departamentos' => $departamentos, 'edificios' => $edificios])
        </div>
    </div>
</div>
@endsection

@push('modals')
<div class="modal fade" id="modalConfirmarTraspasoMultiple" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-exchange-alt me-2"></i>
                    Configurar y confirmar traspaso múltiple
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Resumen del traspaso</strong>
                    <div id="resumenTraspaso" class="mt-2"></div>
                </div>

                <form id="formTraspasoModal">
                    @csrf
                    <input type="hidden" name="activos_ids" id="modalActivosIds">
                    <input type="hidden" name="origen_tipo" id="modalOrigenTipo">
                    <input type="hidden" name="origen_id" id="modalOrigenId">
                    <input type="hidden" name="destino_tipo" id="modalDestinoTipo">
                    <input type="hidden" name="destino_id" id="modalDestinoId">
                    
                    <div class="card border-0">
                        <div class="card-body">
                            <h6 class="fw-semibold mb-3">
                                <i class="fas fa-sliders-h me-2 text-info"></i>
                                Configuración del traspaso
                            </h6>
                            
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">
                                        <i class="fas fa-calendar-alt me-2 text-muted"></i>
                                        Fecha de traspaso *
                                    </label>
                                    <input type="date" name="fecha_traspaso" id="modalFechaTraspaso" class="form-control" value="{{ date('Y-m-d') }}" required>
                                </div>
                                
                                <div class="col-12">
                                    <label class="form-label fw-semibold">
                                        <i class="fas fa-comment me-2 text-muted"></i>
                                        Motivo del traspaso *
                                    </label>
                                    <textarea name="motivo_traspaso" id="modalMotivoTraspaso" class="form-control" rows="3" required placeholder="Describa el motivo del traspaso..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success" id="btnConfirmarTraspasoMultiple">
                    <i class="fas fa-check me-2"></i>Confirmar traspaso
                </button>
            </div>
        </div>
    </div>
</div>
@endpush

@push('styles')
<style>
    .custom-tabs {
        justify-content: center !important;
        border-bottom: none !important;
        gap: 0.75rem !important;

    }
    .custom-tabs .nav-item {
    flex: 1;
    }
    .custom-tabs .nav-link {
        font-weight: 600 !important;
        padding: 0.75rem 1.8rem !important;
        color: #495057 !important;
        border: none !important;
        border-radius: 8px !important;
        transition: all 0.2s ease-in-out !important;
        background-color: #f8f9fa !important;
        width: 100%;
        text-align: center;
    }
    
    .custom-tabs .nav-link i {
        font-size: 1rem !important;
        margin-right: 0.5rem !important;
    }
    
    .custom-tabs .nav-link:hover:not(.active) {
        color: #0d6efd !important;
        background-color: #e7f1ff !important;
        transform: translateY(-1px) !important;
    }
    
    .custom-tabs .nav-link.active {
        background-color: #0d6efd !important;
        color: white !important;
        border: none !important;
        box-shadow: 0 2px 8px rgba(13, 110, 253, 0.3) !important;
    }
    
    .custom-tabs .nav-link.active i {
        color: white !important;
    }
    
    
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    $('.select2-empleado').select2({
        placeholder: "Buscar empleado...",
        allowClear: true,
        width: '100%'
    });
    $('.select2-departamento').select2({
        placeholder: "Buscar departamento...",
        allowClear: true,
        width: '100%'
    });
    $('.select2-edificio').select2({
        placeholder: "Buscar edificio...",
        allowClear: true,
        width: '100%'
    });
    $('#traspasoTabs').on('shown.bs.tab', function(e) {
        $('.select2-empleado, .select2-departamento, .select2-edificio').each(function() {
            if (!$(this).data('select2')) {
                $(this).select2({
                    placeholder: $(this).hasClass('select2-empleado') ? "Buscar empleado..." : 
                                ($(this).hasClass('select2-departamento') ? "Buscar departamento..." : "Buscar edificio..."),
                    allowClear: true,
                    width: '100%'
                });
            }
        });
    });

    function enviarTraspasoUnificado(formData) {
        $.ajax({
            url: '{{ route("activos.traspasos.multiples.store") }}',
            method: 'POST',
            data: formData,
            beforeSend: function() {
                $('#btnConfirmarTraspasoMultiple').prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Procesando...');
            },
            success: function(response) {
                if (response.success) {
                    let mensaje = `✓ Se traspasaron ${response.procesados} activos correctamente.`;
                    if (response.fallidos > 0) {
                        mensaje += `\n\n ${response.fallidos} activos no se pudieron traspasar:\n${response.errores.join('\n')}`;
                    }
                    alert(mensaje);
                    location.reload();
                } else {
                    alert('Error: ' + (response.message || 'Error al procesar el traspaso'));
                }
            },
            error: function(xhr) {
                let errorMsg = xhr.responseJSON?.message || 'Error al procesar el traspaso múltiple';
                alert('Error: ' + errorMsg);
            },
            complete: function() {
                $('#btnConfirmarTraspasoMultiple').prop('disabled', false).html('<i class="fas fa-check me-2"></i>Confirmar traspaso');
                $('#modalConfirmarTraspasoMultiple').modal('hide');
            }
        });
    }
    
        $('#btnConfirmarTraspasoMultiple').click(function() {
        let motivo = $('#modalMotivoTraspaso').val();
        if (!motivo.trim()) {
            alert('Debe ingresar un motivo para el traspaso');
            return;
        }

        let formData = {
            _token: $('input[name="_token"]').val(),
            activos_ids: $('#modalActivosIds').val(),
            origen_tipo: $('#modalOrigenTipo').val(),
            origen_id: $('#modalOrigenId').val(),
            destino_tipo: $('#modalDestinoTipo').val(),
            destino_id: $('#modalDestinoId').val(),
            fecha_traspaso: $('#modalFechaTraspaso').val(),
            motivo_traspaso: motivo
        };

        enviarTraspasoUnificado(formData);
    });
});
</script>
@endpush
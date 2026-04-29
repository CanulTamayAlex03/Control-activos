@extends('layouts.app')

@section('content')
{{-- TOAST DE NOTIFICACIONES --}}
<div class="position-fixed top-0 end-0 p-3" style="z-index: 99999; margin-top: 20px; margin-right: 20px;">
    <div id="toastNotificacion" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <i class="fas fa-bell me-2"></i>
            <strong class="me-auto">Notificación</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
        </div>
        <div class="toast-body">
            <div id="toastMensaje"></div>
            <div id="toastErrores" style="display: none;">
                <hr class="my-2">
                <strong><i class="fas fa-exclamation-circle me-2 text-danger"></i>Errores:</strong>
                <ul id="toastListaErrores" class="mt-2 mb-0"></ul>
            </div>
        </div>
    </div>
</div>

<div class="container py-4">

    <div class="d-flex align-items-center mb-4">
        <div>
            <h4 class="mb-1 fw-bold">Módulo de Activos Fijos</h4>
            <p class="text-muted mb-0">Gestión de traspasos de activos</p>
        </div>
    </div>

    @include('activos.partials.menu-movimientos')

    {{-- NOTA: Los mensajes de sesión ahora se muestran en el toast también --}}
    @if(session('success') && isset($activo) && $activo->fecha_traspaso)
    <script>
        $(document).ready(function() {
            setTimeout(function() {
                mostrarToast("{{ session('success') }}", 'success');
                @if(isset($activo) && $activo->folio)
                if(confirm('¿Desea descargar el formato de traspaso en PDF?')) {
                    window.open('{{ route("print.formato_traspaso", $activo->folio) }}', '_blank');
                }
                @endif
            }, 500);
        });
    </script>
    @endif

    @if(session('error'))
    <script>
        $(document).ready(function() {
            mostrarToast("{{ session('error') }}", 'error');
        });
    </script>
    @endif

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('activos.traspasos.index') }}" id="formBusquedaActivo">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <select class="form-select" 
                                id="buscarActivo" 
                                name="search"
                                style="width: 100%;">
                            @if(request('search') && $activo)
                                <option value="{{ $activo->numero_inventario }}" selected>
                                    {{ $activo->numero_inventario }} - {{ $activo->descripcion_corta }}
                                </option>
                            @endif
                        </select>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search me-2"></i>Buscar
                        </button>
                    </div>
                    @if(request('search'))
                    <div class="col-auto">
                        <a href="{{ route('activos.traspasos.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-2"></i>Limpiar
                        </a>
                    </div>
                    @endif
                </div>
            </form>
        </div>
    </div>

    @if(!request('search'))
    <div class="text-center py-5">
        <div class="mb-3">
            <i class="fas fa-arrow-up fa-4x text-muted opacity-50"></i>
        </div>
        <h5 class="text-muted mb-2">Buscar activo</h5>
        <p class="text-muted">Ingrese un número de inventario para comenzar</p>
    </div>
    @elseif(!$activo)
    <div class="text-center py-5">
        <div class="mb-3">
            <i class="fas fa-search fa-4x text-muted opacity-50"></i>
        </div>
        <h5 class="text-muted mb-2">Activo no encontrado</h5>
        <p class="text-muted">No existe un activo con el número de inventario "{{ request('search') }}".</p>
        <a href="{{ route('activos.traspasos.index') }}" class="btn btn-outline-primary mt-3">
            <i class="fas fa-arrow-left me-2"></i>Realizar nueva búsqueda
        </a>
    </div>
    @elseif($activo->fecha_baja)
    <div class="card border-0 shadow-lg">
        <div class="card-body text-center py-5">
            <div class="mb-3">
                <i class="fas fa-ban fa-4x text-danger opacity-75"></i>
            </div>
            <h5 class="text-danger mb-2">Activo dado de baja</h5>
            <p class="text-muted mb-3">
                El activo <strong>{{ $activo->numero_inventario }}</strong> fue dado de baja el 
                <strong>{{ \Carbon\Carbon::parse($activo->fecha_baja)->format('d/m/Y') }}</strong> <br>
                <strong>Motivo:</strong> {{ $activo->motivo_baja }}
            </p>
            <p class="text-muted">Los activos dados de baja no pueden ser traspasados.</p>
            <a href="{{ route('activos.traspasos.index') }}" class="btn btn-outline-primary mt-2">
                <i class="fas fa-arrow-left me-2"></i>Realizar nueva búsqueda
            </a>
        </div>
    </div>
    @else
    <div class="card shadow-lg">
        <div class="card-body">

        <div class="bg-light p-3 rounded mb-4">
                <div class="row align-items-center mb-3">
                    <div class="col">
                        <h5 class="mb-1">{{ $activo->numero_inventario }}</h5>
                        <p class="mb-0 text-muted">{{ $activo->descripcion_corta }}</p>
                    </div>
                    <div class="col-auto">
                        <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">
                            <i class="fas fa-check-circle me-1"></i>Activo
                        </span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-2">
                        <small class="text-muted d-block">Empleado actual:</small>
                        <strong>{{ $activo->empleado->nombre ?? '-' }}</strong>
                    </div>

                    @if(empty($activo->empleado?->nombre))
                        <div class="col-md-4 mb-2">
                            <small class="text-muted d-block">Empleado Sist. Anterior:</small>
                            <strong>{{ $activo->empleado_old ?? '-' }}</strong>
                        </div>
                    @endif
                    <div class="col-md-4 mb-2">
                        <small class="text-muted d-block">Departamento:</small>
                        <strong>{{ $activo->departamento->descripcion ?? 'No asignado' }}</strong>
                    </div>

                    <div class="col-md-4 mb-2">
                        <small class="text-muted d-block">Edificio:</small>
                        <strong>{{ $activo->edificio->descripcion ?? 'No asignado' }}</strong>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('activos.traspasos.store') }}" id="formTraspaso">
                @csrf
                <input type="hidden" name="numero_inventario" value="{{ $activo->numero_inventario }}">

                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-user me-2 text-muted"></i>
                            Empleado destino *
                        </label>
                        <select name="empleado_id" class="form-select select2" id="empleadoSelect" required>
                            <option value="">Seleccione un empleado...</option>
                            @foreach($empleados as $emp)
                                <option value="{{ $emp->id }}"
                                    data-departamento="{{ $emp->id_depto }}"
                                    data-edificio="{{ $emp->id_edif }}">
                                    
                                    {{ $emp->nombre }} - {{ $emp->no_nomi }}
                                </option>
                            @endforeach
                        </select>
                        <div class="form-text text-muted">
                            <i class="fas fa-info-circle me-1"></i>
                            Seleccione un empleado diferente al actual
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-building me-2 text-muted"></i>
                            Departamento *
                        </label>
                        <select name="departamento_id" id="departamentoSelect" class="form-select select2" required>
                            <option value="">Seleccione un departamento...</option>
                            @foreach($departamentos as $dep)
                                <option value="{{ $dep->id }}" {{ $activo->departamento_id == $dep->id ? 'selected' : '' }}>
                                    {{ $dep->descripcion }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-home me-2 text-muted"></i>
                            Edificio *
                        </label>
                        <select name="edificio_id" id="edificioSelect" class="form-select select2" required>
                            <option value="">Seleccione un edificio...</option>
                            @foreach($edificios as $edi)
                                <option value="{{ $edi->id }}" {{ $activo->edificio_id == $edi->id ? 'selected' : '' }}>
                                    {{ $edi->descripcion }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-calendar-alt me-2 text-muted"></i>
                            Fecha de traspaso *
                        </label>
                        <input type="date" name="fecha_traspaso" class="form-control"
                               value="{{ date('Y-m-d') }}" required>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-comment-alt me-2 text-muted"></i>
                            Motivo del traspaso *
                        </label>
                        <textarea name="motivo_traspaso" class="form-control"
                                  rows="3" placeholder="Describa el motivo del traspaso..." required></textarea>
                    </div>

                </div>

                <div class="mt-4 pt-3 border-top d-flex justify-content-between align-items-center">
                    <div id="btnHistorialContainer" style="display: none;">
                        <button type="button" 
                                class="btn btn-secondary"
                                data-bs-toggle="modal" 
                                data-bs-target="#modalHistorialTraspasos">
                            <i class="fas fa-history me-2"></i>
                            historial de traspasos
                        </button>
                    </div>
                    
                    <div class="d-flex gap-2">
                        <a href="{{ route('activos.traspasos.index') }}" class="btn btn-light px-4">
                            <i class="fas fa-times me-2"></i>
                            Cancelar
                        </a>
                        @can('traspasos individuales')
                        <button type="button" 
                                class="btn btn-primary px-5" 
                                id="btnRealizarTraspaso">
                            <i class="fas fa-exchange-alt me-2"></i>
                            Realizar traspaso
                        </button>
                        @endcan
                    </div>
                </div>

            </form>

        </div>
    </div>
    @endif

</div>
@endsection

@push('modals')
@include('activos.modales.traspaso-activo')
@include('activos.modales.historial_traspasos-modal')

{{-- Modal de confirmación con toast --}}
<div class="modal fade" id="modalConfirmarTraspaso" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-exchange-alt me-2"></i>
                    Confirmar traspaso
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    ¿Está seguro de realizar este traspaso?
                </div>
                <p class="mb-0">Revise que los datos sean correctos antes de confirmar.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnConfirmarTraspasoModal">
                    <i class="fas fa-check me-2"></i>Confirmar
                </button>
            </div>
        </div>
    </div>
</div>
@endpush

@push('scripts')
<script>
function mostrarToast(mensaje, tipo = 'success', errores = null) {
    const toast = $('#toastNotificacion');
    const toastMensaje = $('#toastMensaje');
    const toastErrores = $('#toastErrores');
    const toastListaErrores = $('#toastListaErrores');
    
    toast.css('z-index', '99999');
    toastMensaje.html('');
    toastListaErrores.empty();
    toastErrores.hide();
    toast.removeClass('toast-success toast-error toast-warning');
    
    if (tipo === 'success') {
        toast.addClass('toast-success');
        toastMensaje.html(`<i class="fas fa-check-circle me-2 text-success"></i>${mensaje}`);
    } else if (tipo === 'error') {
        toast.addClass('toast-error');
        toastMensaje.html(`<i class="fas fa-times-circle me-2 text-danger"></i>${mensaje}`);
    } else {
        toast.addClass('toast-warning');
        toastMensaje.html(`<i class="fas fa-exclamation-triangle me-2 text-warning"></i>${mensaje}`);
    }
    
    if (errores && errores.length > 0) {
        toastErrores.show();
        errores.forEach(error => {
            toastListaErrores.append(`<li><i class="fas fa-exclamation-circle me-2 text-danger"></i>${error}</li>`);
        });
    }
    
    const bsToast = new bootstrap.Toast(toast, { autohide: true, delay: 5000 });
    bsToast.show();
    
    setTimeout(() => {
        toast.css('z-index', '');
    }, 6000);
}

$(document).ready(function() {
    $('.select2').select2({
        placeholder: "Seleccione una opción",
        allowClear: true,
        width: '100%'
    });
    
    $('#buscarActivo').select2({
        placeholder: "Buscar por número de inventario o descripción...",
        allowClear: true,
        width: '100%',
        minimumInputLength: 2,
        language: {
            inputTooShort: function(args) {
                return "Ingrese al menos " + args.minimum + " caracteres";
            },
            searching: function() {
                return "Buscando...";
            },
            noResults: function() {
                return "No se encontraron activos";
            }
        },
        ajax: {
            url: '{{ route("activos.search") }}',
            dataType: 'json',
            delay: 300,
            data: function(params) {
                return {
                    search: params.term
                };
            },
            processResults: function(data) {
                return {
                    results: data.results
                };
            },
            cache: true
        }
    });
    
    $(document).on('select2:open', '#buscarActivo', function(e) {
        setTimeout(function() {
            document.querySelector('.select2-container--open .select2-search__field').focus();
        }, 10);
    });
    
    $('#buscarActivo').on('change', function() {
        if ($(this).val()) {
            $('#formBusquedaActivo').submit();
        }
    });
    
    $('#empleadoSelect').on('change', function () {
        let selected = $(this).find(':selected');
        let depto = selected.data('departamento');
        let edif = selected.data('edificio');
        
        if (depto) {
            $('#departamentoSelect').val(depto).trigger('change');
        }
        if (edif) {
            $('#edificioSelect').val(edif).trigger('change');
        }
    });

    $('#btnRealizarTraspaso').click(function() {
        const empleadoSelect = document.querySelector('select[name="empleado_id"]');
        const empleadoActual = {{ $activo->empleado_id ?? 0 }};
        
        if (!empleadoSelect || !empleadoSelect.value) {
            mostrarToast('Debe seleccionar un empleado destino para el traspaso.', 'warning');
            return;
        }

        if (empleadoSelect && parseInt(empleadoSelect.value) === empleadoActual) {
            mostrarToast('Debe seleccionar un empleado diferente al actual.', 'warning');
            return;
        }
        
        const motivo = $('textarea[name="motivo_traspaso"]').val().trim();
        if (!motivo) {
            mostrarToast('Debe ingresar un motivo para el traspaso.', 'warning');
            return;
        }
        
        const fecha = $('input[name="fecha_traspaso"]').val();
        if (!fecha) {
            mostrarToast('Debe seleccionar una fecha de traspaso.', 'warning');
            return;
        }
        
        $('#modalConfirmarTraspaso').modal('show');
    });
    
    $('#btnConfirmarTraspasoModal').click(function() {
        $('#modalConfirmarTraspaso').modal('hide');
        
        const form = document.getElementById('formTraspaso');
        const btnTraspaso = document.getElementById('btnRealizarTraspaso');
        
        btnTraspaso.disabled = true;
        btnTraspaso.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Procesando...';
        
        const formData = new FormData(form);
        
        $.ajax({
            url: form.action,
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    mostrarToast(response.message || 'Traspaso realizado exitosamente.', 'success');
                    
                    if (response.pdf_url) {
                        setTimeout(() => {
                            if (confirm('¿Desea descargar el formato de traspaso en PDF?')) {
                                window.open(response.pdf_url, '_blank');
                            }
                        }, 1000);
                    }
                    
                    setTimeout(() => {
                        if (confirm('¿Desea realizar otro traspaso?')) {
                            window.location.href = '{{ route("activos.traspasos.index") }}';
                        } else {
                            location.reload();
                        }
                    }, 2000);
                } else {
                    mostrarToast(response.message || 'Error al procesar el traspaso', 'error');
                    btnTraspaso.disabled = false;
                    btnTraspaso.innerHTML = '<i class="fas fa-exchange-alt me-2"></i>Realizar traspaso';
                }
            },
            error: function(xhr) {
                let errorMsg = xhr.responseJSON?.message || 'Error al procesar el traspaso';
                mostrarToast(errorMsg, 'error');
                btnTraspaso.disabled = false;
                btnTraspaso.innerHTML = '<i class="fas fa-exchange-alt me-2"></i>Realizar traspaso';
            }
        });
    });

    {{-- Historial de traspasos --}}
    @if(request('search') && $activo && !$activo->fecha_baja)
    const folioActivo = {{ $activo->folio }};
    
    $.ajax({
        url: '{{ route("activos.traspasos.activo.historial", ["folio" => $activo->folio]) }}',
        method: 'GET',
        success: function(response) {
            if (response.traspasos && response.traspasos.length > 0) {
                $('#btnHistorialContainer').show();
            }
        }
    });
    
    $('#modalHistorialTraspasos').on('show.bs.modal', function() {
        $('#modalActivoNombre').text('{{ $activo->numero_inventario }} - {{ $activo->descripcion_corta }}');
        
        $.ajax({
            url: '{{ route("activos.traspasos.activo.historial", ["folio" => $activo->folio]) }}',
            method: 'GET',
            success: function(response) {
                const tbody = $('#tablaHistorialTraspasos');
                tbody.empty();
                
                if (response.traspasos && response.traspasos.length > 0) {
                    response.traspasos.forEach(function(traspaso) {
                        tbody.append(`
                            <tr>
                                <td>${traspaso.fecha}</td>
                                <td>${traspaso.empleado_origen}</td>
                                <td>${traspaso.empleado_destino}</td>
                                <td>${traspaso.departamento_origen}</td>
                                <td>${traspaso.departamento_destino}</td>
                                <td>
                                    <a href="${traspaso.pdf_url}" target="_blank" class="btn btn-sm btn-danger">
                                        <i class="fas fa-file-pdf me-1"></i>
                                    </a>
                                 </td>
                             </tr>
                        `);
                    });
                } else {
                    tbody.append(`
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                <i class="fas fa-info-circle me-2"></i>
                                Este activo no tiene traspasos registrados
                             </td>
                         </tr>
                    `);
                }
            },
            error: function() {
                const tbody = $('#tablaHistorialTraspasos');
                tbody.empty();
                tbody.append(`
                    <tr>
                        <td colspan="6" class="text-center py-4 text-danger">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            Error al cargar el historial
                         </td>
                     </tr>
                `);
            }
        });
    });
    @endif
});
</script>
@endpush

@push('styles')
<style>
    .nav-tabs .nav-link {
        transition: all 0.2s ease;
    }
    
    .nav-tabs .nav-link:not(.active) {
        color: #6c757d;
    }
    
    .form-control:focus,
    .form-select:focus,
    .btn:focus {
        box-shadow: none;
        border-color: #86b7fe;
    }
    
    .card {
        transition: all 0.2s ease;
    }
    
    .bg-opacity-10 {
        --bs-bg-opacity: 0.1;
    }
    
    .list-group-item {
        transition: all 0.2s ease;
    }
    
    .list-group-item:hover {
        background-color: #f8f9fa;
    }

    #modalHistorialTraspasos .modal-body {
        max-height: 60vh;
        overflow-y: auto;
    }
    
    #modalHistorialTraspasos .modal-body::-webkit-scrollbar {
        width: 8px;
    }
    
    #modalHistorialTraspasos .modal-body::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    
    #modalHistorialTraspasos .modal-body::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 10px;
    }
    
    #modalHistorialTraspasos .modal-body::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    .toast {
        min-width: 300px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, .2);
        border-radius: 8px;
    }

    .toast-success {
        border-left: 4px solid #28a745;
    }

    .toast-error {
        border-left: 4px solid #dc3545;
    }

    .toast-warning {
        border-left: 4px solid #ffc107;
    }
</style>
@endpush
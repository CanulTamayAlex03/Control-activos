@extends('layouts.app')

@section('content')
<div class="container py-4">

    <div class="d-flex align-items-center mb-4">
        <div>
            <h4 class="mb-1 fw-bold">Módulo de Activos Fijos</h4>
            <p class="text-muted mb-0">Gestión de traspasos de activos</p>
        </div>
    </div>

    @include('activos.partials.menu-movimientos')

    @if(session('success') && isset($activo) && $activo->fecha_traspaso)
    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
        <div class="d-flex align-items-center">
            <i class="fas fa-check-circle fa-2x me-3"></i>
            <div class="flex-grow-1">
                <h5 class="alert-heading mb-1">¡Traspaso realizado exitosamente!</h5>
                <p class="mb-0">{{ session('success') }}</p>
                <hr class="my-2">
                <div class="mt-2">
                    <a href="{{ route('print.formato_traspaso', $activo->folio) }}" target="_blank" class="btn btn-sm btn-success">
                        <i class="fas fa-file-pdf me-2"></i>Descargar formato de traspaso (PDF)
                    </a>
                    <a href="{{ route('activos.traspasos.index') }}" class="btn btn-sm btn-outline-secondary ms-2">
                        <i class="fas fa-search me-2"></i>Realizar otro traspaso
                    </a>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
    @endif

    {{-- mensajes de error --}}
    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
        <div class="d-flex align-items-center">
            <i class="fas fa-exclamation-circle fa-2x me-3"></i>
            <div class="flex-grow-1">
                <h5 class="alert-heading mb-1">¡Error!</h5>
                <p class="mb-0">{{ session('error') }}</p>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
    @endif

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('activos.traspasos.index') }}">
                <div class="input-group">
                    <input type="text" 
                           name="search" 
                           class="form-control"
                           placeholder="Buscar por número de inventario..."
                           value="{{ request('search') }}">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search me-2"></i>Buscar
                    </button>
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

                <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                    <a href="{{ route('activos.traspasos.index') }}" class="btn btn-light px-4">
                        <i class="fas fa-times me-2"></i>
                        Cancelar
                    </a>
                    <button type="button" 
                            class="btn btn-primary px-5" 
                            id="btnRealizarTraspaso"
                            data-bs-toggle="modal" 
                            data-bs-target="#modalConfirmarTraspaso">
                        <i class="fas fa-exchange-alt me-2"></i>
                        Realizar traspaso
                    </button>
                </div>

            </form>

        </div>
    </div>
    @endif

</div>
@endsection

@push('modals')
@include('activos.modales.traspaso-activo')
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('formTraspaso');
        const btnTraspaso = document.getElementById('btnRealizarTraspaso');
        
        if (form && btnTraspaso) {
            form.addEventListener('submit', function(e) {
                const empleadoSelect = document.querySelector('select[name="empleado_id"]');
                const empleadoActual = {{ $activo->empleado_id ?? 0 }};
                
                if (empleadoSelect && parseInt(empleadoSelect.value) === empleadoActual) {
                    e.preventDefault();
                    alert('Debe seleccionar un empleado diferente al actual.');
                    return false;
                }
                
                if (!confirm('¿Está seguro de realizar este traspaso? Esta acción registrará el movimiento en el historial.')) {
                    e.preventDefault();
                    return false;
                }
                
                btnTraspaso.disabled = true;
                btnTraspaso.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Procesando...';
            });
        }
    });

    document.addEventListener('DOMContentLoaded', function () {

    $('.select2').select2({
        placeholder: "Seleccione una opción",
        allowClear: true,
        width: '100%'
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
</style>
@endpush
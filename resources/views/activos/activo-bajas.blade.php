@extends('layouts.app')

@section('content')
<div class="container py-4">
    {{-- Header --}}
    <div class="d-flex align-items-center mb-4">
        <div>
            <h4 class="mb-1 fw-bold">Módulo de Activos Fijos</h4>
            <p class="text-muted mb-0">Gestión de movimientos y bajas de activos</p>
        </div>
    </div>

    {{-- Menú de navegación --}}
    @include('activos.partials.menu-movimientos')

    {{-- Barra de búsqueda --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('activos.bajas.index') }}">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input type="text"
                        name="search"
                        class="form-control border-start-0 ps-0"
                        placeholder="Buscar por número de inventario..."
                        value="{{ request('search') }}">
                    <button class="btn btn-primary" type="submit">
                        Buscar
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if($activo)
    <div class="card border-0 shadow-lg">
        <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-semibold">
                    <i class="fas fa-box me-2 text-dark"></i>
                    Información del Activo
                </h5>
                <span class="badge bg-{{ $activo->fecha_baja ? 'danger' : 'success' }} bg-opacity-10 text-{{ $activo->fecha_baja ? 'danger' : 'success' }} px-3 py-2 rounded-pill">
                    <i class="fas fa-{{ $activo->fecha_baja ? 'times-circle' : 'check-circle' }} me-1"></i>
                    {{ $activo->fecha_baja ? 'Dado de baja' : 'Activo' }}
                </span>
            </div>
        </div>

        <div class="card-body p-4">
            <div class="bg-light rounded-3 p-3 mb-4">

                <div class="mb-3 text-center">
                    <div class="fw-bold fs-4">
                        {{ $activo->numero_inventario }}
                    </div>
                    <div class="fs-5">
                        {{ $activo->descripcion_corta }}
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-6">
                        <small class="info-label">Rubro:</small><br>
                        <span>{{ $activo->rubro->descripcion ?? '-' }}</span>
                    </div>
                </div>

                <div class="mt-3">
                    <small class="text-muted d-block mb-2"><strong>Asignación</strong></small>

                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <small class="info-label">Empleado:</small><br>
                            <span>{{ $activo->empleado->no_nomi ?? '-' }}</span>
                        </div>

                        <div class="col-md-6 mb-2">
                            <small class="info-label">Empleado Sist. anterior:</small><br>
                            <span>{{ $activo->empleado_old ?? '-' }}</span>
                        </div>

                        <div class="col-md-6 mb-2">
                            <small class="info-label">Departamento:</small><br>
                            <span>{{ $activo->departamento->descripcion ?? '-' }}</span>
                        </div>

                        <div class="col-md-6 mb-2">
                            <small class="info-label">Fecha:</small><br>
                            <span>
                                {{ $activo->fecha_asignacion ? $activo->fecha_asignacion->format('d/m/Y') : '-' }}
                            </span>
                        </div>
                    </div>
                </div>

            </div>

            @if($activo->fecha_baja)
            <div class="alert alert-danger bg-danger bg-opacity-10 border-0 d-flex align-items-center justify-content-between" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-exclamation-circle fs-4 me-3"></i>
                    <div>
                        <strong>Activo dado de baja</strong><br>
                        Fecha: {{ \Carbon\Carbon::parse($activo->fecha_baja)->format('d/m/Y') }} - Motivo: {{ $activo->motivo_baja }}
                    </div>
                </div>
            </div>
            <div class="text-end">
                <button type="button"
                    class="btn btn-success btn-sm"
                    data-bs-toggle="modal"
                    data-bs-target="#modalRecibidoPor">
                    <i class="fas fa-file-pdf me-2"></i>
                    Formato de Baja
                </button>
            </div>
            @else
            <form method="POST"
                action="{{ route('activos.bajas.store') }}"
                class="mt-3"
                id="formBajaActivo">
                @csrf
                <input type="hidden" name="numero_inventario" value="{{ $activo->numero_inventario }}">

                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-calendar-alt me-2 text-muted"></i>
                            Fecha de baja
                        </label>
                        <input type="date"
                            id="fecha_baja"
                            name="fecha_baja"
                            class="form-control form-control-lg"
                            value="{{ date('Y-m-d') }}"
                            max="{{ date('Y-m-d') }}"
                            required>
                        <div class="form-text text-muted">
                            <i class="fas fa-info-circle me-1"></i>
                            La fecha no puede ser superior a hoy
                        </div>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-comment-alt me-2 text-muted"></i>
                            Motivo de baja
                        </label>
                        <textarea name="motivo_baja"
                            id="motivo_baja"
                            class="form-control"
                            rows="4"
                            placeholder="Describa el motivo de la baja del activo..."
                            required></textarea>
                    </div>

                    <div class="col-12 mt-4">
                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('activos.bajas.index') }}" class="btn btn-light px-4">
                                <i class="fas fa-times me-2"></i>
                                Cancelar
                            </a>
                            <button type="button"
                                id="btnDarBaja"
                                class="btn btn-danger px-5"
                                data-bs-toggle="modal"
                                data-bs-target="#modalConfirmarBaja"
                                disabled>
                                <i class="fas fa-trash-alt me-2"></i>
                                Dar de baja
                            </button>
                        </div>
                    </div>
                </div>
            </form>
            @endif
        </div>
    </div>
    @elseif(request('search'))
    <div class="text-center py-5">
        <div class="mb-3">
            <i class="fas fa-search fa-4x text-muted opacity-50"></i>
        </div>
        <h5 class="text-muted mb-2">Activo no encontrado</h5>
        <p class="text-muted">No existe un activo con el número de inventario proporcionado.</p>
    </div>
    @else
    <div class="text-center py-5">
        <div class="mb-3">
            <i class="fas fa-arrow-up fa-4x text-muted opacity-50"></i>
        </div>
        <h5 class="text-muted mb-2">Buscar activo</h5>
        <p class="text-muted">Ingrese un número de inventario para comenzar</p>
    </div>
    @endif
</div>
@endsection

@push('modals')
@include('activos.modales.baja-activo')
@include('activos.modales.baja-activo-recibidoPor')
@endpush

@push('styles')
<style>
    .nav-tabs .nav-link {
        transition: all 0.2s ease;
    }

    .nav-tabs .nav-link.active {
        color: #0d6efd;
    }

    .nav-tabs .nav-link:not(.active) {
        color: #6c757d;
    }

    .form-control:focus,
    .btn:focus {
        box-shadow: none;
        border-color: #dee2e6;
    }

    .btn-light {
        background-color: #f8f9fa;
        border-color: #f8f9fa;
    }

    .btn-light:hover {
        background-color: #e9ecef;
        border-color: #e9ecef;
    }

    .card {
        transition: all 0.2s ease;
    }

    .bg-opacity-10 {
        --bs-bg-opacity: 0.1;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const fecha = document.getElementById('fecha_baja');
        const motivo = document.getElementById('motivo_baja');
        const boton = document.getElementById('btnDarBaja');

        function validarCampos() {
            if (fecha.value && motivo.value.trim() !== '') {
                boton.disabled = false;
            } else {
                boton.disabled = true;
            }
        }

        fecha.addEventListener('change', validarCampos);
        motivo.addEventListener('input', validarCampos);

        validarCampos();
    });
</script>
@endpush
@extends('layouts.app')

@section('content')
<div class="position-fixed top-0 end-0 p-3" style="z-index: 9999; margin-top: 20px; margin-right: 20px;">
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
            <p class="text-muted mb-0">Bajas múltiples de activos</p>
        </div>
    </div>

    @include('activos.partials.menu-movimientos')

    <ul class="nav nav-tabs custom-tabs mb-4" id="bajasTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="empleado-tab" data-bs-toggle="tab" data-bs-target="#empleado" type="button" role="tab">
                <i class="fas fa-user me-2"></i>Baja Múltiple por Empleado
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="departamento-tab" data-bs-toggle="tab" data-bs-target="#departamento" type="button" role="tab">
                <i class="fas fa-building me-2"></i>Baja Múltiple por Departamento
            </button>
        </li>
    </ul>

    <div class="tab-content" id="bajasTabContent">
        {{-- TAB 1: Bajas por Empleado --}}
        <div class="tab-pane fade show active" id="empleado" role="tabpanel">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-user me-2 text-muted"></i>
                                Seleccionar Empleado
                            </label>
                            <select class="form-control select2-empleado" id="empleado_id">
                                <option value="">Buscar empleado...</option>
                                @foreach($empleados as $empleado)
                                <option value="{{ $empleado->id }}" data-activos-count="{{ $empleado->activos_count }}">
                                    {{ $empleado->nombre }} - {{ $empleado->no_nomi ?? 'Sin nómina' }}
                                    ({{ $empleado->activos_count }} activos)
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- TAB 2: Bajas por Departamento --}}
        <div class="tab-pane fade" id="departamento" role="tabpanel">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-building me-2 text-muted"></i>
                                Seleccionar Departamento
                            </label>
                            <select class="form-control select2-departamento" id="departamento_id">
                                <option value="">Buscar departamento...</option>
                                @foreach($departamentos as $departamento)
                                <option value="{{ $departamento->id }}" data-activos-count="{{ $departamento->activos_count }}">
                                    {{ $departamento->descripcion }}
                                    ({{ $departamento->activos_count }} activos)
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mt-4" id="tablaActivosContainer" style="display: none;">
        <div class="card-header bg-white border-0 pt-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="d-flex align-items-center">
                    <h5 class="mb-0 fw-semibold">
                        <i class="fas fa-list me-2 text-muted"></i>
                        Activos disponibles
                    </h5>
                </div>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-sm btn-outline-secondary" id="btnToggleSeleccion">
                        <i class="fas fa-check-double me-1"></i>Seleccionar todos
                    </button>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text bg-white">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text"
                            id="buscadorActivos"
                            class="form-control"
                            placeholder="Buscar por número de inventario o descripción...">
                        <button class="btn btn-outline-secondary" type="button" id="btnLimpiarBusqueda">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div style="max-height: 400px; overflow-y: auto; border-radius: 0.5rem;">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light position-sticky top-0" style="z-index: 1;">
                            <tr>
                                <th width="50" style="background-color: #f8f9fa;">
                                    <input type="checkbox" id="select-all">
                                </th>
                                <th style="background-color: #f8f9fa;">No. Inventario</th>
                                <th style="background-color: #f8f9fa;">Descripción</th>
                                <th style="background-color: #f8f9fa;">Costo</th>
                                <th style="background-color: #f8f9fa;">Empleado</th>
                                <th style="background-color: #f8f9fa;">Departamento</th>
                                <th style="background-color: #f8f9fa;">Edificio</th>
                            </tr>
                        </thead>
                        <tbody id="activos-body">
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Seleccione un empleado o departamento para ver los activos
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Formulario de baja múltiple --}}
    <div class="card border-0 shadow-lg mt-4" id="formularioBajaContainer" style="display: none;">
        <div class="card-header bg-white border-0 pt-4">
            <h5 class="mb-0 fw-semibold">
                <i class="fas fa-file-circle-xmark me-2 text-dark"></i>
                Configurar Bajas Múltiples
            </h5>
        </div>
        <div class="card-body">
            <form id="formBajasMultiples">
                @csrf
                <input type="hidden" name="activos_ids" id="activosSeleccionados">
                <input type="hidden" name="origen_tipo" id="origenTipo">
                <input type="hidden" name="origen_id" id="origenId">

                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-calendar-alt me-2 text-muted"></i>
                            Fecha de baja *
                        </label>
                        <input type="date"
                            name="fecha_baja"
                            id="fechaBaja"
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
                            Motivo de baja *
                        </label>
                        <textarea name="motivo_baja"
                            id="motivoBaja"
                            class="form-control"
                            rows="4"
                            placeholder="Describa el motivo de la baja de los activos seleccionados..."
                            required></textarea>
                    </div>

                    <div class="col-12 mt-4">
                        <div class="d-flex gap-2 justify-content-end">
                            <button type="button" class="btn btn-light px-4" id="btnLimpiar">
                                <i class="fas fa-eraser me-2"></i>
                                Limpiar
                            </button>
                            <button type="button" class="btn btn-danger px-5" id="btnProcesarBajas" disabled>
                                <i class="fas fa-trash-alt me-2"></i>
                                Dar de baja seleccionados
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('modals')
{{-- Modal de confirmación --}}
<div class="modal fade" id="modalConfirmarBajasMultiples" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Confirmar bajas múltiples
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>¡Atención!</strong> Esta acción es irreversible.
                </div>

                <div class="mb-3">
                    <strong>Resumen de la operación:</strong>
                    <div id="resumenBajas" class="mt-2 p-3 bg-light rounded"></div>
                </div>

                <div class="mb-3">
                    <strong>Detalles de la baja:</strong>
                    <ul class="list-unstyled mt-2">
                        <li><i class="fas fa-calendar me-2 text-muted"></i> <strong>Fecha:</strong> <span id="resumenFecha"></span></li>
                        <li><i class="fas fa-comment me-2 text-muted"></i> <strong>Motivo:</strong> <span id="resumenMotivo"></span></li>
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="btnConfirmarBajas">
                    <i class="fas fa-check-circle me-2"></i>Confirmar bajas
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

    .table th,
    .table td {
        vertical-align: middle;
    }

    .select2-container--default .select2-selection--single {
        height: calc(3.5rem + 2px);
        padding: 0.75rem 1rem;
        font-size: 1rem;
        border-radius: 0.5rem;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 3.5rem;
    }

    .table-responsive::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }

    .table-responsive::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }

    .table-responsive::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 4px;
    }

    .table-responsive::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }

    .position-sticky {
        position: sticky !important;
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

@push('scripts')

@include('activos.scripts.bajas_multiples_script')

@endpush
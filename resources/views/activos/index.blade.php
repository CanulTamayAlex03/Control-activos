@extends('layouts.app')

@section('content')
<div class="container-fluid px-0">
<div class="row align-items-center mb-2 mx-0">
    <div class="col-md-8 px-0">
        <form action="{{ route('activos.index') }}" method="GET" class="d-flex">
            <input type="text" 
                   name="search" 
                   class="form-control form-control-sm rounded-0 rounded-start" 
                   placeholder="Buscar por folio o número de inventario..."
                   value="{{ request('search') }}"
                   id="search-input">
            <button type="submit" class="btn btn-sm btn-primary rounded-0 rounded-end">
                <i class="fas fa-search"></i>
            </button>
            @if(request('search'))
            <a href="{{ route('activos.index') }}" class="btn btn-sm btn-secondary ms-1">
                <i class="fas fa-times"></i>
            </a>
            @endif
        </form>
        @if(request('search') && (!$activo || !$activo->folio))
        <small class="text-danger mt-1 d-block">
            <i class="fas fa-exclamation-triangle me-1"></i>
            No se encontró un activo con folio o número de inventario "{{ request('search') }}"
        </small>
        @endif
    </div>
    <div class="col-md-4 text-end px-0 d-flex justify-content-end align-items-center">
        @can ('editar activos')
            @if($activo)
            <a href="{{ route('activos.edit', $activo->folio) }}" class="btn btn-warning btn-sm ms-2 me-2">
                <i class="fas fa-edit me-1"></i> Editar
            </a>
            @endif
        @endcan
        @can ('crear activos')
        <button type="button" 
                class="btn btn-success btn-sm me-2"
                data-bs-toggle="modal"
                data-bs-target="#tipoActivoModal">
            <i class="fas fa-plus me-1"></i> Nuevo
        </button>
        @endcan

        <span class="badge bg-light text-dark border small">
            <i class="fas fa-box me-1"></i>
            {{ $activo ? $activo->folio : '0' }}/{{ $totalActivos ?? '0' }}
        </span>
    </div>
</div>

    @if($activo)
    <div class="card border shadow-sm">
        <div class="card-header py-1 px-2 bg-light d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <h6 class="mb-0 me-3">
                    <i class="fas fa-cube me-1"></i>Ficha de Activo </h6>   
                    <strong>{{ $activo->numero_inventario }} </strong>
                    <span class="text-muted ms-2"> - {{ $activo->descripcion_corta }}</span>
                      
            </div>
         
            <div class="btn-group btn-group-sm">
                <button type="button" 
                        class="btn btn-sm btn-outline-primary" 
                        data-bs-toggle="modal" 
                        data-bs-target="#resguardoModal"
                        data-activo-id="{{ $activo->folio }}">
                    <i class="fas fa-file-pdf"></i> Resguardo
                </button>
                
                <a href="{{ route('activos.print.frm23', ['folio' => $activo->folio]) }}"
                   class="btn btn-outline-secondary btn-sm border"
                   target="_blank">
                   <i class="fas fa-file-pdf"></i> FRM23
                </a>
            </div>
        </div>
 
        <div class="card-body p-2">
            <div class="row g-3 align-items-stretch">
                <div class="col-md-6 d-flex">
                    <div class="section-card w-100">
                        <div class="section-header">
                            <h6 class="mb-0">
                                <i class="fas fa-info-circle me-2"></i>Información General
                            </h6>
                        </div>
                        <div class="section-body">
                            <div class="info-row">
                                <span class="info-label">Folio:</span>
                                <span class="info-value">
                                    <span class="badge bg-primary">{{ $activo->folio }}</span>
                                </span>
                            </div>
                            <div class="info-row">
                                <span class="info-label"># Inventario:</span>
                                <span class="info-value fw-bold">{{ $activo->numero_inventario }}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Descripción Corta:</span>
                                <span class="info-value">{{ $activo->descripcion_corta }}</span>
                            </div>
                            @if($activo->descripcion_larga)
                            <div class="info-row">
                                <span class="info-label">Descripción Larga:</span>
                                <span class="info-value text-muted">{{ $activo->descripcion_larga }}</span>
                            </div>
                            @endif
                            <div class="info-row">
                                <span class="info-label">Rubro:</span>
                                <span class="info-value">{{ $activo->rubro->descripcion ?? '-' }}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">SubRubro:</span>
                                <span class="info-value">{{ $activo->subrubro->descripcion ?? '-' }}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Clasificación:</span>
                                <span class="info-value">{{ $activo->clasificacion->descripcion ?? '-' }}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Estado del Bien:</span>
                                <span class="info-value">
                                    <span class="badge bg-warning text-dark">
                                        {{ $activo->estadoBien->descripcion ?? 'N/A' }}
                                    </span>
                                </span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Donación/Transferencia:</span>
                                <span class="info-value">
                                    @if($activo->es_donacion)
                                        <span class="badge bg-success">
                                            <i class="fas fa-check me-1"></i>Sí
                                        </span>
                                    @else
                                        <span class="badge bg-light text-dark">
                                            <i class="fas fa-times me-1"></i>No
                                        </span>
                                    @endif
                                </span>
                            </div>
                            
                            <div class="info-row">
                                <span class="info-label">Donante:</span>
                                <span class="info-value">{{ $activo->donante ?: '-' }}</span>
                            </div>
                            
                        </div>
                    </div>
                    
                </div>
                <div class="col-md-6 d-flex">
                    <div class="section-card w-100">
                        <div class="section-header">
                            <h6 class="mb-0">
                                <i class="fas fa-cogs me-2"></i>Características Físicas
                            </h6>
                        </div>
                        <div class="section-body">
                            <div class="info-row">
                                <span class="info-label">Marca:</span>
                                <span class="info-value">{{ $activo->marca ?: 'SIN MARCA' }}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Modelo:</span>
                                <span class="info-value">{{ $activo->modelo ?: 'SIN MODELO' }}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label"># Serie:</span>
                                <span class="info-value">{{ $activo->numero_serie ?: 'SIN SERIE' }}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Fecha Factura:</span>
                                <span class="info-value">
                                    {{ $activo->fecha_adquisicion ? $activo->fecha_adquisicion->format('d/m/Y') : '-' }}
                                </span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Fecha Registro:</span>
                                <span class="info-value">
                                    {{ $activo->fecha_registro? $activo->fecha_registro->format('d/m/Y') : '-' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 d-flex">
                    <div class="section-card w-100">
                        <div class="section-header">
                            <h6 class="mb-0">
                                <i class="fas fa-shopping-cart me-2"></i>Información de Compra y Almacén
                            </h6>
                        </div>
                        <div class="section-body">
                            <div class="info-row">
                                <span class="info-label">Proveedor:</span>
                                <span class="info-value">{{ $activo->proveedor->nomcorto ?? '-' }}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Costo:</span>
                                @php
                                    $esMayorIgualUMA = $valorUma && $activo->costo >= $valorUma;
                                @endphp
                                
                                <span class="info-value fw-bold {{ $esMayorIgualUMA ? 'text-success' : 'text-danger' }}">
                                    ${{ number_format($activo->costo, 2) }}
                                </span>
                                
                                @if($valorUma)
                                    <div class="small text-muted">
                                        Valor UMA: ${{ number_format($valorUma, 2) }}
                                    </div>
                                @endif
                            </div>
                            <div class="info-row">
                                <span class="info-label"># Factura:</span>
                                <span class="info-value">{{ $activo->numero_factura ?: '-' }}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label"># Pedido:</span>
                                <span class="info-value">{{ $activo->numero_pedido ?: '-' }}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Entrada Almacén:</span>
                                <span class="info-value">
                                    {{ $activo->entrada_almacen ? $activo->entrada_almacen->format('d/m/Y') : '-' }}
                                </span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Folio Entrada:</span>
                                <span class="info-value">
                                    {{ $activo->folio_entrada ?: '-' }}
                                </span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Salida Almacén:</span>
                                <span class="info-value">
                                    {{ $activo->salida_almacen ? $activo->salida_almacen->format('d/m/Y') : '-' }}
                                </span>
                            </div>
                            @if($activo->observaciones)
                            <div class="info-row">
                                <span class="info-label">Observaciones:</span>
                                <span class="info-value text-muted">{{ $activo->observaciones }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                    
                </div>
                <div class="col-md-6 d-flex">
                    <div class="section-card w-100">
                        <div class="section-header">
                            <h6 class="mb-0">
                                <i class="fas fa-map-marker-alt me-2"></i>Asignación y Ubicación
                            </h6>
                        </div>
                        <div class="section-body">
                            <div class="info-row">
                                <span class="info-label">Empleado:</span>
                                <span class="info-value">
                                    @if($activo->empleado)
                                        {{ $activo->empleado->nombre }}
                                        @if($activo->empleado->no_nomi)
                                            <div class="text-muted small">Nómina: {{ $activo->empleado->no_nomi }}</div>
                                        @endif
                                    @else
                                        <span class="text-muted">No asignado</span>
                                    @endif
                                </span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Fecha Asignación:</span>
                                <span class="info-value">
                                    {{ $activo->fecha_asignacion ? $activo->fecha_asignacion->format('d/m/Y') : '-' }}
                                </span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Edificio:</span>
                                <span class="info-value">{{ $activo->edificio->descripcion ?? '-' }}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Departamento:</span>
                                <span class="info-value">{{ $activo->departamento->descripcion ?? '-' }}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Dirección:</span>
                                <span class="info-value">{{ $activo->direccion->descripcion ?? '-' }}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">UBR:</span>
                                <span class="info-value">{{ $activo->ubr->descripcion ?? '-' }}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">EAD:</span>
                                <span class="info-value">{{ $activo->eade->descripcion ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="card-footer py-1 px-2 bg-light">
            <div class="row g-1 align-items-center justify-content-center">
                <div class="col-auto">
                    @if($primerActivo && $primerActivo->folio !== $activo->folio)
                    <a href="{{ route('activos.index', ['id' => $primerActivo->folio]) }}" 
                       class="btn btn-sm btn-outline-secondary px-2" title="Primer registro">
                        <i class="fas fa-step-backward"></i>
                    </a>
                    @else
                    <button class="btn btn-sm btn-outline-secondary px-2" disabled>
                        <i class="fas fa-step-backward"></i>
                    </button>
                    @endif
                </div>
                
                <div class="col-auto">
                    @if($activoAnterior)
                    <a href="{{ route('activos.index', ['id' => $activoAnterior->folio]) }}" 
                       class="btn btn-sm btn-outline-primary px-3" title="Anterior">
                        <i class="fas fa-chevron-left me-1"></i>Anterior
                    </a>
                    @else
                    <button class="btn btn-sm btn-outline-secondary px-3" disabled>
                        <i class="fas fa-chevron-left me-1"></i>Anterior
                    </button>
                    @endif
                </div>
                
                <div class="col-auto px-2">
                    <span class="text-muted small">
                        {{ $activo->folio }} de {{ $totalActivos }}
                    </span>
                </div>
                
                <div class="col-auto">
                    @if($activoSiguiente)
                    <a href="{{ route('activos.index', ['id' => $activoSiguiente->folio]) }}" 
                       class="btn btn-sm btn-outline-primary px-3" title="Siguiente">
                        Siguiente<i class="fas fa-chevron-right ms-1"></i>
                    </a>
                    @else
                    <button class="btn btn-sm btn-outline-secondary px-3" disabled>
                        Siguiente<i class="fas fa-chevron-right ms-1"></i>
                    </button>
                    @endif
                </div>
                
                <div class="col-auto">
                    @if($ultimoActivo && $ultimoActivo->folio !== $activo->folio)
                    <a href="{{ route('activos.index', ['id' => $ultimoActivo->folio]) }}" 
                       class="btn btn-sm btn-outline-secondary px-2" title="Último registro">
                        <i class="fas fa-step-forward"></i>
                    </a>
                    @else
                    <button class="btn btn-sm btn-outline-secondary px-2" disabled>
                        <i class="fas fa-step-forward"></i>
                    </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @else
    <!-- Mensaje cuando no hay activos -->
    <div class="text-center py-5 mt-5">
        <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
        <h5 class="text-muted">No hay activos registrados</h5>
        @can ('crear activos')
        <p class="text-muted mb-3">Comienza creando un nuevo activo</p>
        <button type="button" 
                class="btn btn-success"
                data-bs-toggle="modal"
                data-bs-target="#tipoActivoModal">
            <i class="fas fa-plus me-1"></i> Crear Primer Activo
        </button>
        @endcan
    </div>
    @endif
</div>

@if($activo)
@push('modals')
    @include('activos.modales.resguardo-modal')
    @include('activos.modales.tipo_activo-modal')
@endpush
@else
@push('modals')
    @include('activos.modales.tipo_activo-modal')
@endpush
@endif

<style>
    .container-fluid {
        font-size: 0.85rem;
    }
    
    .section-card {
        background: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 5px;
        overflow: hidden;
    }
    
    .section-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-bottom: 1px solid #dee2e6;
        padding: 0.4rem 0.75rem;
    }
    
    .section-header h6 {
        color: #495057;
        font-weight: 600;
    }
    
    .section-header i {
        color: #0d6efd;
    }
    
    .section-body {
        padding: 0.75rem;
    }
    
    .info-row {
        display: flex;
        align-items: baseline;
        margin-bottom: 0.35rem;
        line-height: 1.3;
    }
    
    .info-label {
        font-weight: 600;
        color: #495057;
        min-width: 140px;
        margin-right: 0.5rem;
        white-space: nowrap;
        font-size: 0.82rem;
    }
    
    .info-value {
        flex: 1;
        color: #212529;
        word-break: break-word;
        font-size: 0.82rem;
    }
    
    .badge {
        font-size: 0.7rem;
        font-weight: 500;
        padding: 0.2rem 0.4rem;
        border-radius: 3px;
    }
    
    .btn-sm {
        padding: 0.15rem 0.5rem;
        font-size: 0.75rem;
    }
    
    @media (max-width: 768px) {
        .info-label {
            min-width: 120px;
            font-size: 0.75rem;
        }
        
        .info-value {
            font-size: 0.75rem;
        }
        
        .section-body {
            padding: 0.5rem;
        }
    }
    
    .text-success {
        color: #198754 !important;
    }
    
    .text-muted {
        color: #6c757d !important;
    }
    
    .section-card {
        transition: all 0.2s ease;
    }
    
    .section-card:hover {
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .row.g-2 > div {
        border-right: 1px solid #f0f0f0;
    }
    
    .row.g-2 > div:last-child {
        border-right: none;
    }
    
    .section-header i {
        font-size: 0.9em;
    }
</style>

@section('scripts')
@include('activos.scripts.activos_index_script')
@endsection
@endsection
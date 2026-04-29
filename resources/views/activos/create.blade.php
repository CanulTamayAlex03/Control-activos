@extends('layouts.app')

@section('content')
<div class="container-fluid px-0">
    <div class="row align-items-center mb-2 mx-0">
        <div class="col-md-8 px-0">
            <h5 class="mb-0 text-secondary">
                <i class="fas fa-plus-circle me-2"></i>Nuevo Activo
            </h5>
        </div>
        <div class="col-md-4 text-end px-0">
            <a href="{{ route('activos.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i> Cancelar
            </a>
        </div>
    </div>
    <div class="card border shadow-sm">
        <div class="card-header py-1 px-2 bg-light">
            <h6 class="mb-0">
                <i class="fas fa-cube me-1"></i>Formulario de Registro
            </h6>
        </div>

        <form action="{{ route('activos.store') }}" method="POST">
            @csrf

            <div class="card-body p-2">
                @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>+
                    <strong>Por favor corrige los siguientes errores:</strong>
                    <ul class="mb-0 mt-1">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                <div class="section-card mb-1">
                    <div class="section-header">
                        <h6 class="mb-0">
                            <i class="fas fa-info-circle me-2"></i>Información General
                        </h6>
                    </div>
                    <div class="section-body">
                        <div class="row g-2">

                            <input type="hidden" name="tipo_activo" value="{{ $tipo }}">

                            <div class="col-md-6">
                                <div class="info-row">
                                    <label class="info-label"># Inventario:</label>
                                    <div class="info-value">
                                        <input type="text"
                                            class="form-control form-control-sm bg-light"
                                            value="{{ $siguienteNumeroInventario ?? 'No disponible' }}"
                                            readonly
                                            style="font-weight: bold; color: #212529;">
                                        <small class="text-muted">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Este número se asignará automáticamente al guardar
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="info-row">
                                    <label class="info-label" for="descripcion_corta">Descripción Corta:</label>
                                    <div class="info-value">
                                        <input type="text"
                                            name="descripcion_corta"
                                            id="descripcion_corta"
                                            class="form-control form-control-sm"
                                            value="{{ old('descripcion_corta') }}"
                                            required
                                            placeholder="Ej: Computadora de escritorio">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="info-row">
                                    <label class="info-label" for="descripcion_larga">Descripción Larga:</label>
                                    <div class="info-value">
                                        <textarea name="descripcion_larga"
                                            id="descripcion_larga"
                                            class="form-control form-control-sm"
                                            rows="2"
                                            placeholder="Descripción detallada del activo...">{{ old('descripcion_larga') }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="info-row">
                                    <label class="info-label" for="rubro_id">Rubro:</label>
                                    <div class="info-value">
                                        <select name="rubro_id"
                                            id="rubro_id"
                                            class="form-select form-select-sm"
                                            required>
                                            <option value="">Seleccionar...</option>
                                            @foreach($rubros as $rubro)
                                            <option value="{{ $rubro->id }}"
                                                {{ old('rubro_id') == $rubro->id ? 'selected' : '' }}>
                                                {{ $rubro->descripcion }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                        
                            <div class="col-md-4" id="subrubro-group" style="display:block;">
                                <div class="info-row">
                                    <label class="info-label" for="subrubro_id">Subrubro:</label>
                                    <div class="info-value">
                                        <select name="subrubro_id"
                                            id="subrubro_id"
                                            class="form-select form-select-sm">
                                            <option value="">Seleccionar...</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4" id="clasificacion-group" style="display:none;">
                                <div class="info-row">
                                    <label class="info-label" for="clasificacion_id">Clasificación:</label>
                                    <div class="info-value">
                                        <select name="clasificacion_id"
                                            id="clasificacion_id"
                                            class="form-select form-select-sm">
                                            <option value="">Seleccionar...</option>
                                            @foreach($clasificaciones as $clasificacion)
                                            <option value="{{ $clasificacion->id }}"
                                                {{ old('clasificacion_id') == $clasificacion->id ? 'selected' : '' }}>
                                                {{ $clasificacion->descripcion }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-row">
                                    <label class="info-label" for="estado_bien_id">Estado del Bien:</label>
                                    <div class="info-value">
                                        <select name="estado_bien_id"
                                            id="estado_bien_id"
                                            class="form-select form-select-sm"
                                            required>
                                            <option value="">Seleccionar...</option>
                                            @foreach($estadosBien as $estado)
                                            <option value="{{ $estado->id }}"
                                                {{ old('estado_bien_id') == $estado->id ? 'selected' : '' }}>
                                                {{ $estado->descripcion }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="info-row">
                                    <label class="info-label">Donación/Transferencia:</label>
                                    <div class="info-value">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input"
                                                type="radio"
                                                name="es_donacion"
                                                id="es_donacion_no"
                                                value="0"
                                                {{ old('es_donacion', 0) == 0 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="es_donacion_no">No</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input"
                                                type="radio"
                                                name="es_donacion"
                                                id="es_donacion_si"
                                                value="1"
                                                {{ old('es_donacion') == 1 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="es_donacion_si">Sí</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6" id="donante-field" style="display: {{ old('es_donacion') == 1 ? 'block' : 'none' }};">
                                <div class="info-row">
                                    <label class="info-label" for="donante">Donante:</label>
                                    <div class="info-value">
                                        <input type="text"
                                            name="donante"
                                            id="donante"
                                            class="form-control form-control-sm"
                                            value="{{ old('donante') }}"
                                            placeholder="Nombre del donante">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="section-card mb-1">
                    <div class="section-header">
                        <h6 class="mb-0">
                            <i class="fas fa-cogs me-2"></i>Características Físicas
                        </h6>
                    </div>
                    <div class="section-body">
                        <div class="row g-2">
                            <div class="col-md-4">
                                <div class="info-row">
                                    <label class="info-label" for="marca">Marca:</label>
                                    <div class="info-value">
                                        <input type="text"
                                            name="marca"
                                            id="marca"
                                            class="form-control form-control-sm"
                                            value="{{ old('marca') }}"
                                            placeholder="Ej: Dell, HP, etc.">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-row">
                                    <label class="info-label" for="modelo">Modelo:</label>
                                    <div class="info-value">
                                        <input type="text"
                                            name="modelo"
                                            id="modelo"
                                            class="form-control form-control-sm"
                                            value="{{ old('modelo') }}"
                                            placeholder="Ej: Optiplex 7010">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-row">
                                    <label class="info-label" for="numero_serie"># Serie:</label>
                                    <div class="info-value">
                                        <input type="text"
                                            name="numero_serie"
                                            id="numero_serie"
                                            class="form-control form-control-sm"
                                            value="{{ old('numero_serie') }}"
                                            placeholder="Número de serie">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="info-row">
                                    <label class="info-label" for="fecha_adquisicion">Fecha Adquisición:</label>
                                    <div class="info-value">
                                        <input type="date"
                                            name="fecha_adquisicion"
                                            id="fecha_adquisicion"
                                            class="form-control form-control-sm"
                                            value="{{ old('fecha_adquisicion') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-row">
                                    <label class="info-label" for="fecha_registro">Fecha Registro</label>
                                    <div class="info-value">
                                        <input type="date"
                                            name="fecha_registro"
                                            class="form-control form-control-sm"
                                            value="{{ old('fecha_registro') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="section-card mb-1">
                    <div class="section-header">
                        <h6 class="mb-0">
                            <i class="fas fa-shopping-cart me-2"></i>Información de Compra y Almacén
                        </h6>
                    </div>
                    <div class="section-body">
                        <div class="row g-2">
                            <div class="col-md-4">
                                <div class="info-row">
                                    <label class="info-label" for="proveedor_id">Proveedor:</label>
                                    <div class="info-value">
                                        <div class="input-group">
                                            <select name="proveedor_id"
                                                id="proveedor_id"
                                                class="form-select form-select-sm select2"
                                                style="width: 100%;">
                                                <option value="">Seleccionar...</option>
                                                @foreach($proveedores as $proveedor)
                                                <option value="{{ $proveedor->id }}"
                                                    {{ old('proveedor_id') == $proveedor->id ? 'selected' : '' }}>
                                                    {{ $proveedor->nomcorto }}
                                                </option>
                                                @endforeach
                                            </select>
                                            <button type="button" 
                                                class="btn btn-link text-success p-0 ms-1" 
                                                id="btnAddProveedor"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#addProveedorModal"
                                                title="Agregar nuevo proveedor"
                                                style="text-decoration: none; font-size: 1rem; font-size:small;">
                                                <i class="fas fa-plus-circle"></i>
                                                agregar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-row">
                                    <label class="info-label" for="costo">Costo:</label>
                                    <div class="info-value">
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text">$</span>
                                            <input type="number"
                                                name="costo"
                                                id="costo"
                                                class="form-control"
                                                value="{{ old('costo') }}"
                                                step="0.01"
                                                min="0"
                                                placeholder="0.00">
                                        </div>
                                        <div class="mt-1" id="uma-message">
                                            <small class="text-muted">
                                                <i class="fas fa-info-circle me-1"></i>
                                                Ingrese un costo
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-row">
                                    <label class="info-label" for="numero_factura"># Factura:</label>
                                    <div class="info-value">
                                        <input type="text"
                                            name="numero_factura"
                                            id="numero_factura"
                                            class="form-control form-control-sm"
                                            value="{{ old('numero_factura') }}"
                                            placeholder="Número de factura">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="info-row">
                                    <label class="info-label" for="numero_pedido"># Pedido:</label>
                                    <div class="info-value">
                                        <input type="text"
                                            name="numero_pedido"
                                            id="numero_pedido"
                                            class="form-control form-control-sm"
                                            value="{{ old('numero_pedido') }}"
                                            placeholder="Número de pedido">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-row">
                                    <label class="info-label" for="folio_entrada">Folio Entrada:</label>
                                    <div class="info-value">
                                        <input type="text"
                                            name="folio_entrada"
                                            id="folio_entrada"
                                            class="form-control form-control-sm"
                                            value="{{ old('folio_entrada') }}"
                                            placeholder="Ej: FE-2024-001">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-row">
                                    <label class="info-label" for="entrada_almacen">Entrada Almacén:</label>
                                    <div class="info-value">
                                        <input type="date"
                                            name="entrada_almacen"
                                            id="entrada_almacen"
                                            class="form-control form-control-sm"
                                            value="{{ old('entrada_almacen') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-row">
                                    <label class="info-label" for="folio_salida">Folio Salida:</label>
                                    <div class="info-value">
                                        <input type="text"
                                            name="folio_salida"
                                            id="folio_salida"
                                            class="form-control form-control-sm"
                                            value="{{ old('folio_salida') }}"
                                            placeholder="Ej: FS-2024-001">
        
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-row">
                                    <label class="info-label" for="salida_almacen">Salida Almacén:</label>
                                    <div class="info-value">
                                        <input type="date"
                                            name="salida_almacen"
                                            id="salida_almacen"
                                            class="form-control form-control-sm"
                                            value="{{ old('salida_almacen') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="info-row">
                                    <label class="info-label" for="observaciones">Observaciones:</label>
                                    <div class="info-value">
                                        <textarea name="observaciones"
                                            id="observaciones"
                                            class="form-control form-control-sm"
                                            rows="2">{{ old('observaciones') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="section-card">
                    <div class="section-header">
                        <h6 class="mb-0">
                            <i class="fas fa-map-marker-alt me-2"></i>Asignación y Ubicación
                        </h6>
                    </div>
                    <div class="section-body">
                        <div class="row g-2">
                            <div class="col-md-4">
                                <div class="info-row">
                                    <label class="info-label" for="empleado_id">Empleado:</label>
                                    <div class="info-value">
                                        <select name="empleado_id"
                                            id="empleado_id"
                                            class="form-select form-select-sm select2">
                                            <option value="">No asignado</option>
                                            @foreach($empleados as $empleado)
                                            <option value="{{ $empleado->id }}"
                                                {{ old('empleado_id') == $empleado->id ? 'selected' : '' }}>
                                                {{ $empleado->nombre }}
                                                @if($empleado->no_nomi)
                                                (Nómina: {{ $empleado->no_nomi }})
                                                @endif
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-row">
                                    <label class="info-label" for="fecha_asignacion">Fecha Asignación:</label>
                                    <div class="info-value">
                                        <input type="date"
                                            name="fecha_asignacion"
                                            id="fecha_asignacion"
                                            class="form-control form-control-sm"
                                            value="{{ old('fecha_asignacion') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-row">
                                    <label class="info-label" for="edificio_id">Edificio:</label>
                                    <div class="info-value">
                                        <select name="edificio_id"
                                            id="edificio_id"
                                            class="form-select form-select-sm select2">
                                            <option value="">Seleccionar...</option>
                                            @foreach($edificios as $edificio)
                                            <option value="{{ $edificio->id }}"
                                                {{ old('edificio_id') == $edificio->id ? 'selected' : '' }}>
                                                {{ $edificio->descripcion }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="info-row">
                                    <label class="info-label" for="departamento_id">Departamento:</label>
                                    <div class="info-value">
                                        <select name="departamento_id"
                                            id="departamento_id"
                                            class="form-select form-select-sm select2">
                                            <option value="">Seleccionar...</option>
                                            @foreach($departamentos as $departamento)
                                            <option value="{{ $departamento->id }}"
                                                {{ old('departamento_id') == $departamento->id ? 'selected' : '' }}>
                                                {{ $departamento->descripcion }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-row">
                                    <label class="info-label" for="direccion_id">Dirección:</label>
                                    <div class="info-value">
                                        <select name="direccion_id"
                                            id="direccion_id"
                                            class="form-select form-select-sm select2">
                                            <option value="">Seleccionar...</option>
                                            @foreach($direcciones as $direccion)
                                            <option value="{{ $direccion->id }}"
                                                {{ old('direccion_id') == $direccion->id ? 'selected' : '' }}>
                                                {{ $direccion->descripcion }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-row">
                                    <label class="info-label" for="ubr_id">UBR:</label>
                                    <div class="info-value">
                                        <select name="ubr_id"
                                            id="ubr_id"
                                            class="form-select form-select-sm select2">
                                            <option value="">Seleccionar...</option>
                                            @foreach($ubrs as $ubr)
                                            <option value="{{ $ubr->id }}"
                                                {{ old('ubr_id') == $ubr->id ? 'selected' : '' }}>
                                                {{ $ubr->descripcion }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="info-row">
                                    <label class="info-label" for="eade_id">EAD:</label>
                                    <div class="info-value">
                                        <select name="eade_id"
                                            id="eade_id"
                                            class="form-select form-select-sm select2">
                                            <option value="">Seleccionar...</option>
                                            @foreach($eades as $eade)
                                            <option value="{{ $eade->id }}"
                                                {{ old('eade_id') == $eade->id ? 'selected' : '' }}>
                                                {{ $eade->descripcion }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer py-1 px-2 bg-light">
                <div class="d-flex justify-content-between">
                    <button type="reset" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-redo me-1"></i> Limpiar
                    </button>
                    <div>
                        <a href="{{ route('activos.index') }}" class="btn btn-secondary btn-sm me-2">
                            <i class="fas fa-times me-1"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-success btn-sm">
                            <i class="fas fa-save me-1"></i> Guardar Activo
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
    .container-fluid {
        font-size: 0.85rem;
    }

    .section-card {
        background: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 5px;
        overflow: hidden;
        margin-bottom: 10px;
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

    .form-control-sm,
    .form-select-sm {
        font-size: 0.82rem;
        padding: 0.15rem 0.5rem;
    }

    .form-check-input {
        margin-top: 0.1rem;
    }

    .form-check-label {
        font-size: 0.82rem;
    }

    .alert {
        font-size: 0.82rem;
        padding: 0.5rem 1rem;
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

    input:read-only,
    textarea:read-only {
        background-color: #e9ecef !important;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }
</style>
@push('modals')
@include('catalogos.modales.proveedor_add')
@endpush

@section('scripts')
@include('activos.scripts.activos_create_script')

<script>
$(document).ready(function() {
    $('.select2').select2({
        placeholder: function(){
            return $(this).attr('data-placeholder') || 'Seleccionar...';
        },
        allowClear: true,
        width: '100%'
    });
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#saveProveedorBtn').on('click', function() {
        var $btn = $(this);
        var originalText = $btn.html();
        
        var nomcorto = $('#nomcorto').val();
        var telefono1 = $('#telefono1').val();
        if (!nomcorto) {
            alert('El campo Nombre Corto es requerido');
            $('#nomcorto').focus();
            return;
        }
        
        if (!telefono1) {
            alert('El campo Teléfono 1 es requerido');
            $('#telefono1').focus();
            return;
        }
        $btn.prop('disabled', true);
        $btn.html('<i class="fas fa-spinner fa-spin me-1"></i> Guardando...');
        
        var formData = $('#addProveedorForm').serialize();

        console.log('Enviando datos:', formData);

        $.ajax({
            url: '{{ route("catalogos.proveedores.store") }}',
            type: 'POST',
            data: formData,
            success: function(response) {
                console.log('Respuesta exitosa:', response);

                if (response.success) {

                    const modalElement = document.getElementById('addProveedorModal');
                    const modalInstance = bootstrap.Modal.getInstance(modalElement);

                    if (modalInstance) {
                        modalInstance.hide();
                    }
                    setTimeout(function () {
                        $('body').removeClass('modal-open');
                        $('.modal-backdrop').remove();
                    }, 300);

                    $('#addProveedorForm')[0].reset();
                    $('.is-invalid').removeClass('is-invalid');
                    $('.invalid-feedback').html('');
                    
                    var alertHtml = '<div class="alert alert-success alert-dismissible fade show" role="alert">' +
                        '<i class="fas fa-check-circle me-2"></i>' + response.message +
                        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                        '</div>';
                    $('.card-body').prepend(alertHtml);
                    
                    setTimeout(function() {
                        $('.alert').alert('close');
                    }, 3000);
                    
                    actualizarSelectProveedores();
                }
            },
            error: function(xhr) {
                console.error('Error en la petición:', xhr);
                
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    $('.invalid-feedback').html('');
                    $('.is-invalid').removeClass('is-invalid');

                    $.each(errors, function(field, messages) {
                        var input = $('#addProveedorForm [name="' + field + '"]');
                        input.addClass('is-invalid');
                        $('#' + field + 'Error').html(messages[0]);
                    });
                    
                    $('.is-invalid:first').focus();
                } else {
                    var errorMsg = 'Ocurrió un error al guardar. ';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg += xhr.responseJSON.message;
                    } else {
                        errorMsg += 'Revisa la consola para más detalles.';
                    }
                    alert(errorMsg);
                }
            },
            complete: function() {
                console.log('Petición completada');
                $btn.prop('disabled', false);
                $btn.html(originalText);
            }
        });
    });

    function actualizarSelectProveedores() {
        console.log('Actualizando select de proveedores...');
        
        $.ajax({
            url: '{{ route("catalogos.proveedores.select-list") }}',
            type: 'GET',
            dataType: 'json',
            success: function(proveedores) {
                console.log('Proveedores recibidos:', proveedores);
                
                var selectProveedor = $('#proveedor_id');
                var currentValue = selectProveedor.val();
                
                var selectedText = selectProveedor.find('option:selected').text();
                
                selectProveedor.empty();
                selectProveedor.append('<option value="">Seleccionar proveedor...</option>');
                
                if (proveedores && proveedores.length > 0) {
                    $.each(proveedores, function(index, proveedor) {
                        var optionText = proveedor.nomcorto;
                        if (proveedor.rfc) {
                            optionText += ' (' + proveedor.rfc + ')';
                        }
                        selectProveedor.append('<option value="' + proveedor.id + '">' + 
                            optionText + 
                            '</option>');
                    });
                }
                
                var nuevoProveedorId = null;
                if (proveedores && proveedores.length > 0) {
                    nuevoProveedorId = Math.max.apply(Math, proveedores.map(function(p) { return p.id; }));
                }
                
                console.log('Valor actual:', currentValue, 'Nuevo ID:', nuevoProveedorId);
                
                if (nuevoProveedorId && (!currentValue || nuevoProveedorId > parseInt(currentValue))) {
                    selectProveedor.val(nuevoProveedorId);
                    console.log('Seleccionando nuevo proveedor:', nuevoProveedorId); 
                } 
                else if (currentValue && selectProveedor.find('option[value="' + currentValue + '"]').length) {
                    selectProveedor.val(currentValue);
                }
                
                if (typeof selectProveedor.select2 === 'function') {
                    selectProveedor.trigger('change');
                }
                
                console.log('Select actualizado. Valor final:', selectProveedor.val()); 
            },
            error: function(xhr) {
                console.error('Error al actualizar proveedores:', xhr);
                console.error('Status:', xhr.status);
                console.error('Response:', xhr.responseText);
                
                var errorHtml = '<div class="alert alert-warning alert-dismissible fade show" role="alert">' +
                    '<i class="fas fa-exclamation-triangle me-2"></i>' +
                    'No se pudieron cargar los proveedores. Por favor, recarga la página para ver los cambios.' +
                    '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                    '</div>';
                $('.card-body').prepend(errorHtml);
            }
        });
    }

    $('#addProveedorModal').on('hidden.bs.modal', function() {
        console.log('Modal cerrado, limpiando formulario');
        $('#addProveedorForm')[0].reset();
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').html('');
        $('#nomcortoList').empty();
    });

    let searchTimeout;
    $(document).on('keyup', '#nomcorto', function() {
        let query = $(this).val();

        if (query.length < 2) {
            $('#nomcortoList').empty();
            return;
        }
        
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(function() {
            $.ajax({
                url: '{{ route("catalogos.proveedores.search") }}',
                data: {
                    q: query
                },
                success: function(data) {
                    let list = '';
                    if (data && data.length > 0) {
                        data.forEach(function(item) {
                            list += `<button type="button" class="list-group-item list-group-item-action">${item}</button>`;
                        });
                    } else {
                        list = '<div class="list-group-item text-muted">No se encontraron resultados</div>';
                    }
                    $('#nomcortoList').html(list);
                },
                error: function() {
                    $('#nomcortoList').html('<div class="list-group-item text-danger">Error al buscar</div>');
                }
            });
        }, 300);
    });

    $(document).on('click', '#nomcortoList button', function() {
        $('#nomcorto').val($(this).text());
        $('#nomcortoList').empty();
    });

    $(document).click(function(e) {
        if (!$(e.target).closest('#nomcorto').length) {
            $('#nomcortoList').empty();
        }
    });
    
    $('#addProveedorForm').on('keypress', function(e) {
        if (e.which === 13) {
            e.preventDefault();
            $('#saveProveedorBtn').click();
        }
    });
});
</script>
@endsection
@endsection
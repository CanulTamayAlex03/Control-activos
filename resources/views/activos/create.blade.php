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
            <a href="{{ route('dashboard') }}" class="btn btn-secondary btn-sm">
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
                <!-- Mensajes de error -->
                @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Por favor corrige los siguientes errores:</strong>
                    <ul class="mb-0 mt-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                <!-- Información General -->
                <div class="section-card mb-1">
                    <div class="section-header">
                        <h6 class="mb-0">
                            <i class="fas fa-info-circle me-2"></i>Información General
                        </h6>
                    </div>
                    <div class="section-body">
                        <div class="row g-2">

                            <div class="col-md-6">
                                <div class="info-row">
                                    <label class="info-label" for="numero_inventario"># Inventario:</label>
                                    <div class="info-value">
                                        <input type="text" 
                                               name="numero_inventario" 
                                               id="numero_inventario"
                                               class="form-control form-control-sm"
                                               value="{{ old('numero_inventario') }}"
                                               required
                                               placeholder="Ej: INV-2024-001">
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
                                    <label class="info-label" for="clasificacion_id">Clasificación:</label>
                                    <div class="info-value">
                                        <select name="clasificacion_id" 
                                                id="clasificacion_id"
                                                class="form-select form-select-sm"
                                                required>
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
                            <div class="col-md-4">
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

                <!-- Características Físicas -->
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
                                    <label class="info-label">Fecha Captura:</label>
                                    <div class="info-value">
                                        <input type="text" 
                                               class="form-control form-control-sm"
                                               value="{{ now()->format('d/m/Y') }}"
                                               readonly
                                               style="background-color: #e9ecef;">
                                        <small class="text-muted">Fecha actual del sistema</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Información de Compra y Almacén -->
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
                                        <select name="proveedor_id" 
                                                id="proveedor_id"
                                                class="form-select form-select-sm">
                                            <option value="">Seleccionar...</option>
                                            @foreach($proveedores as $proveedor)
                                                <option value="{{ $proveedor->id }}"
                                                    {{ old('proveedor_id') == $proveedor->id ? 'selected' : '' }}>
                                                    {{ $proveedor->nomcorto }}
                                                </option>
                                            @endforeach
                                        </select>
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

                <!-- Asignación y Ubicación -->
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
                                                class="form-select form-select-sm">
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
                                                class="form-select form-select-sm">
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
                                                class="form-select form-select-sm">
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
                                                class="form-select form-select-sm">
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
                                                class="form-select form-select-sm">
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
                                    <label class="info-label" for="eade_id">EADE:</label>
                                    <div class="info-value">
                                        <select name="eade_id" 
                                                id="eade_id"
                                                class="form-select form-select-sm">
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
                        <a href="{{ route('dashboard') }}" class="btn btn-secondary btn-sm me-2">
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
    
    .form-control-sm, .form-select-sm {
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
    
    input:read-only, textarea:read-only {
        background-color: #e9ecef !important;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }
</style>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mostrar/ocultar campo donante
        const esDonacionSi = document.getElementById('es_donacion_si');
        const esDonacionNo = document.getElementById('es_donacion_no');
        const donanteField = document.getElementById('donante-field');
        const donanteInput = document.getElementById('donante');
        
        function toggleDonanteField() {
            if (esDonacionSi.checked) {
                donanteField.style.display = 'block';
                donanteInput.required = true;
            } else {
                donanteField.style.display = 'none';
                donanteInput.required = false;
                donanteInput.value = '';
            }
        }
        
        esDonacionSi.addEventListener('change', toggleDonanteField);
        esDonacionNo.addEventListener('change', toggleDonanteField);
        
        // Inicializar estado
        toggleDonanteField();
        
        // Formato de moneda para costo
        const costoInput = document.getElementById('costo');
        if (costoInput) {
            costoInput.addEventListener('blur', function() {
                if (this.value) {
                    this.value = parseFloat(this.value).toFixed(2);
                }
            });
        }
        
        // Validación de fechas
        const fechaAsignacion = document.getElementById('fecha_asignacion');
        const fechaAdquisicion = document.getElementById('fecha_adquisicion');
        
        if (fechaAdquisicion && fechaAsignacion) {
            fechaAdquisicion.addEventListener('change', function() {
                if (this.value && fechaAsignacion.value) {
                    if (new Date(fechaAsignacion.value) < new Date(this.value)) {
                        alert('La fecha de asignación no puede ser anterior a la fecha de adquisición');
                        fechaAsignacion.value = '';
                    }
                }
            });
            
            fechaAsignacion.addEventListener('change', function() {
                if (this.value && fechaAdquisicion.value) {
                    if (new Date(this.value) < new Date(fechaAdquisicion.value)) {
                        alert('La fecha de asignación no puede ser anterior a la fecha de adquisición');
                        this.value = '';
                    }
                }
            });
        }
        
        // Colapsar/expandir secciones
        const sectionHeaders = document.querySelectorAll('.section-header');
        sectionHeaders.forEach(header => {
            header.style.cursor = 'pointer';
            const body = header.nextElementSibling;
            
            // Inicialmente todas las secciones expandidas
            body.style.display = 'block';
            
            header.addEventListener('click', function() {
                if (body.style.display === 'none') {
                    body.style.display = 'block';
                    this.querySelector('i').style.transform = 'rotate(0deg)';
                } else {
                    body.style.display = 'none';
                    this.querySelector('i').style.transform = 'rotate(-90deg)';
                }
            });
        });
        
        // Confirmación antes de limpiar
        const resetButton = document.querySelector('button[type="reset"]');
        if (resetButton) {
            resetButton.addEventListener('click', function(e) {
                if (!confirm('¿Estás seguro de que deseas limpiar todos los campos del formulario?')) {
                    e.preventDefault();
                }
            });
        }
        
        // Auto-focus en el primer campo editable
        const firstInput = document.querySelector('input:not([readonly]), select:not([readonly]), textarea:not([readonly])');
        if (firstInput) {
            setTimeout(() => {
                firstInput.focus();
            }, 100);
        }
    });
</script>
@endsection
@endsection
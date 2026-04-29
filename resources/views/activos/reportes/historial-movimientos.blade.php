@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1 fw-bold">Historial de Movimientos de Activo</h4>
            <p class="text-muted mb-0">Consulte todos los movimientos (traspasos) de un activo específico</p>
        </div>
        <a href="{{ route('activos.activos_reportes') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Volver
        </a>
    </div>

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('activos.reportes.generar_historial') }}" id="formHistorial" target="_blank">
                @csrf
                <div class="row g-3 align-items-end">
                    <div class="col-md-8">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-barcode me-2 text-muted"></i>
                            Número de inventario
                        </label>
                        <select name="numero_inventario" 
                                id="numero_inventario"
                                class="form-select form-control-lg @error('numero_inventario') is-invalid @enderror"
                                style="width: 100%; height: auto;"
                                required>
                            @if(old('numero_inventario'))
                                <option value="{{ old('numero_inventario') }}" selected>
                                    {{ old('numero_inventario') }}
                                </option>
                            @endif
                        </select>
                        @error('numero_inventario')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary w-100" id="btnConsultar">
                            <i class="fas fa-search me-2"></i>Consultar historial
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#numero_inventario').select2({
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
        },
        templateResult: formatActivoResult,
        templateSelection: formatActivoSelection
    });

    $(document).on('select2:open', '#numero_inventario', function(e) {
        setTimeout(function() {
            const searchField = document.querySelector('.select2-container--open .select2-search__field');
            if (searchField) {
                searchField.focus();
            }
        }, 10);
    });

    function formatActivoResult(activo) {
        if (activo.loading) {
            return activo.text;
        }

        if (!activo.id) {
            return activo.text;
        }

        var $container = $(
            '<div class="d-flex justify-content-between align-items-start">' +
                '<div>' +
                    '<strong>' + activo.text + '</strong>' +
                    '<div class="small text-muted">' + (activo.descripcion || '') + '</div>' +
                '</div>' +
                '<div class="text-end">' +
                    '<div class="small">' + (activo.empleado || 'Sin asignar') + '</div>' +
                    '<div class="small text-muted">' + (activo.departamento || '') + '</div>' +
                '</div>' +
            '</div>'
        );

        return $container;
    }

    function formatActivoSelection(activo) {
        if (!activo.id) {
            return activo.text;
        }
        return activo.text;
    }

    $('#btnConsultar').on('click', function(e) {
        var valor = $('#numero_inventario').val();
        if (!valor || valor === '') {
            e.preventDefault();
            alert('Por favor, seleccione un activo válido');
            return false;
        }
        $('#formHistorial').submit();
    });

    $('#formHistorial').on('submit', function(e) {
        var valor = $('#numero_inventario').val();
        if (!valor || valor === '') {
            e.preventDefault();
            alert('Por favor, seleccione un activo válido');
            return false;
        }
    });
});
</script>
@endpush

@push('styles')
<style>
    .select2-result-activo {
        padding: 8px 12px;
    }
    
    .select2-result-activo .activo-numero {
        font-size: 14px;
        font-weight: 600;
        color: #2c3e50;
    }
    
    .select2-result-activo .activo-descripcion {
        font-size: 12px;
        margin-top: 2px;
    }
    
    .select2-result-activo .activo-empleado {
        font-size: 11px;
        font-weight: 500;
        color: #495057;
    }
    
    .select2-result-activo .activo-departamento {
        font-size: 10px;
    }
    
    .select2-container--default .select2-results__option--highlighted[aria-selected] .select2-result-activo .activo-numero {
        color: white;
    }
    
    .select2-container--default .select2-results__option--highlighted[aria-selected] .select2-result-activo .activo-descripcion,
    .select2-container--default .select2-results__option--highlighted[aria-selected] .select2-result-activo .activo-empleado {
        color: rgba(255, 255, 255, 0.9);
    }
    
    .select2-selection__rendered {
        font-size: 14px;
    }
    
    .select2-container .select2-selection--single {
        height: auto;
        min-height: 48px;
    }
    
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 1.5;
        padding: 12px 20px 12px 12px;
    }
    
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 46px;
    }
</style>
@endpush
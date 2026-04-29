<div class="row">
    <div class="col-md-6">
        <div class="card shadow-sm h-100 border-primary">
            <div class="card-header bg-primary bg-opacity-10 py-3">
                <h6 class="mb-0 fw-semibold text-primary">
                    <i class="fas fa-building me-2"></i>
                    ORIGEN - Departamento origen (quién entrega)
                </h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-building me-2 text-muted"></i>
                        Departamento origen
                    </label>
                    <select id="departamentoOrigen" class="form-select select2-departamento" style="width: 100%">
                        <option value="">Seleccione un departamento...</option>
                        @foreach($departamentos as $dep)
                            <option value="{{ $dep->id }}" 
                                    data-descripcion="{{ $dep->descripcion }}"
                                    data-activos-count="{{ $dep->activos_count ?? 0 }}">
                                {{ $dep->descripcion }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div id="infoDepartamentoOrigen" class="mt-3 p-3 bg-light rounded">
                    <div class="d-flex justify-content-between gap-3">
                        <div class="flex-grow-1">
                            <small class="text-muted">Descripción</small>
                            <p class="mb-0 fw-semibold" id="origenDescripcion">—</p>
                        </div>
                        <div class="flex-grow-1">
                            <small class="text-muted">Activos asignados</small>
                            <p class="mb-0 fw-semibold" id="origenActivosCount">—</p>
                        </div>
                    </div>
                </div>

                <button id="btnCargarActivosDepartamento" class="btn btn-primary w-100 mt-3" disabled>
                    <i class="fas fa-search me-2"></i>Cargar activos del departamento
                </button>
            </div>
            <div class="card-footer bg-light">
                <small class="text-muted">
                    <i class="fas fa-info-circle me-1"></i>
                    Seleccione un departamento y cargue sus activos
                </small>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card shadow-sm h-100 border-success">
            <div class="card-header bg-success bg-opacity-10 py-3">
                <h6 class="mb-0 fw-semibold text-success">
                    <i class="fas fa-building me-2"></i>
                    DESTINO - Departamento destino (quién recibe)
                </h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-building me-2 text-muted"></i>
                        Departamento destino
                    </label>
                    <select id="departamentoDestino" class="form-select select2-departamento" style="width: 100%">
                        <option value="">Seleccione un departamento...</option>
                        @foreach($departamentos as $dep)
                            <option value="{{ $dep->id }}" 
                                    data-descripcion="{{ $dep->descripcion }}"
                                    data-activos-count="{{ $dep->activos_count ?? 0 }}">
                                {{ $dep->descripcion }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div id="infoDepartamentoDestino" class="mt-3 p-3 bg-light rounded">
                    <div class="d-flex justify-content-between gap-3">
                        <div class="flex-grow-1">
                            <small class="text-muted">Descripción</small>
                            <p class="mb-0 fw-semibold" id="destinoDescripcion">—</p>
                        </div>
                        <div class="flex-grow-1">
                            <small class="text-muted">Activos asignados</small>
                            <p class="mb-0 fw-semibold" id="destinoActivosCount">—</p>
                        </div>
                    </div>
                </div>

                <div id="mensajeSinDestinoDepartamento" class="text-muted text-center py-3">
                    <i class="fas fa-arrow-right me-2"></i>
                    Seleccione un departamento destino
                </div>
            </div>
            <div class="card-footer bg-light">
                <small class="text-muted">
                    <i class="fas fa-info-circle me-1"></i>
                    Seleccione quién recibirá los activos
                </small>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center flex-wrap">
                <h6 class="mb-0 fw-semibold">
                    <i class="fas fa-list me-2 text-warning"></i>
                    Activos a traspasar
                </h6>
                <div class="d-flex align-items-center gap-3">
                    <span>
                        <i class="fas fa-check-circle text-success me-1"></i>
                        <strong id="totalSeleccionadosDepartamento">0</strong> activos seleccionados
                    </span>
                </div>
            </div>

            <div class="card-body border-bottom bg-light">
                <div class="input-group">
                    <span class="input-group-text bg-white">
                        <i class="fas fa-search text-primary"></i>
                    </span>
                    <input type="text"
                        id="buscadorActivosDepartamento"
                        class="form-control"
                        placeholder="Buscar por número de inventario, descripción o serie..."
                        autocomplete="off">
                    <button class="btn btn-outline-secondary" type="button" id="limpiarBusquedaDepartamento">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div id="resultadoBusquedaDepartamento" class="small text-muted mt-2" style="display: none;">
                    <i class="fas fa-filter me-1"></i>
                    Mostrando <span id="filtradosCountDepartamento">0</span> de <span id="totalFiltradosDepartamento">0</span> activos
                </div>
            </div>

            <div class="card-body border-bottom py-2 bg-light">
                <div class="form-check mb-0">
                    <input class="form-check-input" type="checkbox" id="seleccionarTodosDepartamento">
                    <label class="form-check-label fw-semibold" for="seleccionarTodosDepartamento">
                        <i class="fas fa-check-double me-1"></i>Marcar/Desmarcar todos
                    </label>
                </div>
            </div>

            <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                <div id="mensajeSinActivosDepartamento" class="text-center text-muted py-5" style="display: none;">
                    <i class="fas fa-box-open fa-3x mb-3 opacity-50"></i>
                    <p>No hay activos asignados a este departamento</p>
                </div>
                <div id="listaActivosContainerDepartamento" style="display: none;">
                    <div id="listaActivosDepartamento" class="list-group"></div>
                </div>
            </div>
            
            <div class="card-footer bg-white">
                <div class="d-flex justify-content-end">
                    <button type="button" class="btn btn-success px-5" id="btnRealizarTraspasoMultipleDepartamento" disabled>
                        <i class="fas fa-exchange-alt me-2"></i>
                        Traspasar seleccionados
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.list-group-item.selected {
    background-color: #e7f1ff;
    border-left: 4px solid #0d6efd;
}
.list-group-item {
    transition: all 0.2s ease;
    cursor: pointer;
}
.list-group-item:hover {
    background-color: #f8f9fa;
}
</style>

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

function waitForjQuery(callback) {
    if (window.jQuery) {
        callback(window.jQuery);
    } else {
        setTimeout(function() {
            waitForjQuery(callback);
        }, 50);
    }
}

waitForjQuery(function($) {
    $(document).ready(function() {
        let activosOrigenDepartamento = [];
        let activosSeleccionadosDepartamento = new Map();
        let activosOriginalesDepartamento = [];
        let filtroActivoDepartamento = '';
        
        function cargarInfoDepartamentoOrigen() {
            let selected = $('#departamentoOrigen option:selected');
            let descripcion = selected.data('descripcion') || '—';
            let activosCount = selected.data('activos-count') || 0;
            
            $('#origenDescripcion').text(descripcion);
            $('#origenActivosCount').text(activosCount);
        }
        
        function cargarInfoDepartamentoDestino() {
            let selected = $('#departamentoDestino option:selected');
            let descripcion = selected.data('descripcion') || '—';
            let activosCount = selected.data('activos-count') || 0;
            
            $('#destinoDescripcion').text(descripcion);
            $('#destinoActivosCount').text(activosCount);
        }
        
        function filtrarActivosDepartamento() {
            let textoFiltro = $('#buscadorActivosDepartamento').val().toLowerCase().trim();
            filtroActivoDepartamento = textoFiltro;

            if (!textoFiltro) {
                renderizarListaActivosDepartamento(activosOriginalesDepartamento);
                $('#resultadoBusquedaDepartamento').hide();
                return;
            }

            let activosFiltrados = activosOriginalesDepartamento.filter(activo => {
                return activo.numero_inventario.toLowerCase().includes(textoFiltro) ||
                    (activo.descripcion_corta && activo.descripcion_corta.toLowerCase().includes(textoFiltro)) ||
                    (activo.numero_serie && activo.numero_serie.toLowerCase().includes(textoFiltro));
            });

            renderizarListaActivosDepartamento(activosFiltrados);

            $('#resultadoBusquedaDepartamento').show();
            $('#filtradosCountDepartamento').text(activosFiltrados.length);
            $('#totalFiltradosDepartamento').text(activosOriginalesDepartamento.length);
        }
        
        $('#departamentoOrigen').on('change', function() {
            cargarInfoDepartamentoOrigen();
            let val = $(this).val();
            $('#btnCargarActivosDepartamento').prop('disabled', !val);
            
            if (val) {
                activosOrigenDepartamento = [];
                activosSeleccionadosDepartamento.clear();
                activosOriginalesDepartamento = [];
                renderizarListaActivosDepartamento([]);
                $('#buscadorActivosDepartamento').val('');
                $('#resultadoBusquedaDepartamento').hide();
            }
        });
        
        $('#departamentoOrigen').on('select2:select', function() {
            cargarInfoDepartamentoOrigen();
            $('#btnCargarActivosDepartamento').prop('disabled', false);
        });
        
        $('#departamentoOrigen').on('select2:clear', function() {
            cargarInfoDepartamentoOrigen();
            $('#btnCargarActivosDepartamento').prop('disabled', true);
            activosOrigenDepartamento = [];
            activosSeleccionadosDepartamento.clear();
            activosOriginalesDepartamento = [];
            renderizarListaActivosDepartamento([]);
        });
        
        $('#departamentoDestino').on('change', function() {
            cargarInfoDepartamentoDestino();
            let val = $(this).val();
            
            if (val) {
                $('#destinoIdInputDepartamento').val(val);
                $('#mensajeSinDestinoDepartamento').hide();
            } else {
                $('#destinoIdInputDepartamento').val('');
                $('#mensajeSinDestinoDepartamento').show();
            }
        });
        
        $('#departamentoDestino').on('select2:select', function(e) {
            cargarInfoDepartamentoDestino();
            $('#destinoIdInputDepartamento').val(e.params.data.id);
            $('#mensajeSinDestinoDepartamento').hide();
        });
        
        $('#departamentoDestino').on('select2:clear', function() {
            cargarInfoDepartamentoDestino();
            $('#destinoIdInputDepartamento').val('');
            $('#mensajeSinDestinoDepartamento').show();
        });
        
        $('#buscadorActivosDepartamento').on('keyup', function() {
            filtrarActivosDepartamento();
        });
        
        $('#limpiarBusquedaDepartamento').click(function() {
            $('#buscadorActivosDepartamento').val('');
            filtrarActivosDepartamento();
        });
        
        $('#btnCargarActivosDepartamento').click(function() {
            let deptoId = $('#departamentoOrigen').val();
            if (!deptoId) return;
            
            $(this).html('<i class="fas fa-spinner fa-spin me-2"></i>Cargando...').prop('disabled', true);
            
            $.get('{{ route("activos.traspasos.multiples.activos") }}', { tipo: 'departamento', id: deptoId })
                .done(function(data) {
                    console.log('Activos cargados:', data.length);
                    activosOriginalesDepartamento = data;
                    activosOrigenDepartamento = data;
                    activosSeleccionadosDepartamento.clear();
                    renderizarListaActivosDepartamento(data);
                    $('#origenTipoInputDepartamento').val('departamento');
                    $('#origenIdInputDepartamento').val(deptoId);
                    
                    $('#buscadorActivosDepartamento').val('');
                    $('#resultadoBusquedaDepartamento').hide();
                })
                .fail(function() {
                    mostrarToast('Error al cargar los activos del departamento', 'error');
                })
                .always(function() {
                    $('#btnCargarActivosDepartamento').html('<i class="fas fa-search me-2"></i>Cargar activos del departamento').prop('disabled', false);
                });
        });
        
        function renderizarListaActivosDepartamento(activos) {
            let container = $('#listaActivosDepartamento');
            container.empty();
            
            if (activos.length === 0) {
                $('#mensajeSinActivosDepartamento').show();
                $('#listaActivosContainerDepartamento').hide();
                $('#badgeTotalDepartamento').text('0');
                actualizarContadoresDepartamento();
                return;
            }
            
            $('#mensajeSinActivosDepartamento').hide();
            $('#listaActivosContainerDepartamento').show();
            
            activos.forEach(activo => {
                let isChecked = activosSeleccionadosDepartamento.has(activo.folio);
                let item = `
                    <div class="list-group-item list-group-item-action ${isChecked ? 'selected' : ''}" data-id="${activo.folio}">
                        <div class="form-check">
                            <input class="form-check-input activo-checkbox-departamento" type="checkbox" 
                                   value="${activo.folio}" id="activo_dep_${activo.folio}" ${isChecked ? 'checked' : ''}>
                            <label class="form-check-label w-100" for="activo_dep_${activo.folio}">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>${activo.numero_inventario}</strong><br>
                                        <small>${activo.descripcion_corta || 'Sin descripción'}</small>
                                        ${activo.numero_serie ? `<div class="small text-muted">Serie: ${activo.numero_serie}</div>` : ''}
                                        <div class="small text-muted mt-1">
                                            <i class="fas fa-user me-1"></i>${activo.empleado_nombre || activo.empleado_old || 'No asignado'}
                                            <i class="fas fa-building ms-2 me-1"></i>${activo.departamento_descripcion || '-'}
                                        </div>
                                    </div>
                                    <span class="badge ${activo.status ? 'bg-success' : 'bg-secondary'}">
                                        ${activo.status ? 'Activo' : 'Inactivo'}
                                    </span>
                                </div>
                            </label>
                        </div>
                    </div>
                `;
                container.append(item);
            });
            
            actualizarContadoresDepartamento();
            
            $('.activo-checkbox-departamento').off('change').on('change', function() {
                let id = parseInt($(this).val());
                let parent = $(this).closest('.list-group-item');
                
                if ($(this).is(':checked')) {
                    let activo = activosOriginalesDepartamento.find(a => a.folio === id);
                    if (activo) {
                        activosSeleccionadosDepartamento.set(id, activo);
                        parent.addClass('selected');
                    }
                } else {
                    activosSeleccionadosDepartamento.delete(id);
                    parent.removeClass('selected');
                }
                
                actualizarContadoresDepartamento();
                
                let checkboxesVisibles = $('.activo-checkbox-departamento:visible');
                let checkedCheckboxes = checkboxesVisibles.filter(':checked');
                $('#seleccionarTodosDepartamento').prop('checked', checkboxesVisibles.length === checkedCheckboxes.length && checkboxesVisibles.length > 0);
            });
            
            $('#seleccionarTodosDepartamento').off('change').on('change', function() {
                let isChecked = $(this).is(':checked');
                $('.activo-checkbox-departamento:visible').each(function() {
                    if ($(this).prop('checked') !== isChecked) {
                        $(this).prop('checked', isChecked).trigger('change');
                    }
                });
            });
        }
        
        function actualizarContadoresDepartamento() {
            let total = activosSeleccionadosDepartamento.size;
            console.log('Total seleccionados departamento:', total);
            $('#totalSeleccionadosDepartamento').text(total);

            if (total > 0) {
                $('#btnRealizarTraspasoMultipleDepartamento').prop('disabled', false);
                $('#totalSeleccionadosInfoDepartamento').show();
            } else {
                $('#btnRealizarTraspasoMultipleDepartamento').prop('disabled', true);
                $('#totalSeleccionadosInfoDepartamento').hide();
            }
        }
        
        $('#btnRealizarTraspasoMultipleDepartamento').click(function() {
            let origenId = $('#departamentoOrigen').val();
            let destinoId = $('#departamentoDestino').val();
            
            if (!origenId) {
                mostrarToast('Por favor seleccione un departamento origen y cargue sus activos', 'warning');
                return;
            }
            if (!destinoId) {
                mostrarToast('Por favor seleccione un departamento destino', 'warning');
                return;
            }
            if (activosSeleccionadosDepartamento.size === 0) {
                mostrarToast('Por favor seleccione al menos un activo para traspasar', 'warning');
                return;
            }
            
            let origenNombre = $('#departamentoOrigen option:selected').data('descripcion');
            let destinoNombre = $('#departamentoDestino option:selected').data('descripcion');
            let totalActivos = activosSeleccionadosDepartamento.size;
            
            let resumenHtml = `
                <p><strong>Origen:</strong> ${origenNombre}</p>
                <p><strong>Destino:</strong> ${destinoNombre}</p>
                <p><strong>Total activos:</strong> ${totalActivos}</p>
            `;
            
            $('#resumenTraspaso').html(resumenHtml);
            $('#modalActivosIds').val(Array.from(activosSeleccionadosDepartamento.keys()).join(','));
            $('#modalOrigenTipo').val('departamento');
            $('#modalOrigenId').val(origenId);
            $('#modalDestinoTipo').val('departamento');
            $('#modalDestinoId').val(destinoId);
            $('#modalFechaTraspaso').val(new Date().toISOString().split('T')[0]);
            $('#modalMotivoTraspaso').val('');
            
            setTimeout(function() {
                if ($('#modalEdificioId').data('select2')) {
                    $('#modalEdificioId').select2('destroy');
                }
                $('#modalEdificioId').select2({
                    placeholder: "Seleccione un edificio...",
                    allowClear: true,
                    width: '100%',
                    dropdownParent: $('#modalConfirmarTraspasoMultiple')
                });
            }, 100);
            
            $('#modalConfirmarTraspasoMultiple').modal('show');
        });
        
        cargarInfoDepartamentoOrigen();
        cargarInfoDepartamentoDestino();
    });
});
</script>
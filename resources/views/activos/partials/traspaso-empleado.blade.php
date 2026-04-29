<div class="row">
    <div class="col-md-6">
        <div class="card shadow-sm h-100 border-primary">
            <div class="card-header bg-primary bg-opacity-10 py-3">
                <h6 class="mb-0 fw-semibold text-primary">
                    <i class="fas fa-user me-2"></i>
                    ORIGEN - Empleado origen (quién entrega)
                </h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-user-tie me-2 text-muted"></i>
                        Empleado origen
                    </label>
                    <select id="empleadoOrigen" class="form-select select2-empleado" style="width: 100%">
                        <option value="">Seleccione un empleado...</option>
                        @foreach($empleados as $emp)
                        <option value="{{ $emp->id }}"
                            data-nombre="{{ $emp->nombre }}"
                            data-nomina="{{ $emp->no_nomi }}"
                            data-departamento="{{ $emp->departamento->descripcion ?? '' }}"
                            data-edificio="{{ $emp->edificio->descripcion ?? 'Sin edificio' }}"
                            data-activos-count="{{ $emp->activos_count ?? 0 }}">
                            {{ $emp->nombre }} - {{ $emp->no_nomi }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div id="infoEmpleadoOrigen" class="mt-3 p-3 bg-light rounded">
                    <div class="d-flex justify-content-between gap-3">
                        <div class="flex-grow-1">
                            <small class="text-muted">Departamento</small>
                            <p class="mb-0 fw-semibold" id="origenDepartamento">—</p>
                        </div>
                        <div class="flex-grow-1">
                            <small class="text-muted">Edificio</small>
                            <p class="mb-0 fw-semibold" id="origenEdificio">—</p>
                        </div>
                        <div class="flex-grow-1">
                            <small class="text-muted">Bienes asignados</small>
                            <p class="mb-0 fw-semibold" id="origenBienes">—</p>
                        </div>
                    </div>
                </div>
                

                <button id="btnCargarActivosEmpleado" class="btn btn-primary w-100 mt-3" disabled>
                    <i class="fas fa-search me-2"></i>Cargar activos del empleado
                </button>
            </div>
            <div class="card-footer bg-light">
                <small class="text-muted">
                    <i class="fas fa-info-circle me-1"></i>
                    Seleccione un empleado y cargue sus activos
                </small>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card shadow-sm h-100 border-success">
            <div class="card-header bg-success bg-opacity-10 py-3">
                <h6 class="mb-0 fw-semibold text-success">
                    <i class="fas fa-user-check me-2"></i>
                    DESTINO - Empleado destino (quién recibe)
                </h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-user-check me-2 text-muted"></i>
                        Empleado destino
                    </label>
                    <select id="empleadoDestino" class="form-select select2-empleado" style="width: 100%">
                        <option value="">Seleccione un empleado...</option>
                        @foreach($empleados as $emp)
                        <option value="{{ $emp->id }}"
                            data-nombre="{{ $emp->nombre }}"
                            data-nomina="{{ $emp->no_nomi }}"
                            data-departamento="{{ $emp->departamento->descripcion ?? '' }}"
                            data-edificio="{{ $emp->edificio->descripcion ?? 'Sin edificio' }}"
                            data-activos-count="{{ $emp->activos_count ?? 0 }}">
                            {{ $emp->nombre }} - {{ $emp->no_nomi }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div id="infoEmpleadoDestino" class="mt-3 p-3 bg-light rounded">
                    <div class="d-flex justify-content-between gap-3">
                        <div class="flex-grow-1">
                            <small class="text-muted">Departamento</small>
                            <p class="mb-0 fw-semibold" id="destinoDepartamento">—</p>
                        </div>
                        <div class="flex-grow-1">
                            <small class="text-muted">Edificio</small>
                            <p class="mb-0 fw-semibold" id="destinoEdificio">—</p>
                        </div>
                        <div class="flex-grow-1">
                            <small class="text-muted">Bienes asignados</small>
                            <p class="mb-0 fw-semibold" id="destinoBienes">—</p>
                        </div>
                    </div>
                </div>

                <div id="mensajeSinDestinoEmpleado" class="text-muted text-center py-3">
                    <i class="fas fa-arrow-right me-2"></i>
                    Seleccione un empleado destino
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
                        <strong id="totalSeleccionadosEmpleado">0</strong> activos seleccionados
                    </span>
                </div>
            </div>

            <div class="card-body border-bottom bg-light">
                <div class="input-group">
                    <span class="input-group-text bg-white">
                        <i class="fas fa-search text-primary"></i>
                    </span>
                    <input type="text"
                        id="buscadorActivosEmpleado"
                        class="form-control"
                        placeholder="Buscar por número de inventario, descripción o serie..."
                        autocomplete="off">
                    <button class="btn btn-outline-secondary" type="button" id="limpiarBusquedaEmpleado">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div id="resultadoBusquedaEmpleado" class="small text-muted mt-2" style="display: none;">
                    <i class="fas fa-filter me-1"></i>
                    Mostrando <span id="filtradosCountEmpleado">0</span> de <span id="totalFiltradosEmpleado">0</span> activos
                </div>
            </div>
            <div class="card-body border-bottom py-2 bg-light">
                <div class="form-check mb-0">
                    <input class="form-check-input" type="checkbox" id="seleccionarTodosEmpleado">
                    <label class="form-check-label fw-semibold" for="seleccionarTodosEmpleado">
                        <i class="fas fa-check-double me-1"></i>Marcar/Desmarcar todos
                    </label>
                </div>
            </div>

            <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                <div id="mensajeSinActivosEmpleado" class="text-center text-muted py-5" style="display: none;">
                    <i class="fas fa-box-open fa-3x mb-3 opacity-50"></i>
                    <p>No hay activos asignados a este empleado</p>
                </div>
                <div id="listaActivosContainerEmpleado" style="display: none;">
                    <div id="listaActivosEmpleado" class="list-group"></div>
                </div>
            </div>
            <div class="card-footer bg-white">
                <div class="d-flex justify-content-end">
                    <button type="button" class="btn btn-success px-5" id="btnRealizarTraspasoMultipleEmpleado" disabled>
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
            let activosOrigenEmpleado = [];
            let activosSeleccionadosEmpleado = new Map();
            let activosOriginalesEmpleado = [];
            let filtroActivoEmpleado = '';

            function cargarInfoEmpleado(empleadoId, tipo) {
                if (!empleadoId) {
                    if (tipo === 'origen') {
                        $('#origenDepartamento').text('—');
                        $('#origenEdificio').text('—');
                        $('#origenBienes').text('—');
                    } else {
                        $('#destinoDepartamento').text('—');
                        $('#destinoEdificio').text('—');
                        $('#destinoBienes').text('—');
                        $('#destinoIdInputEmpleado').val('');
                        $('#mensajeSinDestinoEmpleado').show();
                    }
                    return;
                }

                $.get('/activos/empleado-info/' + empleadoId, function(data) {
                    if (tipo === 'origen') {
                        $('#origenDepartamento').text(data.departamento);
                        $('#origenEdificio').text(data.edificio);
                        $('#origenBienes').text(data.activos_count);
                        console.log('Origen cargado:', data);
                    } else {
                        $('#destinoDepartamento').text(data.departamento);
                        $('#destinoEdificio').text(data.edificio);
                        $('#destinoBienes').text(data.activos_count);
                        $('#destinoIdInputEmpleado').val(empleadoId);
                        $('#mensajeSinDestinoEmpleado').hide();
                        console.log('Destino cargado:', data);
                    }
                }).fail(function() {
                    mostrarToast('Error al cargar la información del empleado', 'error');
                });
            }

            function filtrarActivosEmpleado() {
                let textoFiltro = $('#buscadorActivosEmpleado').val().toLowerCase().trim();
                filtroActivoEmpleado = textoFiltro;

                if (!textoFiltro) {
                    renderizarListaActivosEmpleado(activosOriginalesEmpleado);
                    $('#resultadoBusquedaEmpleado').hide();
                    return;
                }

                let activosFiltrados = activosOriginalesEmpleado.filter(activo => {
                    return activo.numero_inventario.toLowerCase().includes(textoFiltro) ||
                        (activo.descripcion_corta && activo.descripcion_corta.toLowerCase().includes(textoFiltro)) ||
                        (activo.numero_serie && activo.numero_serie.toLowerCase().includes(textoFiltro));
                });

                renderizarListaActivosEmpleado(activosFiltrados);

                $('#resultadoBusquedaEmpleado').show();
                $('#filtradosCountEmpleado').text(activosFiltrados.length);
                $('#totalFiltradosEmpleado').text(activosOriginalesEmpleado.length);
            }

            $('#empleadoOrigen').on('change', function() {
                let empleadoId = $(this).val();
                cargarInfoEmpleado(empleadoId, 'origen');
                $('#btnCargarActivosEmpleado').prop('disabled', !empleadoId);

                if (empleadoId) {
                    activosOrigenEmpleado = [];
                    activosSeleccionadosEmpleado.clear();
                    renderizarListaActivosEmpleado([]);
                    $('#seleccionarTodosEmpleado').prop('checked', false);
                } else {
                    $('#btnRealizarTraspasoMultipleEmpleado').prop('disabled', true);
                }
            });

            $('#empleadoOrigen').on('select2:select', function(e) {
                let empleadoId = e.params.data.id;
                cargarInfoEmpleado(empleadoId, 'origen');
                $('#btnCargarActivosEmpleado').prop('disabled', false);
            });

            $('#empleadoOrigen').on('select2:clear', function() {
                cargarInfoEmpleado(null, 'origen');
                $('#btnCargarActivosEmpleado').prop('disabled', true);
                activosOrigenEmpleado = [];
                activosSeleccionadosEmpleado.clear();
                renderizarListaActivosEmpleado([]);
                $('#panelConfiguracionEmpleado').hide();
            });

            $('#empleadoDestino').on('change', function() {
                cargarInfoEmpleado($(this).val(), 'destino');
            });

            $('#empleadoDestino').on('select2:select', function(e) {
                cargarInfoEmpleado(e.params.data.id, 'destino');
            });

            $('#empleadoDestino').on('select2:clear', function() {
                cargarInfoEmpleado(null, 'destino');
            });

            $('#btnCargarActivosEmpleado').click(function() {
                let empleadoId = $('#empleadoOrigen').val();
                if (!empleadoId) return;

                $(this).html('<i class="fas fa-spinner fa-spin me-2"></i>Cargando...').prop('disabled', true);

                $.get('{{ route("activos.traspasos.multiples.activos") }}', {
                        tipo: 'empleado',
                        id: empleadoId
                    })
                    .done(function(data) {
                        console.log('Activos cargados:', data.length);
                        activosOriginalesEmpleado = data; 
                        activosOrigenEmpleado = data;
                        activosSeleccionadosEmpleado.clear();
                        renderizarListaActivosEmpleado(data);
                        $('#origenTipoInputEmpleado').val('empleado');
                        $('#origenIdInputEmpleado').val(empleadoId);

                        $('#buscadorActivosEmpleado').val('');
                        $('#resultadoBusquedaEmpleado').hide();
                    })
                    .fail(function(xhr) {
                        console.error('Error:', xhr);
                        mostrarToast('Error al cargar los activos del empleado', 'error');
                    })
                    .always(function() {
                        $('#btnCargarActivosEmpleado').html('<i class="fas fa-search me-2"></i>Cargar activos del empleado').prop('disabled', false);
                    });
            });

            $('#buscadorActivosEmpleado').on('keyup', function() {
                filtrarActivosEmpleado();
            });

            $('#limpiarBusquedaEmpleado').click(function() {
                $('#buscadorActivosEmpleado').val('');
                filtrarActivosEmpleado();
            });

            function renderizarListaActivosEmpleado(activos) {
                let container = $('#listaActivosEmpleado');
                container.empty();

                if (activos.length === 0) {
                    $('#mensajeSinActivosEmpleado').show();
                    $('#listaActivosContainerEmpleado').hide();
                    $('#badgeTotalEmpleado').text('0');
                    actualizarContadoresEmpleado();
                    return;
                }

                $('#mensajeSinActivosEmpleado').hide();
                $('#listaActivosContainerEmpleado').show();
                

                activos.forEach(activo => {
                    let isChecked = activosSeleccionadosEmpleado.has(activo.folio);
                    let item = `
                        <div class="list-group-item list-group-item-action ${isChecked ? 'selected' : ''}" data-id="${activo.folio}">
                            <div class="form-check">
                                <input class="form-check-input activo-checkbox-empleado" type="checkbox" 
                                       value="${activo.folio}" id="activo_emp_${activo.folio}" ${isChecked ? 'checked' : ''}>
                                <label class="form-check-label w-100" for="activo_emp_${activo.folio}">
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

                actualizarContadoresEmpleado();

                $('.activo-checkbox-empleado').off('change').on('change', function() {
                    let id = parseInt($(this).val());
                    let parent = $(this).closest('.list-group-item');

                    if ($(this).is(':checked')) {
                        let activo = activosOriginalesEmpleado.find(a => a.folio === id);
                        if (activo) {
                            activosSeleccionadosEmpleado.set(id, activo);
                            parent.addClass('selected');
                        }
                    } else {
                        activosSeleccionadosEmpleado.delete(id);
                        parent.removeClass('selected');
                    }

                    actualizarContadoresEmpleado();

                    let checkboxesVisibles = $('.activo-checkbox-empleado:visible');
                    let checkedCheckboxes = checkboxesVisibles.filter(':checked');
                    $('#seleccionarTodosEmpleado').prop('checked', checkboxesVisibles.length === checkedCheckboxes.length && checkboxesVisibles.length > 0);
                });

                $('#seleccionarTodosEmpleado').off('change').on('change', function() {
                    let isChecked = $(this).is(':checked');
                    $('.activo-checkbox-empleado:visible').each(function() {
                        if ($(this).prop('checked') !== isChecked) {
                            $(this).prop('checked', isChecked).trigger('change');
                        }
                    });
                });
            }

            function actualizarContadoresEmpleado() {
                let total = activosSeleccionadosEmpleado.size;
                $('#totalSeleccionadosEmpleado').text(total);

                console.log('Activos seleccionados:', total);

                if (total > 0) {
                    $('#btnRealizarTraspasoMultipleEmpleado').prop('disabled', false);
                    $('#totalSeleccionadosInfoEmpleado').show();
                } else {
                    $('#btnRealizarTraspasoMultipleEmpleado').prop('disabled', true);
                    $('#totalSeleccionadosInfoEmpleado').hide();
                }
            }

            $('#btnRealizarTraspasoMultipleEmpleado').click(function() {
                let origenId = $('#empleadoOrigen').val();
                let destinoId = $('#empleadoDestino').val();

                if (!origenId) {
                    mostrarToast('Por favor seleccione un empleado origen y cargue sus activos', 'warning');
                    return;
                }
                if (!destinoId) {
                    mostrarToast('Por favor seleccione un empleado destino', 'warning');
                    return;
                }
                if (activosSeleccionadosEmpleado.size === 0) {
                    mostrarToast('Por favor seleccione al menos un activo para traspasar', 'warning');
                    return;
                }

                let origenNombre = $('#empleadoOrigen option:selected').data('nombre') || 'Empleado';
                let destinoNombre = $('#empleadoDestino option:selected').data('nombre') || 'Empleado';
                let destinoEdificio = $('#empleadoDestino option:selected').data('edificio') || 'Sin edificio'
                let totalActivos = activosSeleccionadosEmpleado.size;

                let resumenHtml = `
                    <p><strong>Origen:</strong> ${origenNombre}</p>
                    <p><strong>Destino:</strong> ${destinoNombre}</p>
                    <p><strong>Edificio destino:</strong> ${destinoEdificio}</p>
                    <p><strong>Total activos:</strong> ${totalActivos}</p>
                `;

                $('#resumenTraspaso').html(resumenHtml);
                $('#modalActivosIds').val(Array.from(activosSeleccionadosEmpleado.keys()).join(','));
                $('#modalOrigenTipo').val('empleado');
                $('#modalOrigenId').val(origenId);
                $('#modalDestinoTipo').val('empleado');
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
        });
    });
</script>
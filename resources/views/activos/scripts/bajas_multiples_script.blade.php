<script>
    $(document).ready(function() {
        $('.select2-empleado').select2({
            placeholder: "Buscar empleado...",
            allowClear: true,
            width: '100%'
        });

        $('.select2-departamento').select2({
            placeholder: "Buscar departamento...",
            allowClear: true,
            width: '100%'
        });

        let activosActuales = [];
        let activosSeleccionados = new Map();
        let tipoOrigenActual = '';
        let idOrigenActual = '';

        function mostrarNotificacion(tipo, mensaje, errores = null) {
            const toastElement = document.getElementById('toastNotificacion');
            const toastMensaje = document.getElementById('toastMensaje');
            const toastErrores = document.getElementById('toastErrores');
            const toastListaErrores = document.getElementById('toastListaErrores');

            toastElement.classList.remove('toast-success', 'toast-error', 'toast-warning');
            toastElement.classList.add(`toast-${tipo}`);
            toastMensaje.innerHTML = mensaje;

            if (errores && errores.length > 0) {
                toastErrores.style.display = 'block';
                toastListaErrores.innerHTML = '';
                errores.forEach(error => {
                    toastListaErrores.innerHTML += `<li class="text-danger">${error}</li>`;
                });
            } else {
                toastErrores.style.display = 'none';
            }

            const toast = new bootstrap.Toast(toastElement, {
                autohide: true,
                delay: 7000
            });
            toast.show();
        }

        function actualizarContadorSeleccionados() {
            const totalSeleccionados = activosSeleccionados.size;
            let contadorExistente = $('#contadorSeleccionados');

            if (totalSeleccionados === 0) {
                contadorExistente.remove();
                return;
            }

            if (contadorExistente.length === 0) {
                $('.card-header.bg-white .d-flex.justify-content-between.align-items-center h5').after(`
                    <span class="badge bg-primary ms-3" id="contadorSeleccionados" style="font-size: 0.85rem; padding: 0.4rem 0.8rem;">
                        <i class="fas fa-check-circle me-1"></i>${totalSeleccionados} seleccionado(s)
                    </span>
                `);
            } else {
                contadorExistente.html(`<i class="fas fa-check-circle me-1"></i>${totalSeleccionados} seleccionado(s)`);
            }
        }

        $('#empleado_id').change(function() {
            const empleadoId = $(this).val();
            if (empleadoId) {
                tipoOrigenActual = 'empleado';
                idOrigenActual = empleadoId;
                limpiarSelecciones();
                cargarActivos('empleado', empleadoId);
            } else {
                limpiarTablaActivos();
            }
        });

        $('#departamento_id').change(function() {
            const departamentoId = $(this).val();
            if (departamentoId) {
                tipoOrigenActual = 'departamento';
                idOrigenActual = departamentoId;
                limpiarSelecciones();
                cargarActivos('departamento', departamentoId);
            } else {
                limpiarTablaActivos();
            }
        });

        function limpiarSelecciones() {
            activosSeleccionados.clear();
            actualizarContadorSeleccionados();
            actualizarBotonBaja();
        }

        function cargarActivos(tipo, id) {
            $.ajax({
                url: '{{ route("activos.bajas.multiples.activos") }}',
                method: 'GET',
                data: {
                    tipo: tipo,
                    id: id
                },
                beforeSend: function() {
                    $('#activos-body').html(`
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <i class="fas fa-spinner fa-spin me-2"></i>
                            Cargando activos...
                        </td>
                    </tr>
                `);
                },
                success: function(activos) {
                    activosActuales = activos;
                    if (activos.length === 0) {
                        $('#activos-body').html(`
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="fas fa-info-circle me-2"></i>
                                No hay activos disponibles para dar de baja
                            </td>
                        </tr>
                    `);
                        $('#tablaActivosContainer').show();
                        $('#formularioBajaContainer').hide();
                    } else {
                        renderTablaActivos(activos);
                        $('#tablaActivosContainer').show();
                        $('#formularioBajaContainer').show();

                        $('#origenTipo').val(tipoOrigenActual);
                        $('#origenId').val(idOrigenActual);
                    }
                },
                error: function() {
                    $('#activos-body').html(`
                    <tr>
                        <td colspan="7" class="text-center py-5 text-danger">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            Error al cargar los activos
                        </td>
                    </tr>
                `);
                    mostrarNotificacion('error', 'Error al cargar los activos');
                }
            });
        }

        function renderTablaActivos(activos) {
            const tbody = $('#activos-body');
            tbody.empty();

            activos.forEach(activo => {
                const folio = activo.folio.toString();
                const estaSeleccionado = activosSeleccionados.has(folio);

                const fila = $(`
                    <tr class="fila-activo" data-folio="${folio}" data-numero="${activo.numero_inventario}" style="cursor: pointer;">
                        <td>
                            <input type="checkbox" class="activo-checkbox" value="${folio}" data-numero="${activo.numero_inventario}" ${estaSeleccionado ? 'checked' : ''}>
                        </td>
                        <td><strong>${activo.numero_inventario}</strong></td>
                        <td>${activo.descripcion_corta}</td>
                        <td>${formatMoney(activo.costo)}</td>
                        <td>${activo.empleado_nombre || '-'}</td>
                        <td>${activo.departamento_descripcion || '-'}</td>
                        <td>${activo.edificio_descripcion || '-'}</td>
                    </tr>
                `);

                fila.on('click', function(e) {
                    if ($(e.target).is('input[type="checkbox"]')) {
                        return;
                    }

                    const checkbox = $(this).find('.activo-checkbox');
                    checkbox.prop('checked', !checkbox.prop('checked'));
                    checkbox.trigger('change');
                });

                fila.find('.activo-checkbox').on('change', function() {
                    const folio = $(this).val();
                    const numeroInventario = $(this).data('numero');

                    if ($(this).is(':checked')) {
                        activosSeleccionados.set(folio, numeroInventario);
                    } else {
                        activosSeleccionados.delete(folio);
                    }

                    actualizarContadorSeleccionados();
                    actualizarBotonBaja();
                    actualizarSeleccionTodos();
                });

                tbody.append(fila);
            });

            resetearBotonToggle();

            actualizarSeleccionTodos();

            actualizarBotonBaja();
            actualizarContadorSeleccionados();
        }

        function resetearBotonToggle() {
            $('#btnToggleSeleccion').html('<i class="fas fa-check-double me-1"></i>Seleccionar todos');
        }

        function actualizarBotonBaja() {
            const seleccionados = activosSeleccionados.size;
            $('#btnProcesarBajas').prop('disabled', seleccionados === 0);
        }

        $('#btnToggleSeleccion').click(function() {
            const $btn = $(this);
            const checkboxesVisibles = $('.activo-checkbox:visible');
            const seleccionadosVisibles = checkboxesVisibles.filter(':checked').length;
            const totalVisibles = checkboxesVisibles.length;

            if (seleccionadosVisibles === totalVisibles && totalVisibles > 0) {
                checkboxesVisibles.each(function() {
                    const folio = $(this).val();
                    activosSeleccionados.delete(folio);
                    $(this).prop('checked', false);
                });
                $btn.html('<i class="fas fa-check-double me-1"></i>Seleccionar todos');
            } else {
                checkboxesVisibles.each(function() {
                    const folio = $(this).val();
                    const numero = $(this).data('numero');
                    if (!activosSeleccionados.has(folio)) {
                        activosSeleccionados.set(folio, numero);
                        $(this).prop('checked', true);
                    }
                });
                $btn.html('<i class="fas fa-times me-1"></i>Deseleccionar todos');
            }

            actualizarContadorSeleccionados();
            actualizarBotonBaja();
            actualizarSeleccionTodos();
        });

        $('#select-all').change(function() {
            const isChecked = $(this).prop('checked');
            const checkboxesVisibles = $('.activo-checkbox:visible');

            checkboxesVisibles.each(function() {
                const folio = $(this).val();
                const numero = $(this).data('numero');

                if (isChecked) {
                    if (!activosSeleccionados.has(folio)) {
                        activosSeleccionados.set(folio, numero);
                    }
                    $(this).prop('checked', true);
                } else {
                    activosSeleccionados.delete(folio);
                    $(this).prop('checked', false);
                }
            });

            if (isChecked) {
                $('#btnToggleSeleccion').html('<i class="fas fa-times me-1"></i>Deseleccionar todos');
            } else {
                $('#btnToggleSeleccion').html('<i class="fas fa-check-double me-1"></i>Seleccionar todos');
            }

            actualizarContadorSeleccionados();
            actualizarBotonBaja();
        });

        function actualizarSeleccionTodos() {
            const checkboxesVisibles = $('.activo-checkbox:visible');
            const seleccionadosVisibles = checkboxesVisibles.filter(':checked').length;
            const totalVisibles = checkboxesVisibles.length;

            if (totalVisibles > 0) {
                $('#select-all').prop('checked', seleccionadosVisibles === totalVisibles);
                $('#select-all').prop('indeterminate', seleccionadosVisibles > 0 && seleccionadosVisibles < totalVisibles);
            } else {
                $('#select-all').prop('checked', false);
                $('#select-all').prop('indeterminate', false);
            }

            if (totalVisibles > 0 && seleccionadosVisibles === totalVisibles) {
                $('#btnToggleSeleccion').html('<i class="fas fa-times me-1"></i>Deseleccionar todos');
            } else {
                $('#btnToggleSeleccion').html('<i class="fas fa-check-double me-1"></i>Seleccionar todos');
            }
        }

        $('#btnLimpiar').click(function() {
            $('#empleado_id').val('').trigger('change');
            $('#departamento_id').val('').trigger('change');

            $('#fechaBaja').val('{{ date("Y-m-d") }}');
            $('#motivoBaja').val('');

            $('#tablaActivosContainer').hide();
            $('#formularioBajaContainer').hide();

            activosActuales = [];
            limpiarSelecciones();
            tipoOrigenActual = '';
            idOrigenActual = '';

            resetearBotonToggle();
        });

        $('#btnProcesarBajas').click(function() {
            if (activosSeleccionados.size === 0) {
                mostrarNotificacion('warning', 'Debe seleccionar al menos un activo para dar de baja');
                return;
            }

            const fechaBaja = $('#fechaBaja').val();
            const motivoBaja = $('#motivoBaja').val().trim();

            if (!fechaBaja) {
                mostrarNotificacion('warning', 'Debe seleccionar una fecha de baja');
                return;
            }

            if (!motivoBaja) {
                mostrarNotificacion('warning', 'Debe escribir el motivo de la baja');
                return;
            }

            const activosSeleccionadosArray = Array.from(activosSeleccionados.entries()).map(([folio, numero]) => ({
                folio: folio,
                numero: numero
            }));

            $('#resumenBajas').html(`
            <strong>Cantidad de activos:</strong> ${activosSeleccionados.size}<br>
            <strong>Activos:</strong> ${activosSeleccionadosArray.map(a => a.numero).join(', ')}
        `);
            $('#resumenFecha').text(fechaBaja);
            $('#resumenMotivo').text(motivoBaja);

            $('#modalConfirmarBajasMultiples').data('activos', Array.from(activosSeleccionados.keys()).join(','));

            $('#modalConfirmarBajasMultiples').modal('show');
        });

        $('#btnConfirmarBajas').click(function() {
            const activosIds = $('#modalConfirmarBajasMultiples').data('activos');
            const formData = {
                _token: $('input[name="_token"]').val(),
                activos_ids: activosIds,
                origen_tipo: $('#origenTipo').val(),
                origen_id: $('#origenId').val(),
                fecha_baja: $('#fechaBaja').val(),
                motivo_baja: $('#motivoBaja').val()
            };

            $('#modalConfirmarBajasMultiples').modal('hide');

            $('#btnConfirmarBajas').prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Procesando...');

            $.ajax({
                url: '{{ route("activos.bajas.multiples.store") }}',
                method: 'POST',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        let mensaje = `Se eliminaron ${response.procesados} activo(s) correctamente.`;
                        if (response.fallidos > 0) {
                            mensaje += ` ${response.fallidos} activo(s) no se pudieron procesar.`;
                            mostrarNotificacion('warning', mensaje, response.errores);
                        } else {
                            mostrarNotificacion('success', mensaje);
                        }

                        setTimeout(() => {
                            location.reload();
                        }, 2000);
                    } else {
                        mostrarNotificacion('error', response.message || 'Error al procesar las bajas');
                    }
                },
                error: function(xhr) {
                    let errorMsg = xhr.responseJSON?.message || 'Error al procesar las bajas múltiples';
                    mostrarNotificacion('error', errorMsg);
                },
                complete: function() {
                    $('#btnConfirmarBajas').prop('disabled', false).html('<i class="fas fa-check-circle me-2"></i>Confirmar bajas');
                }
            });
        });

        function limpiarTablaActivos() {
            $('#activos-body').html(`
            <tr>
                <td colspan="7" class="text-center py-5 text-muted">
                    <i class="fas fa-info-circle me-2"></i>
                    Seleccione un empleado o departamento para ver los activos
                </td>
            </tr>
        `);
            $('#tablaActivosContainer').hide();
            $('#formularioBajaContainer').hide();
            activosActuales = [];
            limpiarSelecciones();
            resetearBotonToggle();
        }

        function formatMoney(amount) {
            if (!amount) return '$0.00';
            return '$' + parseFloat(amount).toLocaleString('es-MX', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }

        $('#buscadorActivos').on('keyup', function() {
            const texto = $(this).val().toLowerCase();

            if (!texto) {
                renderTablaActivos(activosActuales);
                return;
            }

            const filtrados = activosActuales.filter(activo => {
                return (
                    (activo.numero_inventario && activo.numero_inventario.toLowerCase().includes(texto)) ||
                    (activo.descripcion_corta && activo.descripcion_corta.toLowerCase().includes(texto))
                );
            });

            renderTablaActivos(filtrados);
        });

        $('#btnLimpiarBusqueda').click(function() {
            $('#buscadorActivos').val('');
            renderTablaActivos(activosActuales);
        });

    });
</script>
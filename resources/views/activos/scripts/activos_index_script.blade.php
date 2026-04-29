<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if($activo)
        document.addEventListener('keydown', function(e) {
            if (e.key === 'ArrowLeft' && {{ $activoAnterior ? 'true' : 'false' }}) {
                window.location.href = "{{ $activoAnterior ? route('activos.index', ['id' => $activoAnterior->folio]) : '#' }}";
            }

            if (e.key === 'ArrowRight' && {{ $activoSiguiente ? 'true' : 'false' }}) {
                window.location.href = "{{ $activoSiguiente ? route('activos.index', ['id' => $activoSiguiente->folio]) : '#' }}";
            }

            if (e.key === 'Home' && {{ $primerActivo ? 'true' : 'false' }}) {
                window.location.href = "{{ $primerActivo ? route('activos.index', ['id' => $primerActivo->folio]) : '#' }}";
            }

            if (e.key === 'End' && {{ $ultimoActivo ? 'true' : 'false' }}) {
                window.location.href = "{{ $ultimoActivo ? route('activos.index', ['id' => $ultimoActivo->folio]) : '#' }}";
            }

            if (e.ctrlKey && e.key === 'f') {
                e.preventDefault();
                $('#buscarActivoPrincipal').select2('open');
            }
        });
        @endif

        const sectionHeaders = document.querySelectorAll('.section-header');
        sectionHeaders.forEach(header => {
            header.style.cursor = 'pointer';
            header.addEventListener('click', function() {
                const body = this.nextElementSibling;
                if (body.style.display === 'none') {
                    body.style.display = 'block';
                    this.querySelector('i').style.transform = 'rotate(0deg)';
                } else {
                    body.style.display = 'none';
                    this.querySelector('i').style.transform = 'rotate(-90deg)';
                }
            });
        });
    });

    $(document).ready(function() {
        $('#buscarActivoPrincipal').select2({
            placeholder: "Buscar por inventario, descripción, pedido, folio entrada...",
            allowClear: true,
            width: '100%',
            minimumInputLength: 2,
            language: {
                inputTooShort: function(args) {
                    return "Ingrese al menos " + args.minimum + " caracteres";
                },
                searching: function() {
                    return "Buscando activos...";
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
            templateResult: function(activo) {
                if (activo.loading) {
                    return activo.text;
                }

                if (!activo.id) {
                    return activo.text;
                }

                var $container = $(
                    "<div class='select2-result-activo'>" +
                    "<div class='select2-result-activo__title'>" + activo.text + "</div>" +
                    "<div class='select2-result-activo__info'>" +
                    "<small><i class='fas fa-building me-1'></i>" + (activo.departamento || 'No asignado') + "</small>" +
                    "<small class='ms-2'><i class='fas fa-user me-1'></i>" + (activo.empleado || 'Sin asignar') + "</small>" +
                    (activo.numero_pedido ? "<small class='ms-2'><i class='fas fa-shopping-cart me-1'></i>Ped: " + activo.numero_pedido + "</small>" : "") +
                    (activo.folio_entrada ? "<small class='ms-2'><i class='fas fa-clipboard-list me-1'></i>Ent: " + activo.folio_entrada + "</small>" : "") +
                    "</div>" +
                    "</div>"
                );

                return $container;
            },
            templateSelection: function(activo) {
                return activo.text || activo.id;
            }
        });

        $(document).on('select2:open', '#buscarActivoPrincipal', function(e) {
            setTimeout(function() {
                var searchField = document.querySelector('.select2-container--open .select2-search__field');
                if (searchField) {
                    searchField.focus();
                    searchField.select();
                }
            }, 10);
        });

        $('#buscarActivoPrincipal').on('change', function() {
            if ($(this).val()) {
                $('#formBusquedaPrincipal').submit();
            }
        });

        @if(request('search') && $activo)
        @elseif(request('search'))
        setTimeout(function() {
            var searchTerm = '{{ request("search") }}';
            if (searchTerm && !$('#buscarActivoPrincipal').val()) {
                var option = new Option(searchTerm, searchTerm, true, true);
                $('#buscarActivoPrincipal').append(option).trigger('change');
            }
        }, 100);
        @endif
    });
</script>
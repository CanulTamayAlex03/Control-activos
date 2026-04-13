<script>
    document.addEventListener('DOMContentLoaded', function() {
        const esDonacionSi = document.getElementById('es_donacion_si');
        const esDonacionNo = document.getElementById('es_donacion_no');
        const donanteField = document.getElementById('donante-field');
        const donanteInput = document.getElementById('donante');

        const rubroSelect = document.getElementById('rubro_id');
        const subrubroGroup = document.getElementById('subrubro-group');
        const subrubroSelect = document.getElementById('subrubro_id');
        const clasificacionGroup = document.getElementById('clasificacion-group');
        const clasificacionSelect = document.getElementById('clasificacion_id');

        const costoInput = document.getElementById('costo');
        let subrubros = [];

        function validarCostoUMA() {
            if (!costoInput) return;

            let valorUma = 3500.00;
            @if(isset($valorUma))
                valorUma = {{ $valorUma }};
            @endif

            const costo = parseFloat(costoInput.value) || 0;
            const messageDiv = document.getElementById('uma-message');

            if (!messageDiv) return;

            costoInput.classList.remove('is-valid', 'is-invalid');

            if (costo > 0) {
                if (costo >= valorUma) {
                    costoInput.classList.add('is-valid');
                    messageDiv.innerHTML = `
                        <small class="text-success">
                            <i class="fas fa-check-circle me-1"></i>
                            <strong>Mayor o igual a costo base</strong><br>
                        </small>
                    `;
                } else {
                    costoInput.classList.add('is-invalid');
                    messageDiv.innerHTML = `
                        <small class="text-danger">
                            <i class="fas fa-exclamation-circle me-1"></i>
                            <strong>Menor a costo base</strong><br>
                        </small>
                    `;
                }
            } else {
                messageDiv.innerHTML = `
                    <small class="text-muted">
                        <i class="fas fa-info-circle me-1"></i>
                        Ingrese un costo
                    </small>
                `;
            }
        }
        function cargarSubrubros(rubroId) {
            if (!rubroId) {
                subrubroGroup.style.display = 'none';
                subrubroSelect.innerHTML = '<option value="">Seleccionar...</option>';
                subrubroSelect.removeAttribute('required');
                return;
            }

            subrubroGroup.style.display = 'block';
            subrubroSelect.innerHTML = '<option value="">Cargando...</option>';
            
            fetch(`/activos/subrubros-por-rubro/${rubroId}`)
                .then(response => response.json())
                .then(data => {
                    subrubros = data;
                    subrubroSelect.innerHTML = '<option value="">Seleccionar...</option>';
                    
                    data.forEach(subrubro => {
                        const option = document.createElement('option');
                        option.value = subrubro.id;
                        option.textContent = subrubro.descripcion;
                        if (subrubro.subcuenta) {
                            option.textContent += ` (${subrubro.subcuenta})`;
                        }
                        subrubroSelect.appendChild(option);
                    });
                    
                    const oldSubrubro = '{{ old('subrubro_id') }}';
                    if (oldSubrubro) {
                        subrubroSelect.value = oldSubrubro;
                    }
                    
                    subrubroSelect.setAttribute('required', 'required');
                    
                    if (subrubroSelect.value == "3") {
                        clasificacionGroup.style.display = 'block';
                        clasificacionSelect.setAttribute('required', 'required');
                    } else {
                        clasificacionGroup.style.display = 'none';
                        clasificacionSelect.removeAttribute('required');
                        clasificacionSelect.value = '';
                    }
                })
                .catch(error => {
                    console.error('Error al cargar subrubros:', error);
                    subrubroSelect.innerHTML = '<option value="">Error al cargar</option>';
                });
        }

        function toggleClasificacionPorSubrubro() {
            if (subrubroSelect.value == "3") {
                clasificacionGroup.style.display = 'block';
                clasificacionSelect.setAttribute('required', 'required');
            } else {
                clasificacionGroup.style.display = 'none';
                clasificacionSelect.removeAttribute('required');
                clasificacionSelect.value = '';
            }
        }
        function toggleDonanteField() {
            if (esDonacionSi && esDonacionSi.checked) {
                donanteField.style.display = 'block';
                if (donanteInput) donanteInput.required = true;
            } else {
                donanteField.style.display = 'none';
                if (donanteInput) {
                    donanteInput.required = false;
                    donanteInput.value = '';
                }
            }
        }
        function toggleUbrEad() {
            if (ubrSelect.value) {
                eadSelect.disabled = true;
            } else {
                eadSelect.disabled = false;
            }

            if (eadSelect.value) {
                ubrSelect.disabled = true;
            } else {
                ubrSelect.disabled = false;
            }
        }


        if (costoInput) {
            costoInput.addEventListener('input', validarCostoUMA);
            
            costoInput.addEventListener('blur', function() {
                if (this.value) {
                    this.value = parseFloat(this.value).toFixed(2);
                    validarCostoUMA();
                }
            });
            
            if (costoInput.value) {
                validarCostoUMA();
            }
        }

        if (esDonacionSi && esDonacionNo) {
            esDonacionSi.addEventListener('change', toggleDonanteField);
            esDonacionNo.addEventListener('change', toggleDonanteField);
        }

        if (rubroSelect) {
            rubroSelect.addEventListener('change', function() {
                cargarSubrubros(this.value);
                clasificacionGroup.style.display = 'none';
                clasificacionSelect.removeAttribute('required');
                clasificacionSelect.value = '';
            });
        }

        if (subrubroSelect) {
            subrubroSelect.addEventListener('change', toggleClasificacionPorSubrubro);
        }

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

        const sectionHeaders = document.querySelectorAll('.section-header');
        sectionHeaders.forEach(header => {
            header.style.cursor = 'pointer';
            const body = header.nextElementSibling;
            
            body.style.display = 'block';
            
            header.addEventListener('click', function() {
                if (body.style.display === 'none') {
                    body.style.display = 'block';
                    const icon = this.querySelector('i');
                    if (icon) icon.style.transform = 'rotate(0deg)';
                } else {
                    body.style.display = 'none';
                    const icon = this.querySelector('i');
                    if (icon) icon.style.transform = 'rotate(-90deg)';
                }
            });
        });

        const resetButton = document.querySelector('button[type="reset"]');
        if (resetButton) {
            resetButton.addEventListener('click', function(e) {
                if (!confirm('¿Estás seguro de que deseas limpiar todos los campos del formulario?')) {
                    e.preventDefault();
                }
            });
        }

        const ubrSelect = document.getElementById('ubr_id');
        const eadSelect = document.getElementById('eade_id');

        if (ubrSelect && eadSelect) {
            ubrSelect.addEventListener('change', toggleUbrEad);
            eadSelect.addEventListener('change', toggleUbrEad);
            toggleUbrEad();
        }

        
        toggleDonanteField();

        const rubroInicial = '{{ old('rubro_id') }}';
        if (rubroInicial && rubroSelect) {
            rubroSelect.value = rubroInicial;
            cargarSubrubros(rubroInicial);
        }

        const subrubroInicial = '{{ old('subrubro_id') }}';
        if (subrubroInicial == "3") {
            setTimeout(() => {
                clasificacionGroup.style.display = 'block';
                clasificacionSelect.setAttribute('required', 'required');
            }, 500);
        }

        const firstInput = document.querySelector('input:not([readonly]), select:not([readonly]), textarea:not([readonly])');
        if (firstInput) {
            setTimeout(() => {
                firstInput.focus();
            }, 100);
        }
    });
</script>
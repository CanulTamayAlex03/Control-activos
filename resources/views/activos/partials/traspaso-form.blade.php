<div class="card shadow-lg">
    <div class="card-body">
        <div class="bg-light p-3 rounded mb-4">
            <div class="row align-items-center mb-3">
                <div class="col">
                    <h5 class="mb-1">{{ $activo->numero_inventario }}</h5>
                    <p class="mb-0 text-muted">{{ $activo->descripcion_corta }}</p>
                </div>
                <div class="col-auto">
                    <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">
                        <i class="fas fa-check-circle me-1"></i>Activo
                    </span>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-2">
                    <small class="text-muted d-block">Empleado actual:</small>
                    <strong>{{ $activo->empleado->nombre ?? $activo->empleado_old ?? '-' }}</strong>
                </div>
                <div class="col-md-4 mb-2">
                    <small class="text-muted d-block">Departamento:</small>
                    <strong>{{ $activo->departamento->descripcion ?? 'No asignado' }}</strong>
                </div>
                <div class="col-md-4 mb-2">
                    <small class="text-muted d-block">Edificio:</small>
                    <strong>{{ $activo->edificio->descripcion ?? 'No asignado' }}</strong>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('activos.traspasos.store') }}" id="formTraspaso">
            @csrf
            <input type="hidden" name="numero_inventario" value="{{ $activo->numero_inventario }}">

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-user me-2 text-muted"></i>
                        Empleado destino *
                    </label>
                    <select name="empleado_id" class="form-select" id="empleadoSelect" required style="width: 100%;">
                        <option value="">Seleccione un empleado...</option>
                        @foreach($empleados as $emp)
                            <option value="{{ $emp->id }}"
                                data-departamento="{{ $emp->id_depto }}"
                                data-edificio="{{ $emp->id_edif }}">
                                {{ $emp->nombre }} - {{ $emp->no_nomi }}
                            </option>
                        @endforeach
                    </select>
                    <div class="form-text text-muted">
                        <i class="fas fa-info-circle me-1"></i>
                        Seleccione un empleado diferente al actual
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-building me-2 text-muted"></i>
                        Departamento *
                    </label>
                    <select name="departamento_id" id="departamentoSelect" class="form-select" required style="width: 100%;">
                        <option value="">Seleccione un departamento...</option>
                        @foreach($departamentos as $dep)
                            <option value="{{ $dep->id }}" {{ $activo->departamento_id == $dep->id ? 'selected' : '' }}>
                                {{ $dep->descripcion }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-home me-2 text-muted"></i>
                        Edificio *
                    </label>
                    <select name="edificio_id" id="edificioSelect" class="form-select" required style="width: 100%;">
                        <option value="">Seleccione un edificio...</option>
                        @foreach($edificios as $edi)
                            <option value="{{ $edi->id }}" {{ $activo->edificio_id == $edi->id ? 'selected' : '' }}>
                                {{ $edi->descripcion }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-calendar-alt me-2 text-muted"></i>
                        Fecha de traspaso *
                    </label>
                    <input type="date" name="fecha_traspaso" class="form-control"
                           value="{{ date('Y-m-d') }}" required>
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-comment-alt me-2 text-muted"></i>
                        Motivo del traspaso *
                    </label>
                    <textarea name="motivo_traspaso" class="form-control"
                              rows="3" placeholder="Describa el motivo del traspaso..." required></textarea>
                </div>
            </div>

            <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                <a href="{{ route('activos.traspasos.index') }}" class="btn btn-light px-4">
                    <i class="fas fa-times me-2"></i>
                    Cancelar
                </a>
                <button type="button" 
                        class="btn btn-primary px-5" 
                        id="btnRealizarTraspaso"
                        data-bs-toggle="modal" 
                        data-bs-target="#modalConfirmarTraspaso">
                    <i class="fas fa-exchange-alt me-2"></i>
                    Realizar traspaso
                </button>
            </div>
        </form>
    </div>
</div>
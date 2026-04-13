<div class="card shadow-sm mx-auto" style="max-width: 1300px;">
    <div class="card-header bg-light py-2">
        <div class="d-flex justify-content-between align-items-center">
            <h6 class="mb-0">
                <i class="fas fa-table me-2"></i>Listado de Activos
                @if(request('search'))
                <span class="badge bg-info ms-2">Resultados para: "{{ request('search') }}"</span>
                @endif
            </h6>
            <span class="badge bg-primary">{{ $activos->total() }} registros</span>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-sm mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 5%">ID</th>
                        <th style="width: 12%">Inventario</th>
                        <th style="width: 25%">Descripción</th>
                        <th style="width: 15%">Departamento</th>
                        <th style="width: 10%">Edificio</th>
                        <th style="width: 20%">Empleado</th>
                        <th style="width: 13%">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($activos as $item)
                    <tr>
                        <td class="align-middle">
                            <span class="badge bg-secondary">{{ $item->folio }}</span>
                        </td>
                        <td class="align-middle">
                            <strong>{{ $item->numero_inventario }}</strong>
                            <br>
                            <small class="text-muted">{{ $item->descripcion_corta }}</small>
                        </td>
                        <td class="align-middle">
                            {{ Str::limit($item->descripcion_larga ?: $item->descripcion_corta, 60) }}
                            @if($item->marca || $item->modelo)
                            <div class="small text-muted">
                                {{ $item->marca }} {{ $item->modelo }}
                            </div>
                            @endif
                        </td>
                        <td class="align-middle">
                            {{ $item->departamento->descripcion ?? '-' }}
                        </td>
                        <td class="align-middle">
                            {{ $item->edificio->descripcion ?? '-' }}
                        </td>
                        <td class="align-middle">
                            @if($item->empleado)
                                <div>{{ $item->empleado->no_nomi }} - {{ $item->empleado->nombre }}</div>
                            @else
                                <div>{{ $item->empleado_old ?: 'No asignado' }}</div>
                                @if($item->empleado_old)
                                    <small class="text-muted">Sist. anterior</small>
                                @endif
                            @endif
                        </td>
                        <td class="align-middle">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('activos.index', ['id' => $item->folio, 'view_mode' => 'card']) }}"
                                    class="btn btn-outline-primary"
                                    title="Ver detalle">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @can('editar activos')
                                <a href="{{ route('activos.edit', $item->folio) }}"
                                    class="btn btn-outline-warning"
                                    title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <i class="fas fa-box-open fa-2x text-muted mb-2 d-block"></i>
                            <p class="text-muted mb-0">No se encontraron activos</p>
                            @if(request('search'))
                            <small class="text-muted">No hay resultados para "{{ request('search') }}"</small>
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($activos->hasPages())
        <div class="card-footer bg-light">
            <div class="row g-2 align-items-center">
                <div class="col-md-6">
                    <div class="small text-muted">
                        <i class="fas fa-info-circle me-1"></i>
                        Mostrando {{ $activos->firstItem() }} al {{ $activos->lastItem() }} de {{ $activos->total() }} registros
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex justify-content-md-end">
                        {{ $activos->appends(request()->query())->onEachSide(1)->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
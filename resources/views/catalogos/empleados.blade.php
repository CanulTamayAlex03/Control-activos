@extends('layouts.app')

@section('content')
<div class="container-fluid mt-3">
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white py-2 text-center">
            <h5 class="mb-0">Catálogo de Empleados</h5>
        </div>
        <div class="card-body p-3">
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <div class="d-flex justify-content-between align-items-center mb-3">
                <form action="{{ route('catalogos.empleados') }}" method="GET">
                    <div class="input-group input-group-sm" style="width: 350px;">
                        <span class="input-group-text bg-light"><i class="bi bi-search"></i></span>
                        <input type="text"
                            class="form-control"
                            placeholder="Filtrar por nombre o número de nómina..."
                            name="search"
                            value="{{ request('search') }}">
                        <button class="btn btn-primary" type="submit">Filtrar</button>
                        @if(request('search'))
                        <a href="{{ route('catalogos.empleados') }}" class="btn btn-outline-secondary" title="Limpiar filtro">
                            <i class="bi bi-x-lg"></i>
                        </a>
                        @endif
                    </div>
                </form>
                <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addEmpleadoModal">
                    <i class="bi bi-plus-circle me-1"></i> Nuevo empleado
                </button>
            </div>

            <div class="table-responsive">
                <table class="table table-sm table-striped table-hover mb-2 mx-auto" style="width: 98%; margin-top: 15px">
                    <thead class="table-dark">
                        <tr>
                            <th width="5%">ID</th>
                            <th width="20%">Nombre</th>
                            <th width="10%">No. Nómina</th>
                            <th width="20%">Departamento</th>
                            <th width="15%">Edificio</th>
                            <th width="10%">Estado</th>
                            <th width="10%" class="text-start">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($empleados as $empleado)
                        <tr class="{{ $empleado->trashed() ? 'table-secondary' : '' }}">
                            <td>{{ $empleado->id }}</td>
                            <td>{{ $empleado->nombre }}</td>
                            <td>{{ $empleado->no_nomi ?? 'N/A' }}</td>
                            <td>{{ $empleado->departamento->descripcion ?? 'N/A' }}</td>
                            <td>{{ $empleado->edificio->descripcion ?? 'N/A' }}</td>
                            <td>
                                @if($empleado->trashed())
                                <span class="badge bg-danger">Inactivo</span>
                                @else
                                <span class="badge bg-success">Activo</span>
                                @endif
                            </td>
                            <td class="text-start">
                                <div class="btn-group btn-group-sm" role="group">
                                    <button class="btn btn-warning px-3 btn-edit"
                                        title="Editar"
                                        data-id="{{ $empleado->id }}"
                                        data-nombre="{{ $empleado->nombre }}"
                                        data-no_nomi="{{ $empleado->no_nomi }}"
                                        data-id_depto="{{ $empleado->id_depto }}"
                                        data-id_edif="{{ $empleado->id_edif }}"
                                        data-active="{{ $empleado->trashed() ? 0 : 1 }}">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-3">
                <small class="text-muted">
                    Mostrando {{ $empleados->firstItem() }} a {{ $empleados->lastItem() }} de {{ $empleados->total() }} registros
                </small>
                <nav aria-label="Page navigation">
                    {{ $empleados->onEachSide(1)->links('pagination::bootstrap-4') }}
                </nav>
            </div>
        </div>
    </div>
</div>
@endsection

@push('modals')
@include('catalogos.modales.empleado_add')
@include('catalogos.modales.empleado_edit')
@endpush

@section('scripts')
@include('catalogos.scripts.empleados_script')
@endsection

<style>
    .table {
        font-size: 0.85rem;
    }

    .table th {
        white-space: nowrap;
    }

    .pagination {
        font-size: 0.8rem;
        margin: 0;
    }

    .btn-sm {
        padding: 0.25rem 0.5rem;
    }

    .btn-group-sm>.btn {
        padding-left: 0.75rem;
        padding-right: 0.75rem;
        margin: 0 2px;
    }

    .card-header.text-center h5 {
        text-align: center;
        width: 100%;
    }

    .badge {
        font-size: 0.75rem;
        padding: 0.35em 0.65em;
    }

    .input-group .btn-outline-secondary {
        border-left: none;
        padding-left: 0.5rem;
        padding-right: 0.5rem;
    }

    .table-secondary {
        opacity: 0.8;
        background-color: #f8f9fa !important;
    }

    .form-check-input:checked {
        background-color: #198754;
        border-color: #198754;
    }
</style>
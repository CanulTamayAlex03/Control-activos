@extends('layouts.app')

@section('content')
<div class="container-fluid mt-3">
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white py-2 text-center">
            <h5 class="mb-0">Catálogo de Usuarios</h5>
        </div>
        <div class="card-body p-3">
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <div class="d-flex justify-content-between align-items-center mb-3">
                <form action="{{ route('usuarios') }}" method="GET">
                    <div class="input-group input-group-sm" style="width: 300px;">
                        <span class="input-group-text bg-light"><i class="bi bi-search"></i></span>
                        <input type="text"
                            class="form-control"
                            placeholder="Filtrar por email..."
                            name="search"
                            value="{{ request('search') }}">
                        <button class="btn btn-primary" type="submit">Filtrar</button>
                        @if(request('search'))
                        <a href="{{ route('usuarios') }}" class="btn btn-outline-secondary" title="Limpiar filtro">
                            <i class="bi bi-x-lg"></i>
                        </a>
                        @endif
                    </div>
                </form>
                @can('crear usuarios')
                <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addUserModal">
                    <i class="bi bi-plus-circle me-1"></i> Nuevo usuario
                </button>
                @endcan
            </div>

            <div class="table-responsive">
                <table class="table table-sm table-striped table-hover mb-2 mx-auto" style="width: 95%; margin-top: 15px">
                    <thead class="table-dark">
                        <tr>
                            <th width="10%">ID</th>
                            <th>Email</th>
                            <th width="20%">Rol</th>
                            <th width="15%">Estado</th>
                            <th width="15%" class="text-start">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr class="{{ $user->trashed() ? 'table-secondary' : '' }}">
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                {{ $user->roles->pluck('name')->join(', ') }}
                            </td>
                            <td>
                                @if($user->trashed())
                                <span class="badge bg-danger">Inactivo</span>
                                @else
                                <span class="badge bg-success">Activo</span>
                                @endif
                            </td>
                            <td class="text-start">
                                <div class="btn-group btn-group-sm" role="group" aria-label="Acciones">
                                    @can('editar usuarios')
                                    <button class="btn btn-warning px-3 btn-edit"
                                        title="Editar"
                                        data-id="{{ $user->id }}"
                                        data-email="{{ $user->email }}"
                                        data-role="{{ $user->roles->first()?->name }}"
                                        data-active="{{ $user->trashed() ? 0 : 1 }}">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-3">
                <small class="text-muted">
                    Mostrando {{ $users->firstItem() }} a {{ $users->lastItem() }} de {{ $users->total() }} registros
                </small>
                <nav aria-label="Page navigation">
                    {{ $users->onEachSide(1)->links('pagination::bootstrap-4') }}
                </nav>
            </div>
        </div>
    </div>
</div>
@endsection

@push('modals')
@include('admin.usuarios.modales.usuario_add')
@include('admin.usuarios.modales.usuario_edit')
@endpush

@section('scripts')
@include('admin.usuarios.scripts.usuarios_script')
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

    .form-check-input:focus {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }
</style>
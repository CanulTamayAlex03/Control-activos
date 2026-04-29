@extends('layouts.app')

@section('content')
<div class="container-fluid mt-3">
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white py-2 text-center">
            <h5 class="mb-0">Catálogo de Proveedores</h5>
        </div>
        <div class="card-body p-3">
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <div class="d-flex justify-content-between align-items-center mb-3">
                <form action="{{ route('catalogos.proveedores') }}" method="GET" class="d-flex gap-2">
                    <div class="input-group input-group-sm" style="width: 400px;">
                        <span class="input-group-text bg-light"><i class="bi bi-search"></i></span>
                        <input type="text"
                            class="form-control"
                            placeholder="Buscar por nombre, RFC o teléfono..."
                            name="search"
                            value="{{ request('search') }}">
                        <button class="btn btn-primary" type="submit">Filtrar</button>
                        @if(request('search'))
                        <a href="{{ route('catalogos.proveedores') }}" class="btn btn-outline-secondary" title="Limpiar filtro">
                            <i class="bi bi-x-lg"></i>
                        </a>
                        @endif
                    </div>
                </form>
                <div class="d-flex gap-2">
                    @can('crear proveedores')
                    <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addProveedorModal">
                        <i class="bi bi-plus-circle me-1"></i> Nuevo proveedor
                    </button>
                    @endcan
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-sm table-striped table-hover mb-2 mx-auto" style="width: 98%; margin-top: 15px">
                    <thead class="table-dark">
                        <tr>
                            <th width="5%">ID</th>
                            <th width="15%">Nombre Corto</th>
                            <th width="15%">Razón Social</th>
                            <th width="10%">RFC</th>
                            <th width="10%">Teléfono 1</th>
                            <th width="10%">Teléfono 2</th>
                            <th width="18%">Teléfonos</th>
                            <th width="6%">Estado</th>
                            <th width="6%">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($proveedores as $proveedor)
                        <tr class="{{ $proveedor->trashed() ? 'table-secondary' : '' }}">
                            <td>{{ $proveedor->id }}</td>
                            <td>{{ $proveedor->nomcorto }}</td>
                            <td>{{ Str::limit($proveedor->rz, 30) }}</td>
                            <td>{{ $proveedor->rfc }}</td>
                            <td>{{ $proveedor->telefono1 ?? '—' }}</td>
                            <td>{{ $proveedor->telefono2 ?? '—' }}</td>
                            <td>{{ $proveedor->telefonos ?? '—' }}</td>
                            <td>
                                @if($proveedor->trashed())
                                <span class="badge bg-danger">Inactivo</span>
                                @else
                                <span class="badge bg-success">Activo</span>
                                @endif
                            </td>
                            <td class="text-start">
                                <div class="btn-group btn-group-sm" role="group">
                                    @can('editar proveedores')
                                    <button class="btn btn-warning px-3 btn-edit"
                                        title="Editar"
                                        data-id="{{ $proveedor->id }}"
                                        data-nomcorto="{{ $proveedor->nomcorto }}"
                                        data-rz="{{ $proveedor->rz }}"
                                        data-rfc="{{ $proveedor->rfc }}"
                                        data-domicilio="{{ $proveedor->domicilio }}"
                                        data-ciudad="{{ $proveedor->ciudad }}"
                                        data-estado="{{ $proveedor->estado }}"
                                        data-fecha_alta="{{ $proveedor->fecha_alta ? $proveedor->fecha_alta->format('Y-m-d') : '' }}"
                                        data-telefono1="{{ $proveedor->telefono1 }}"
                                        data-telefono2="{{ $proveedor->telefono2 }}"
                                        data-dcredito="{{ $proveedor->dcredito }}"
                                        data-lcredito="{{ $proveedor->lcredito }}"
                                        data-adeudo="{{ $proveedor->adeudo }}"
                                        data-grupo="{{ $proveedor->grupo }}"
                                        data-active="{{ $proveedor->trashed() ? 0 : 1 }}">
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
                    Mostrando {{ $proveedores->firstItem() }} a {{ $proveedores->lastItem() }} de {{ $proveedores->total() }} registros
                </small>
                <nav aria-label="Page navigation">
                    {{ $proveedores->onEachSide(1)->links('pagination::bootstrap-4') }}
                </nav>
            </div>
        </div>
    </div>
</div>
@endsection

@push('modals')
@include('catalogos.modales.proveedor_add')
@include('catalogos.modales.proveedor_edit')
@endpush

@section('scripts')
@include('catalogos.scripts.proveedores_script')
@endsection

<style>
    .table {
        font-size: 0.8rem;
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
        font-size: 0.7rem;
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
    
    .text-end {
        text-align: right;
    }
    
    .btn-warning.active {
        background-color: #ffc107;
        border-color: #ffc107;
        color: #000;
        font-weight: bold;
    }
</style>
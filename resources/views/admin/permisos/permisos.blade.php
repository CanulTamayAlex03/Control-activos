@extends('layouts.app')

@section('content')
<div class="container-fluid mt-3">
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white py-2 text-center">
            <h5 class="mb-0">Administración de Roles y Permisos</h5>
        </div>
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <div class="card mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                    </div>
                    @can('crear roles')
                    <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#crearRolModal">
                        <i class="fas fa-plus me-1"></i> Nuevo Rol
                    </button>
                    @endcan
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Nombre del Rol</th>
                                <th>Permisos</th>
                                <th style="width: 12%">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($roles as $rol)
                            <tr>
                                <td>{{ $rol->id }}</td>
                                <td>{{ $rol->name }}</td>
                                <td>
                                    @if($rol->permissions->count() > 0)
                                    @foreach($rol->permissions as $permiso)
                                    <span class="badge bg-success text-light mb-1">{{ $permiso->name }}</span>
                                    @endforeach
                                    @else
                                    <span class="text-muted">Sin permisos</span>
                                    @endif
                                </td>
                                @can('editar permisos')
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <button class="btn btn-warning btn-sm editar-rol"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editarRolModal"
                                                data-id="{{ $rol->id }}"
                                                data-name="{{ $rol->name }}">
                                            <i class="bi bi-pencil"></i> Editar
                                        </button>
                                    </div>
                                </td>
                                @endcan
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('modals')
@include('admin.permisos.modales.permisos_add')
@include('admin.permisos.modales.permisos_edit')
@endpush

@section('scripts')
@include('admin.permisos.scripts.permisos_script')
@endsection

@section('styles')
<style>
    .tabla-container {
        background-color: #f8f8f8ff;
        padding: 15px;
        border-radius: 6px;
    }
</style>
@endsection

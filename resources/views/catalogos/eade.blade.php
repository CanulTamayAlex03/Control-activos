@extends('layouts.app')

@section('content')
<div class="container-fluid mt-3">
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white py-2 text-center">
            <h5 class="mb-0">Catálogo de EADE</h5>
        </div>
        <div class="card-body p-3">

            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <div class="d-flex justify-content-between align-items-center mb-3">
                <form action="{{ route('catalogos.eade') }}" method="GET">
                    <div class="input-group input-group-sm" style="width: 350px;">
                        <span class="input-group-text bg-light">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text"
                               class="form-control"
                               placeholder="Filtrar por descripción..."
                               name="search"
                               value="{{ request('search') }}">
                        <button class="btn btn-primary" type="submit">Filtrar</button>

                        @if(request('search'))
                        <a href="{{ route('catalogos.eade') }}"
                           class="btn btn-outline-secondary"
                           title="Limpiar filtro">
                            <i class="bi bi-x-lg"></i>
                        </a>
                        @endif
                    </div>
                </form>

                <button class="btn btn-success btn-sm"
                        data-bs-toggle="modal"
                        data-bs-target="#addEadeModal">
                    <i class="bi bi-plus-circle me-1"></i> Nuevo EADE
                </button>
            </div>

            <div class="table-responsive">
                <table class="table table-sm table-striped table-hover mb-2 mx-auto"
                       style="width: 95%; margin-top: 15px">
                    <thead class="table-dark">
                        <tr>
                            <th width="10%">ID</th>
                            <th width="65%">Descripción</th>
                            <th width="15%">Estado</th>
                            <th width="10%" class="text-start">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($eades as $eade)
                        <tr class="{{ $eade->trashed() ? 'table-secondary' : '' }}">
                            <td>{{ $eade->id }}</td>
                            <td>{{ $eade->descripcion }}</td>
                            <td>
                                @if($eade->trashed())
                                    <span class="badge bg-danger">Inactivo</span>
                                @else
                                    <span class="badge bg-success">Activo</span>
                                @endif
                            </td>
                            <td class="text-start">
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-warning px-3 btn-edit"
                                            title="Editar"
                                            data-id="{{ $eade->id }}"
                                            data-descripcion="{{ $eade->descripcion }}"
                                            data-active="{{ $eade->trashed() ? 0 : 1 }}">
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
                    Mostrando {{ $eades->firstItem() }} a {{ $eades->lastItem() }} de {{ $eades->total() }} registros
                </small>

                <nav>
                    {{ $eades->onEachSide(1)->links('pagination::bootstrap-4') }}
                </nav>
            </div>

        </div>
    </div>
</div>
@endsection

@push('modals')
@include('catalogos.modales.eade_add')
@include('catalogos.modales.eade_edit')
@endpush

@section('scripts')
@include('catalogos.scripts.eade_script')
@endsection
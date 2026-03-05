@extends('layouts.app')

@section('content')
<div class="container-fluid mt-3">
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white text-center py-2">
            <h5 class="mb-0">Catálogo de UBR</h5>
        </div>

        <div class="card-body p-3">

            <div class="d-flex justify-content-between mb-3">
                <form action="{{ route('catalogos.ubr') }}" method="GET">
                    <div class="input-group input-group-sm" style="width:350px">
                        <input type="text"
                               name="search"
                               class="form-control"
                               placeholder="Filtrar por descripción..."
                               value="{{ request('search') }}">
                        <button class="btn btn-primary">Filtrar</button>
                    </div>
                </form>

                <button class="btn btn-success btn-sm"
                        data-bs-toggle="modal"
                        data-bs-target="#addUbrModal">
                    <i class="bi bi-plus-circle me-1"></i> Nueva UBR
                </button>
            </div>

            <div class="table-responsive">
                <table class="table table-sm table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Descripción</th>
                            <th>Municipio</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ubrs as $ubr)
                        <tr class="{{ $ubr->trashed() ? 'table-secondary' : '' }}">
                            <td>{{ $ubr->id }}</td>
                            <td>{{ $ubr->descripcion }}</td>
                            <td>{{ $ubr->municipio->descripcion ?? '-' }}</td>
                            <td>
                                @if($ubr->trashed())
                                    <span class="badge bg-danger">Inactivo</span>
                                @else
                                    <span class="badge bg-success">Activo</span>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-warning btn-sm btn-edit"
                                        data-id="{{ $ubr->id }}"
                                        data-descripcion="{{ $ubr->descripcion }}"
                                        data-mun="{{ $ubr->mun_id }}"
                                        data-active="{{ $ubr->trashed() ? 0 : 1 }}">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{ $ubrs->links('pagination::bootstrap-4') }}

        </div>
    </div>
</div>
@endsection

@push('modals')
@include('catalogos.modales.ubr_add')
@include('catalogos.modales.ubr_edit')
@endpush

@section('scripts')
@include('catalogos.scripts.ubr_script')
@endsection
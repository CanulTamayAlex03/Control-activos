@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1 fw-bold">Reportes de Activo Fijo</h4>
            <p class="text-muted mb-0">Generación de reportes y consultas especializadas</p>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-4 mb-3">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="fas fa-history fa-3x text-primary mb-3"></i>
                    <h5 class="card-title">Historial de Traspasos</h5>
                    <p class="card-text text-muted small">
                        Consulta traspasos de un activo por número de inventario
                    </p>
                    <a href="{{ route('activos.reportes.historial_movimientos') }}" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-search me-1"></i>Consultar
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="fas fa-chart-line fa-3x text-primary mb-3"></i>
                    <h5 class="card-title">Reporte General</h5>
                    <p class="card-text text-muted small">
                        Reporte general de activos fijos
                    </p>
                    <button class="btn btn-outline-primary btn-sm" disabled>
                        <i class="fas fa-file-alt me-1"></i>Próximamente
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
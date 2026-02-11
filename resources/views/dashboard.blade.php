@extends('layouts.app')

@section('content')

<div class="row mb-4">
    <div class="col header-dashboard">
        <h1 class="h3 mb-0">INICIO</h1>
    </div>
</div>
<div class="container-fluid px-4 pb-4">

    <!-- Cards de navegación -->
    <div class="row g-4">
        <!-- Card Activos -->
        <div class="col-md-4 col-lg-3">
            <a href="{{ route('activos.index') }}" class="text-decoration-none">
                <div class="card text-white bg-card h-100 shadow-sm dashboard-card">
                    <div class="card-body d-flex flex-column justify-content-center align-items-center text-center">
                        <i class="fas fa-boxes fa-3x mb-3"></i>
                        <h5 class="card-title mb-0">Activo fijo</h5>
                    </div>
                </div>
            </a>
        </div>

        <!-- Card Herramienta Menor -->
        <div class="col-md-4 col-lg-3">
            <a href="{{ route('herramienta-menor.index') }}" class="text-decoration-none">
                <div class="card text-white bg-card h-100 shadow-sm dashboard-card">
                    <div class="card-body d-flex flex-column justify-content-center align-items-center text-center">
                        <i class="fas fa-tools fa-3x mb-3"></i>
                        <h5 class="card-title mb-0">Herramienta Menor</h5>
                    </div>
                </div>
            </a>
        </div>

        @can('ver usuarios')
        <div class="col-md-4 col-lg-3">
            <a href="{{ route('usuarios') }}" class="text-decoration-none">
                <div class="card text-white bg-card h-100 shadow-sm dashboard-card">
                    <div class="card-body d-flex flex-column justify-content-center align-items-center text-center">
                        <i class="fas fa-users fa-3x mb-3"></i>
                        <h5 class="card-title mb-0">Usuarios</h5>
                    </div>
                </div>
            </a>
        </div>
        @endcan

         @can('ver permisos')
        <div class="col-md-4 col-lg-3">
            <a href="{{ route('admin.permisos') }}" class="text-decoration-none">
                <div class="card text-white bg-card h-100 shadow-sm dashboard-card">
                    <div class="card-body d-flex flex-column justify-content-center align-items-center text-center">
                        <i class="fas fa-lock fa-3x mb-3"></i>
                        <h5 class="card-title mb-0">Roles y Permisos</h5>
                    </div>
                </div>
            </a>
        </div>
        @endcan
    </div>
</div>

{{-- Estilos opcionales --}}
<style>
    .dashboard-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        border-radius: 12px;
    }

    .dashboard-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    .bg-card {
        background: rgb(27, 105, 47);
    }

    .header-dashboard {
        border-bottom: 2px solid #dee2e6;
        padding-bottom: 10px;
        background-color: #444444;
        color: white;
        border-radius: 12px;
        text-align: center;
        align-items: center;
        height: 60px;
    }

    .header-dashboard h1 {
        margin-top: 10px;
        font-size: 30px;
        font-weight: 700;
    }

    .container-fluid {
        background-color: #c9c9c9;
        margin-top: 45px;
        height: auto;
        border-radius: 8px;
    }
</style>
@endsection
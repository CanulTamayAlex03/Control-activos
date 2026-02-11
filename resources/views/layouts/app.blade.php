<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Control de Activos Fijos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('images/icono-herramientas.png') }}" type="image/png">
    <link rel="icon" href="{{ asset('images/icono-herramientas.png') }}" type="image/png">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
</head>

<body>
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div class="d-flex">

        <div id="sidebar" class="sidebar d-flex flex-column justify-content-between">
            <div>
                <div class="text-center border-bottom">
                    <img src="{{ asset('images/logodif.jpg') }}" alt="Logo" style="max-width: 100%; height: 65px;">
                </div>

                <a href="{{ route('dashboard') }}" 
                    class="{{ request()->routeIs('dashboard') ? 'active-link' : '' }}">
                    <i class="fas fa-home me-2"></i> Inicio
                </a>

                <a href="{{ route('activos.index') }}"
                    class="{{ request()->routeIs('activos.index') ? 'active-link' : '' }}">
                    <i class="fas fa-boxes me-2"></i> Activo fijo
                </a>

                <a href="{{ route('herramienta-menor.index') }}" 
                    class="{{ request()->routeIs('herramienta-menor.index') ? 'active-link' : '' }}">
                    <i class="fas fa-tools"></i> Herramienta Menor
                </a>

                @canany(['ver usuarios', 'ver permisos'])
                <div class="mt-3 mb-2 px-3">
                    <small class="text-uppercase text-light opacity-75">
                        Administración
                    </small>
                    <hr class="text-light my-2">
                </div>

                @can('ver usuarios')
                <a href="{{ route('usuarios') }}"
                    class="{{ request()->routeIs('usuarios') ? 'active-link' : '' }}">
                    <i class="fas fa-users me-2"></i> Usuarios
                </a>
                @endcan

                @can('ver permisos')
                <a href="{{ route('admin.permisos') }}"
                    class="{{ request()->routeIs('admin.permisos') ? 'active-link' : '' }}">
                    <i class="fas fa-lock me-2"></i> Roles y Permisos
                </a>
                @endcan
                @endcanany

            </div>

            <div class="p-3">
                <small class="text-light opacity-75 d-block text-center">
                    Sistema de Activos Fijos
                </small>
            </div>
        </div>

        <div class="content-wrapper" id="contentWrapper">

            <nav class="navbar border-bottom px-4" id="navbar">
                <div class="d-flex align-items-center gap-3">
                    <button id="toggleSidebar" class="btn btn-outline-secondary">
                        <i class="fas fa-bars"></i>
                    </button>

                    <span class="navbar-brand mb-0 h5">
                        CONTROL DE ACTIVOS FIJOS
                    </span>
                </div>

                <div class="d-flex align-items-center gap-3">
                    <div class="user-menu" id="userMenu">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-user-circle fa-lg"></i>
                            <span>
                                {{ auth()->user()->email }}
                                <i class="fas fa-chevron-down ms-1 small"></i>
                            </span>
                        </div>

                        <div class="dropdown-menu-user" id="userDropdown">
                            <div class="border-top">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="text-success w-100">
                                        <i class="fas fa-sign-out-alt me-2"></i> Salir del sistema
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <main class="p-4">
                @yield('content')
            </main>

        </div>
    </div>

    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/layout.js') }}"></script>

    @yield('scripts')
    @stack('modals')

</body>

</html>
<div class="mb-4">
    <ul class="nav nav-tabs nav-fill border-0" style="gap: 2px;" role="tablist">

        <li class="nav-item" role="presentation">
            <a href="{{ route('activos.traspasos.index') }}"
                class="nav-link py-3 fw-semibold {{ request()->routeIs('activos.traspasos.index') ? 'active bg-white shadow-sm border-0' : 'bg-light text-muted' }}"
                style="{{ request()->routeIs('activos.traspasos.index') ? 'color: #0d6efd; border-bottom: 3px solid #0d6efd;' : '' }}">
                <i class="fas fa-exchange-alt me-2"></i>
                Traspasos Individuales
            </a>
        </li>

        <li class="nav-item" role="presentation">
            <a href="{{ route('activos.traspasos.multiples.index') }}"
                class="nav-link py-3 fw-semibold {{ request()->routeIs('activos.traspasos.multiples.index') ? 'active bg-white shadow-sm border-0' : 'bg-light text-muted' }}"
                style="{{ request()->routeIs('activos.traspasos.multiples.index') ? 'color: #0d6efd; border-bottom: 3px solid #0d6efd;' : '' }}">
                <i class="fas fa-random me-2"></i>
                Traspasos Múltiples
            </a>
        </li>
        
        <li class="nav-item" role="presentation">
            <a href="{{ route('activos.bajas.index') }}"
                class="nav-link py-3 fw-semibold {{ request()->routeIs('activos.bajas.index') ? 'active bg-white shadow-sm border-0' : 'bg-light text-muted' }}"
                style="{{ request()->routeIs('activos.bajas.index') ? 'color: #0d6efd; border-bottom: 3px solid #0d6efd;' : '' }}">
                <i class="fa-solid fa-file-circle-minus me-2"></i>
                Bajas Individuales
            </a>
        </li>

        <li class="nav-item" role="presentation">
            <button class="nav-link bg-light border-0 rounded-top py-3 fw-semibold text-muted"
                style="cursor: default;"
                disabled>
                <i class="fa-solid fa-file-circle-xmark me-2"></i>
                Bajas Múltiples
            </button>
        </li>
    </ul>
</div>
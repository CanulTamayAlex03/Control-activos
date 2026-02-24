<div class="modal fade" id="tipoActivoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow border-0">

            <div class="modal-header bg-gradient bg-dark text-white border-0">
                <h5 class="modal-title">
                    <i class="fas fa-cubes me-2"></i>
                    Seleccionar Tipo de Activo
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body p-4">
                <p class="text-muted text-center mb-4">
                    <i class="fas fa-arrow-circle-right me-2"></i>
                    Seleccione el tipo de bien que desea registrar
                </p>

                <div class="row g-3">
                    <!-- Card Bienes Muebles -->
                    <div class="col-md-4">
                        <a href="/activos/create/BM" class="text-decoration-none">
                            <div class="card h-100 border-0 shadow-sm hover-card">
                                <div class="card-body text-center p-3">
                                    <div class="icon-circle bg-primary bg-opacity-10 mb-3">
                                        <i class="fas fa-boxes fa-2x text-primary"></i>
                                    </div>
                                    <h6 class="card-title fw-bold text-dark mb-2">Bienes Muebles</h6>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Card Bienes Vehiculares -->
                    <div class="col-md-4">
                        <a href="/activos/create/BV" class="text-decoration-none">
                            <div class="card h-100 border-0 shadow-sm hover-card">
                                <div class="card-body text-center p-3">
                                    <div class="icon-circle bg-success bg-opacity-10 mb-3">
                                        <i class="fas fa-car fa-2x text-success"></i>
                                    </div>
                                    <h6 class="card-title fw-bold text-dark mb-2">Bienes Vehiculares</h6>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Card Bienes Vehiculares Arrendados -->
                    <div class="col-md-4">
                        <a href="/activos/create/BVA" class="text-decoration-none">
                            <div class="card h-100 border-0 shadow-sm hover-card">
                                <div class="card-body text-center p-3">
                                    <div class="icon-circle bg-warning bg-opacity-10 mb-3">
                                        <i class="fas fa-file-contract fa-2x text-warning"></i>
                                    </div>
                                    <h6 class="card-title fw-bold text-dark mb-2">Vehículos Arrendados</h6>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.hover-card {
    transition: all 0.3s ease;
    cursor: pointer;
}

.hover-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.15) !important;
}

.hover-card:hover .icon-circle {
    transform: scale(1.1);
}

.icon-circle {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    transition: all 0.3s ease;
}

.bg-gradient {
    background: linear-gradient(135deg, #343a40 0%, #212529 100%);
}
</style>
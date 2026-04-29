<div class="modal fade" id="modalHistorialTraspasos" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title">
                    <i class="fas fa-history me-2"></i>
                    Historial de Traspasos
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            
            <div class="modal-body">
                <div class="mb-3">
                    <strong>Activo:</strong> <span id="modalActivoNombre"></span>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Fecha</th>
                                <th>Entregó</th>
                                <th>Recibió</th>
                                <th>Depto. Origen</th>
                                <th>Depto. Destino</th>
                                <th>Formato</th>
                            </tr>
                        </thead>
                        <tbody id="tablaHistorialTraspasos">
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <div class="spinner-border text-info" role="status">
                                        <span class="visually-hidden">Cargando...</span>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="editProveedorModal" tabindex="-1" aria-labelledby="editProveedorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="editProveedorModalLabel">Editar Proveedor</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editProveedorForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_id" name="id">

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_nomcorto" class="form-label">Nombre Corto *</label>
                            <input type="text" class="form-control" id="edit_nomcorto" name="nomcorto" required>
                            <div class="invalid-feedback" id="editNomcortoError"></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_rz" class="form-label">Razón Social</label>
                            <input type="text" class="form-control" id="edit_rz" name="rz">
                            <div class="invalid-feedback" id="editRzError"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_rfc" class="form-label">RFC</label>
                            <input type="text" class="form-control" id="edit_rfc" name="rfc" maxlength="13">
                            <div class="invalid-feedback" id="editRfcError"></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_fecha_alta" class="form-label">Fecha de Alta</label>
                            <input type="date" class="form-control" id="edit_fecha_alta" name="fecha_alta">
                            <div class="invalid-feedback" id="editFechaAltaError"></div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="edit_domicilio" class="form-label">Domicilio</label>
                        <input type="text" class="form-control" id="edit_domicilio" name="domicilio">
                        <div class="invalid-feedback" id="editDomicilioError"></div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_ciudad" class="form-label">Ciudad</label>
                            <input type="text" class="form-control" id="edit_ciudad" name="ciudad">
                            <div class="invalid-feedback" id="editCiudadError"></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_estado" class="form-label">Estado</label>
                            <input type="text" class="form-control" id="edit_estado" name="estado">
                            <div class="invalid-feedback" id="editEstadoError"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_telefono1" class="form-label">Teléfono 1 *</label>
                            <input type="text" class="form-control" id="edit_telefono1" name="telefono1" maxlength="10" required>
                            <div class="invalid-feedback" id="editTelefono1Error"></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_telefono2" class="form-label">Teléfono 2</label>
                            <input type="text" class="form-control" id="edit_telefono2" name="telefono2" maxlength="10">
                            <div class="invalid-feedback" id="editTelefono2Error"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label for="edit_dcredito" class="form-label">Días de Crédito</label>
                            <input type="number" class="form-control" id="edit_dcredito" name="dcredito" min="0">
                            <div class="invalid-feedback" id="editDcreditoError"></div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="edit_lcredito" class="form-label">Límite de Crédito</label>
                            <input type="number" class="form-control" id="edit_lcredito" name="lcredito" min="0" step="0.01">
                            <div class="invalid-feedback" id="editLcreditoError"></div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="edit_grupo" class="form-label">Grupo</label>
                            <input type="number" class="form-control" id="edit_grupo" name="grupo" min="0">
                            <div class="invalid-feedback" id="editGrupoError"></div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="edit_adeudo" class="form-label">Adeudo Actual</label>
                            <input type="number" class="form-control" id="edit_adeudo" name="adeudo" min="0" step="0.01">
                            <div class="invalid-feedback" id="editAdeudoError"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch"
                                id="edit_active" name="active" value="1">
                            <label class="form-check-label" for="edit_active">
                                <strong>Activo</strong>
                            </label>
                        </div>
                        <div class="form-text">
                            <span id="statusHelp" class="text-muted">
                                <i class="bi bi-info-circle me-1"></i>
                                Desmarca para inactivar el proveedor
                            </span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="updateProveedorBtn">Guardar Cambios</button>
            </div>
        </div>
    </div>
</div>
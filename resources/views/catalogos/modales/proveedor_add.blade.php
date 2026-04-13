<div class="modal fade" id="addProveedorModal" tabindex="-1" aria-labelledby="addProveedorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="addProveedorModalLabel">Nuevo Proveedor</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addProveedorForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3 position-relative">
                            <label for="nomcorto" class="form-label">Nombre Corto *</label>

                            <input
                                type="text"
                                class="form-control"
                                id="nomcorto"
                                name="nomcorto"
                                required
                                autocomplete="off">

                            <div id="nomcortoList"
                                class="list-group position-absolute w-100"
                                style="z-index: 1055; max-height: 200px; overflow-y: auto;">
                            </div>

                            <div class="invalid-feedback" id="nomcortoError"></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="rz" class="form-label">Razón Social</label>
                            <input type="text" class="form-control" id="rz" name="rz">
                            <div class="invalid-feedback" id="rzError"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="rfc" class="form-label">RFC</label>
                            <input type="text"
                                class="form-control"
                                id="rfc"
                                name="rfc"
                                maxlength="13"
                                style="text-transform: uppercase;"
                                oninput="this.value = this.value.replace(/\s/g, '')">
                            <div class="invalid-feedback" id="rfcError"></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="fecha_alta" class="form-label">Fecha de Alta</label>
                            <input type="date" class="form-control" id="fecha_alta" name="fecha_alta" value="{{ date('Y-m-d') }}">
                            <div class="invalid-feedback" id="fecha_altaError"></div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="domicilio" class="form-label">Domicilio</label>
                        <input type="text" class="form-control" id="domicilio" name="domicilio">
                        <div class="invalid-feedback" id="domicilioError"></div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="ciudad" class="form-label">Ciudad</label>
                            <input type="text" class="form-control" id="ciudad" name="ciudad">
                            <div class="invalid-feedback" id="ciudadError"></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="estado" class="form-label">Estado</label>
                            <input type="text" class="form-control" id="estado" name="estado">
                            <div class="invalid-feedback" id="estadoError"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="telefono1" class="form-label">Teléfono 1 *</label>
                            <input type="text" class="form-control" id="telefono1" name="telefono1" maxlength="10" required>
                            <div class="invalid-feedback" id="telefono1Error"></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="telefono2" class="form-label">Teléfono 2</label>
                            <input type="text" class="form-control" id="telefono2" name="telefono2" maxlength="10">
                            <div class="invalid-feedback" id="telefono2Error"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="dcredito" class="form-label">Días de Crédito</label>
                            <input type="number" class="form-control" id="dcredito" name="dcredito" value="0" min="0">
                            <div class="invalid-feedback" id="dcreditoError"></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="lcredito" class="form-label">Límite de Crédito</label>
                            <input type="number" class="form-control" id="lcredito" name="lcredito" value="0" min="0" step="0.01">
                            <div class="invalid-feedback" id="lcreditoError"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="grupo" class="form-label">Grupo</label>
                            <input type="number" class="form-control" id="grupo" name="grupo" value="0" min="0">
                            <div class="invalid-feedback" id="grupoError"></div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="saveProveedorBtn">Guardar</button>
            </div>
        </div>
    </div>
</div>


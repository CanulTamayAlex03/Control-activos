<div class="modal fade" id="resguardoModal" tabindex="-1" aria-labelledby="resguardoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="resguardoModalLabel">Generar Resguardo de Bien Mueble</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formResguardo" method="POST" target="_blank">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="activo_id" id="activo_id" value="">
                    
                    <div class="mb-3">
                        <label for="autorizo" class="form-label">Autorizó Jefe de Área <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control" 
                               id="autorizo" 
                               name="autorizo" 
                               placeholder="Ingrese el nombre del Jefe de Área" 
                               required>
                    </div>

                    <div class="mb-3">
                        <label for="visto_bueno_id" class="form-label">Visto Bueno Dirección Administrativa <span class="text-danger">*</span></label>
                        <select class="form-control" disabled>
                            @foreach($parametrosFirmas as $parametro)
                                <option value="{{ $parametro->id }}"
                                    {{ $parametro->id == 1 ? 'selected' : '' }}>
                                    {{ $parametro->nombre_completo }}
                                </option>
                            @endforeach
                        </select>
                        
                        <input type="hidden" name="visto_bueno_id" value="1">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Generar Resguardo</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('resguardoModal');

    modal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const folio = button.getAttribute('data-activo-id');

        const form = document.getElementById('formResguardo');

        const url = "{{ route('activos.resguardo', ['folio' => ':folio']) }}"
            .replace(':folio', folio);

        form.setAttribute('action', url);
    });
});
</script>
@endpush
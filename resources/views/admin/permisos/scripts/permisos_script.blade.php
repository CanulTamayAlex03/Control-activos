<script>
$(document).ready(function() {
    console.log('Script de roles cargado');

    $('#editarRolModal').on('show.bs.modal', function(event) {
        const button = $(event.relatedTarget);
        const id = button.data('id');
        const name = button.data('name');
        
        console.log('Cargando datos para rol ID:', id);
        
        const modal = $(this);
        modal.find('#edit_rol_id').val(id);
        modal.find('#edit_nombre').val(name);
        
        $('#permisosContainer').html(`
            <div class="col-12 text-center py-3">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Cargando permisos...</span>
                </div>
                <p class="mt-2 small">Cargando permisos...</p>
            </div>
        `);
        
        const url = "{{ route('admin.permisos.edit-ajax', ':id') }}".replace(':id', id);
        
        $.ajax({
            url: url,
            method: 'GET',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                console.log('Datos recibidos:', data);
                
                if (data.rol) {
                    const updateUrl = "{{ route('admin.permisos.updateRole', ':id') }}".replace(':id', data.rol.id);
                    $('#editarRolForm').attr('action', updateUrl);
                    
                    let html = '';
                    if (data.permisos && data.permisos.length > 0) {
                        data.permisos.forEach(function(perm) {
                            const isChecked = data.rol.permissions &&
                                data.rol.permissions.some(p => p.name === perm.name);

                            html += `
                            <div class="col-md-6 mb-2">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" 
                                           id="edit_perm_${perm.id}" 
                                           name="permissions[]" 
                                           value="${perm.name}"
                                           ${isChecked ? 'checked' : ''}>
                                    <label for="edit_perm_${perm.id}" class="form-check-label">
                                        ${perm.name}
                                    </label>
                                </div>
                            </div>`;
                        });
                    } else {
                        html = '<div class="col-12 text-center text-muted py-3">No hay permisos disponibles</div>';
                    }
                    
                    $('#permisosContainer').html(html);
                }
            },
            error: function(xhr) {
                console.error('Error:', xhr);
                $('#permisosContainer').html(`
                    <div class="col-12 text-center text-danger py-3">
                        <i class="bi bi-exclamation-triangle"></i>
                        <p>Error al cargar permisos</p>
                        <small>${xhr.status}: ${xhr.statusText}</small>
                    </div>
                `);
            }
        });
    });
    
    $('#editarRolModal').on('hidden.bs.modal', function() {
        $('#editarRolForm')[0].reset();
        $('#permisosContainer').html(`
            <div class="col-12 text-center py-3">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Cargando permisos...</span>
                </div>
                <p class="mt-2 small">Cargando permisos...</p>
            </div>
        `);
    });
    
    $('#editarRolForm').on('submit', function(e) {
        e.preventDefault();
        
        const form = $(this);
        const submitBtn = form.find('button[type="submit"]');
        const originalText = submitBtn.html();
        
        submitBtn.prop('disabled', true);
        submitBtn.html('<span class="spinner-border spinner-border-sm"></span> Guardando...');
        
        $.ajax({
            url: form.attr('action'),
            method: 'POST',
            data: form.serialize() + '&_method=PUT',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                if (data.success) {
                    $('.container-fluid').prepend(`
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            ${data.message}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    `);
                    
                    const modal = bootstrap.Modal.getInstance(document.getElementById('editarRolModal'));
                    modal.hide();
                    
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                }
            },
            error: function(xhr) {
                let message = 'Error al guardar los cambios';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                    const errors = Object.values(xhr.responseJSON.errors).flat();
                    message = errors.join('<br>');
                }
                
                $('.container-fluid').prepend(`
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        ${message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                `);
                
                submitBtn.prop('disabled', false);
                submitBtn.html(originalText);
            }
        });
    });
});
</script>
<script>
    $(document).ready(function() {
        $('#addDepartamentoModal, #editDepartamentoModal').on('hidden.bs.modal', function() {
            $(this).find('.is-invalid').removeClass('is-invalid');
            $(this).find('.invalid-feedback').hide();
            $(this).find('form')[0].reset();
        });

        $('#saveDepartamentoBtn').click(function() {
            const form = $('#addDepartamentoForm');
            const btn = $(this);

            form.find('.is-invalid').removeClass('is-invalid');
            form.find('.invalid-feedback').hide();

            btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Guardando...');

            $.ajax({
                url: '{{ route("catalogos.departamentos.store") }}',
                type: 'POST',
                data: form.serialize(),
                success: function(response) {
                    if (response.success) {
                        $('#addDepartamentoModal').modal('hide');
                        form[0].reset();

                        showToast('success', response.message);

                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        Object.keys(errors).forEach(key => {
                            const input = $(`#${key}`);
                            const errorDiv = $(`#${key}Error`);
                            input.addClass('is-invalid');
                            errorDiv.text(errors[key][0]).show();
                        });
                    } else {
                        showToast('error', xhr.responseJSON?.message || 'Error al guardar el departamento');
                    }
                },
                complete: function() {
                    btn.prop('disabled', false).html('Guardar');
                }
            });
        });

        $(document).on('click', '.btn-edit', function() {
            const id = $(this).data('id');
            const descripcion = $(this).data('descripcion');
            const id_edif = $(this).data('id_edif');
            const direccion_id = $(this).data('direccion_id');
            const active = $(this).data('active');

            $('#edit_id').val(id);
            $('#edit_descripcion').val(descripcion);
            $('#edit_id_edif').val(id_edif);
            $('#edit_direccion_id').val(direccion_id);

            if (active == 1 || active === '1') {
                $('#edit_active').prop('checked', true);
                $('#statusHelp').html('<i class="bi bi-info-circle me-1"></i>Desmarca para inactivar el departamento');
            } else {
                $('#edit_active').prop('checked', false);
                $('#statusHelp').html('<i class="bi bi-info-circle me-1"></i>Marca para activar el departamento');
            }

            $('#editDepartamentoModal').modal('show');
        });

        $('#updateDepartamentoBtn').click(function() {
            const btn = $(this);
            const id = $('#edit_id').val();

            $('#editDepartamentoForm').find('.is-invalid').removeClass('is-invalid');
            $('#editDepartamentoForm').find('.invalid-feedback').hide();

            const formData = {
                _method: 'PUT',
                _token: '{{ csrf_token() }}',
                descripcion: $('#edit_descripcion').val(),
                id_edif: $('#edit_id_edif').val(),
                direccion_id: $('#edit_direccion_id').val(),
                active: $('#edit_active').is(':checked') ? '1' : '0'
            };

            btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Guardando...');

            $.ajax({
                url: '{{ route("catalogos.departamentos.update", ":id") }}'.replace(':id', id),
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        $('#editDepartamentoModal').modal('hide');

                        showToast('success', response.message);

                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        Object.keys(errors).forEach(key => {
                            const input = $(`#edit_${key}`);
                            const errorDiv = $(`#edit${key.charAt(0).toUpperCase() + key.slice(1)}Error`);
                            if (input.length) {
                                input.addClass('is-invalid');
                                errorDiv.text(errors[key][0]).show();
                            }
                        });
                    } else {
                        showToast('error', xhr.responseJSON?.message || 'Error al actualizar el departamento');
                    }
                },
                complete: function() {
                    btn.prop('disabled', false).html('Guardar Cambios');
                }
            });
        });

        function showToast(type, message) {
            $('.alert[style*="position: fixed"]').remove();

            const toast = $(`
            <div class="alert alert-${type} alert-dismissible fade show" role="alert" style="position: fixed; top: 20px; right: 20px; z-index: 99999;">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `);

            $('body').append(toast);

            setTimeout(() => {
                toast.alert('close');
            }, 5000);
        }
    });
</script>
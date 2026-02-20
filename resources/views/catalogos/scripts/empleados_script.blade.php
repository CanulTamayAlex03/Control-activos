<script>
$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#saveEmpleadoBtn').on('click', function() {
        var formData = $('#addEmpleadoForm').serialize();

        $.ajax({
            url: '{{ route("catalogos.empleados.store") }}',
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.success) {
                    $('#addEmpleadoModal').modal('hide');
                    $('#addEmpleadoForm')[0].reset();

                    var alertHtml = '<div class="alert alert-success alert-dismissible fade show" role="alert">' +
                        response.message +
                        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                        '</div>';

                    $('.card-body').prepend(alertHtml);

                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    $('.invalid-feedback').html('');
                    $('.is-invalid').removeClass('is-invalid');

                    $.each(errors, function(field, messages) {
                        var input = $('#addEmpleadoForm [name="' + field + '"]');
                        input.addClass('is-invalid');
                        $('#' + field + 'Error').html(messages[0]);
                    });
                } else {
                    console.error('Error:', xhr);
                    alert('Ocurrió un error al guardar. Revisa la consola para más detalles.');
                }
            }
        });
    });

    $('.btn-edit').on('click', function() {
        var id = $(this).data('id');
        var nombre = $(this).data('nombre');
        var no_nomi = $(this).data('no_nomi');
        var id_depto = $(this).data('id_depto');
        var id_edif = $(this).data('id_edif');
        var active = $(this).data('active');

        $('#edit_id').val(id);
        $('#edit_nombre').val(nombre);
        $('#edit_no_nomi').val(no_nomi);
        $('#edit_id_depto').val(id_depto);
        $('#edit_id_edif').val(id_edif);

        if (active == 1) {
            $('#edit_active').prop('checked', true);
        } else {
            $('#edit_active').prop('checked', false);
        }

        $('#editEmpleadoModal').modal('show');
    });

    $('#updateEmpleadoBtn').on('click', function() {
        var id = $('#edit_id').val();
        
        var formData = new FormData();
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('_method', 'PUT');
        formData.append('nombre', $('#edit_nombre').val());
        formData.append('no_nomi', $('#edit_no_nomi').val());
        formData.append('id_depto', $('#edit_id_depto').val());
        formData.append('id_edif', $('#edit_id_edif').val());
        
        var isActive = $('#edit_active').is(':checked');
        formData.append('active', isActive ? 1 : 0);
        
        var url = '{{ route("catalogos.empleados.update", ":id") }}';
        url = url.replace(':id', id);

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    $('#editEmpleadoModal').modal('hide');

                    var alertHtml = '<div class="alert alert-success alert-dismissible fade show" role="alert">' +
                        response.message +
                        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                        '</div>';

                    $('.card-body').prepend(alertHtml);

                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    $('.invalid-feedback').html('');
                    $('.is-invalid').removeClass('is-invalid');

                    $.each(errors, function(field, messages) {
                        var input = $('#editEmpleadoForm [name="' + field + '"]');
                        input.addClass('is-invalid');
                        $('#edit' + field.charAt(0).toUpperCase() + field.slice(1) + 'Error').html(messages[0]);
                    });
                } else {
                    console.error('Error:', xhr);
                    alert('Ocurrió un error al actualizar. Revisa la consola para más detalles.');
                }
            }
        });
    });

    $('#addEmpleadoModal').on('hidden.bs.modal', function() {
        $('#addEmpleadoForm')[0].reset();
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').html('');
    });

    $('#editEmpleadoModal').on('hidden.bs.modal', function() {
        $('#editEmpleadoForm')[0].reset();
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').html('');
    });
});
</script>
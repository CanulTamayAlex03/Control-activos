<script>
$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#saveProveedorBtn').on('click', function() {
        var formData = $('#addProveedorForm').serialize();

        $.ajax({
            url: '{{ route("catalogos.proveedores.store") }}',
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.success) {
                    $('#addProveedorModal').modal('hide');
                    $('#addProveedorForm')[0].reset();

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
                        var input = $('#addProveedorForm [name="' + field + '"]');
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
        
        $('#edit_id').val(id);
        $('#edit_nomcorto').val($(this).data('nomcorto'));
        $('#edit_rz').val($(this).data('rz'));
        $('#edit_rfc').val($(this).data('rfc'));
        $('#edit_domicilio').val($(this).data('domicilio'));
        $('#edit_ciudad').val($(this).data('ciudad'));
        $('#edit_estado').val($(this).data('estado'));
        $('#edit_fecha_alta').val($(this).data('fecha_alta'));
        $('#edit_telefono1').val($(this).data('telefono1'));
        $('#edit_telefono2').val($(this).data('telefono2'));
        $('#edit_dcredito').val($(this).data('dcredito'));
        $('#edit_lcredito').val($(this).data('lcredito'));
        $('#edit_adeudo').val($(this).data('adeudo'));
        $('#edit_grupo').val($(this).data('grupo'));

        var active = $(this).data('active');
        if (active == 1) {
            $('#edit_active').prop('checked', true);
        } else {
            $('#edit_active').prop('checked', false);
        }

        $('#editProveedorModal').modal('show');
    });

    $('#updateProveedorBtn').on('click', function() {
        var id = $('#edit_id').val();
        
        var formData = new FormData();
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('_method', 'PUT');
        formData.append('nomcorto', $('#edit_nomcorto').val());
        formData.append('rz', $('#edit_rz').val());
        formData.append('rfc', $('#edit_rfc').val());
        formData.append('domicilio', $('#edit_domicilio').val());
        formData.append('ciudad', $('#edit_ciudad').val());
        formData.append('estado', $('#edit_estado').val());
        formData.append('fecha_alta', $('#edit_fecha_alta').val());
        formData.append('telefono1', $('#edit_telefono1').val());
        formData.append('telefono2', $('#edit_telefono2').val());
        formData.append('dcredito', $('#edit_dcredito').val());
        formData.append('lcredito', $('#edit_lcredito').val());
        formData.append('adeudo', $('#edit_adeudo').val());
        formData.append('grupo', $('#edit_grupo').val());
        
        var isActive = $('#edit_active').is(':checked');
        formData.append('active', isActive ? 1 : 0);
        
        var url = '{{ route("catalogos.proveedores.update", ":id") }}';
        url = url.replace(':id', id);

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    $('#editProveedorModal').modal('hide');

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
                        var input = $('#editProveedorForm [name="' + field + '"]');
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

    $('#addProveedorModal').on('hidden.bs.modal', function() {
        $('#addProveedorForm')[0].reset();
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').html('');
    });

    $('#editProveedorModal').on('hidden.bs.modal', function() {
        $('#editProveedorForm')[0].reset();
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').html('');
    });
});
</script>
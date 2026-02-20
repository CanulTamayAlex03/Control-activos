<script>
$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#saveEdificioBtn').on('click', function() {
        var formData = $('#addEdificioForm').serialize();

        $.ajax({
            url: '{{ route("catalogos.edificios.store") }}',
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.success) {
                    $('#addEdificioModal').modal('hide');
                    $('#addEdificioForm')[0].reset();

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
                        var input = $('#addEdificioForm [name="' + field + '"]');
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
        var descripcion = $(this).data('descripcion');
        var active = $(this).data('active');

        $('#edit_id').val(id);
        $('#edit_descripcion').val(descripcion);

        if (active == 1) {
            $('#edit_active').prop('checked', true);
        } else {
            $('#edit_active').prop('checked', false);
        }

        $('#editEdificioModal').modal('show');
    });

    $('#updateEdificioBtn').on('click', function() {
        var id = $('#edit_id').val();
        
        var formData = new FormData();
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('_method', 'PUT');
        formData.append('descripcion', $('#edit_descripcion').val());
        
        var isActive = $('#edit_active').is(':checked');
        formData.append('active', isActive ? 1 : 0);
        
        var url = '{{ route("catalogos.edificios.update", ":id") }}';
        url = url.replace(':id', id);

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    $('#editEdificioModal').modal('hide');

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
                        if (field === 'descripcion') {
                            $('#edit_descripcion').addClass('is-invalid');
                            $('#editDescripcionError').html(messages[0]);
                        }
                    });
                } else {
                    console.error('Error:', xhr);
                    alert('Ocurrió un error al actualizar. Revisa la consola para más detalles.');
                }
            }
        });
    });

    $('#addEdificioModal').on('hidden.bs.modal', function() {
        $('#addEdificioForm')[0].reset();
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').html('');
    });

    $('#editEdificioModal').on('hidden.bs.modal', function() {
        $('#editEdificioForm')[0].reset();
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').html('');
    });
});
</script>
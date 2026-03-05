<script>
    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#saveUbrBtn').click(function() {
            $.post("{{ route('catalogos.ubr.store') }}",
                $('#addUbrForm').serialize(),
                function(response) {
                    if (response.success) {
                        $('#addUbrModal').modal('hide');
                        location.reload();
                    }
                }
            );
        });

        $('.btn-edit').click(function() {
            $('#edit_id').val($(this).data('id'));
            $('#edit_descripcion').val($(this).data('descripcion'));
            $('#edit_mun').val($(this).data('mun'));
            $('#edit_active').prop('checked', $(this).data('active') == 1);
            $('#editUbrModal').modal('show');
        });

        $('#updateUbrBtn').click(function() {

            let id = $('#edit_id').val();

            $.ajax({
                url: "{{ route('catalogos.ubr.update', ':id') }}".replace(':id', id),
                type: 'POST',
                data: {
                    _method: 'PUT',
                    descripcion: $('#edit_descripcion').val(),
                    mun_id: $('#edit_mun').val(),
                    active: $('#edit_active').is(':checked') ? 1 : 0
                },
                success: function(response) {
                    if (response.success) {
                        $('#editUbrModal').modal('hide');
                        location.reload();
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;

                        if (errors.descripcion) {
                            $('#edit_descripcion').addClass('is-invalid');
                            $('#editDescripcionError').html(errors.descripcion[0]);
                        }

                        if (errors.mun_id) {
                            $('#edit_mun').addClass('is-invalid');
                            $('#editMunicipioError').html(errors.mun_id[0]);
                        }
                    }
                }
            });
        });

    });
</script>
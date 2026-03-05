<script>
$(function(){

    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    // GUARDAR
    $('#saveEadeBtn').click(function(){

        $.post("{{ route('catalogos.eade.store') }}",
            $('#addEadeForm').serialize(),
            function(response){
                if(response.success){
                    $('#addEadeModal').modal('hide');
                    location.reload();
                }
            }
        ).fail(function(xhr){
            if(xhr.status === 422){
                let errors = xhr.responseJSON.errors;
                if(errors.descripcion){
                    $('[name="descripcion"]').addClass('is-invalid');
                    $('#descripcionError').html(errors.descripcion[0]);
                }
            }
        });
    });

    // ABRIR EDITAR
    $('.btn-edit').click(function(){
        $('#edit_id').val($(this).data('id'));
        $('#edit_descripcion').val($(this).data('descripcion'));
        $('#edit_active').prop('checked', $(this).data('active') == 1);
        $('#editEadeModal').modal('show');
    });

    // ACTUALIZAR
    $('#updateEadeBtn').click(function(){

        let id = $('#edit_id').val();

        $.ajax({
            url: "{{ route('catalogos.eade.update', ':id') }}".replace(':id', id),
            type: 'POST',
            data: {
                _method: 'PUT',
                descripcion: $('#edit_descripcion').val(),
                active: $('#edit_active').is(':checked') ? 1 : 0
            },
            success: function(response){
                if(response.success){
                    $('#editEadeModal').modal('hide');
                    location.reload();
                }
            },
            error: function(xhr){
                if(xhr.status === 422){
                    let errors = xhr.responseJSON.errors;
                    if(errors.descripcion){
                        $('#edit_descripcion').addClass('is-invalid');
                        $('#editDescripcionError').html(errors.descripcion[0]);
                    }
                }
            }
        });
    });

});
</script>
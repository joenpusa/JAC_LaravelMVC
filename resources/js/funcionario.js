$(document).ready(function(){
    $('#uploadButton').click(function(){
        var formData = new FormData($('#uploadForm')[0]);

        $.ajax({
            url: $('#uploadForm').attr('action'),
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response){
                showToast('success', 'Documento subido correctamente.');
            },
            error: function(xhr){
                var errors = xhr.responseJSON.errors;
                var errorMessage = 'Error al subir el documento';
                $.each(errors, function(key, value) {
                    errorMessage += value[0] + '\n';
                });
                showToast('error', errorMessage);
            }
        });
    });

});


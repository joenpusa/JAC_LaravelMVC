$(document).ready(function(){
    $('#uploadButton').click(function(){
        console.log("Entre al metodo de carga")
        var formData = new FormData($('#uploadForm')[0]);

        $.ajax({
            url: $('#uploadForm').attr('action'),
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response){
                alert('Documento subido correctamente.');
            },
            error: function(xhr){
                alert('Error al subir el documento.');
                console.log(xhr.responseText);
            }
        });
    });

});

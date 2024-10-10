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

function showToast(type, message) {
    var toastTypeClass = type === 'success' ? 'toast-success' : 'toast-danger';
    var toastCircleClass = type === 'success' ? 'bg-success' : 'bg-danger';
    var toastHTML = `
        <div class="toast ${toastTypeClass}" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true">
            <div class="toast-header">
                <div class="toast-circle ${toastCircleClass} mr-2"></div>
                <strong class="me-auto mr-2">${type === 'success' ? 'Éxito' : 'Error'}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                ${message}
            </div>
        </div>
    `;
    $('#toast-container').append(toastHTML);
    var toast = new bootstrap.Toast($('#toast-container .toast').last());
    toast.show();
}

$(document).ready(function () {
    "use strict";

    var productDataTable = $("#products-data-table");
    // Manejar clic en el botón "Actualizar Producto"
    $('#btnUpdate').on('click', function (e) {
        e.preventDefault();
        // Obtener el token CSRF
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        // Obtener datos del formulario y agregar el token CSRF
        var formData = new FormData($('#editProductForm')[0]);
        formData.append('_token', csrfToken);

        // Mostrar datos en la consola antes de enviar la solicitud
        console.log(formData);

        // Realizar la solicitud POST para guardar los cambios
        $.ajax({
            url: $('#editProductForm').attr('action'),
            method: $('#editProductForm').attr('method'),
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function (response) {
                // Éxito, mostrar mensaje de éxito
                toastr.success(response.message);

                // Cerrar el modal
                $('#editProductModal').modal('hide');
                $('#editProductForm')[0].reset();

                // Recargar el DataTable
                productDataTable.DataTable().ajax.reload();
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    // Manejar errores de validación
                    var errors = xhr.responseJSON.errors;
                    var errorMessage = '';

                    for (var field in errors) {
                        errorMessage += errors[field].join('\n') + '\n';
                    }

                    // Comprueba si hay un mensaje específico relacionado con la validación del stock
                    var stockError = xhr.responseJSON.message;
                    if (stockError) {
                        errorMessage += stockError + '\n';
                    }

                    Swal.fire({
                        icon: "error",
                        title: "Error de validación",
                        text: errorMessage,
                    });
                } else {
                    // Otro tipo de error
                    var errorMessage = xhr.responseJSON.message || 'Error desconocido';
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: errorMessage,
                    });
                }
            }
        });
    });

    // Cancelar actualización de producto
    $('#btnCancelUpdate').on('click', function (e) {
        $('#editProductForm')[0].reset();
        $('#editProductModal').modal('hide');
    });
});

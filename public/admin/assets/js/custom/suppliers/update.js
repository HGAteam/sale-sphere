$(document).ready(function () {
    "use strict";

    var supplierDataTable = $("#suppliers-data-table")
    // Manejar clic en el botón "Save changes"
    $('#btnSaveChanges').on('click', function () {
        // Obtener el token CSRF
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        // Obtener datos del formulario y agregar el token CSRF
        var formData = new FormData($('#editSupplierForm')[0]);
        formData.append('_token', csrfToken);

        // Mostrar datos en la consola antes de enviar la solicitud
        console.log(formData);

        // Realizar la solicitud POST para guardar los cambios
        $.ajax({
            url: $('#editSupplierForm').attr('action'),
            method: $('#editSupplierForm').attr('method'),
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
                $('#editSupplierModal').modal('hide');

                // Recargar el DataTable
                supplierDataTable.DataTable().ajax.reload();
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    // Manejar errores de validación
                    var errors = xhr.responseJSON.errors;
                    var errorMessage = '';

                    for (var field in errors) {
                        errorMessage += errors[field].join('\n') + '\n';
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
            },
        });
    });

    // Botón de cancelar
    $("#btnCancelChanges").click(function () {
        // Cierra el modal
        $("#editSupplierModal").modal("hide");
    });
});

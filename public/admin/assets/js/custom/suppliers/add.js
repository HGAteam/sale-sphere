$(document).ready(function () {
    "use strict";

    var supplierDataTable = $("#suppliers-data-table")
    $("#btnSave").click(function () {
        $.ajax({
            url: "/home/suppliers", // Tu ruta de almacenamiento
            method: "POST",
            data: new FormData($("#add_new")[0]), // Asegúrate de asignar un ID a tu formulario
            contentType: false,
            processData: false,
            success: function (response) {
                // Éxito, mostrar mensaje de éxito
                Swal.fire({
                    icon: "success",
                    title: response.message,
                });
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
    $("#btnCancel").click(function () {
        // Puedes agregar lógica adicional aquí si es necesario
        // ...

        // Cierra el modal
        $("#addSupplier").modal("hide");
    });
});

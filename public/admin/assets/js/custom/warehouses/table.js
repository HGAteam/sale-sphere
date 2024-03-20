$(document).ready(function () {
    "use strict";

    var warehouseDataTable = $("#warehouses-data-table");

    if (warehouseDataTable.length !== 0) {
        warehouseDataTable.DataTable({
            info: false,
            order: [],
            scrollX: true,
            ajax: {
                url: "/home/warehouses/data",
            },
            "aLengthMenu": [[10, 20, 30, 50, 75, -1], [10, 20, 30, 50, 75, "All"]],
            "pageLength": 10,
            "dom": '<"row justify-content-between top-information"lf>rt<"row justify-content-between bottom-information"ip><"clear">',
            columns: [
                // Configurar las columnas según tus datos
                {
                    data: null
                },
                {
                    data: null
                },
                {
                    data: null
                },
                {
                    data: null
                },
                {
                    data: null
                },
                {
                    data: null
                },
                {
                    data: null
                },
                {
                    data: null
                },
                {
                    data: null
                },
                {
                    data: null
                },
                {
                    data: null
                }
            ],
            columnDefs: [
                // ID
                {
                    orderable: false,
                    targets: 0,
                    render: function (data) {
                        return data.id;
                    },
                },
                // NAME
                {
                    orderable: false,
                    targets: 1,
                    render: function (data) {
                        return data.name;
                    },
                },
                // LOCATION
                {
                    orderable: false,
                    targets: 2,
                    render: function (data) {
                        return data.location;
                    },
                },
                // ADDRESS
                {
                    orderable: false,
                    targets: 3,
                    render: function (data) {
                        return data.address;
                    },
                },
                // STATUS
                {
                    orderable: false,
                    targets: 4,
                    render: function (data) {
                        switch (data.status) {
                            case 1:
                                return `<span class="badge badge-success">${lang.t('Active')}</span>`;
                                break;
                            default:
                                return `<span class="badge badge-secondary">${lang.t('Inactive')}</span>`;
                                break;
                        }
                    },
                },
                // BRAND MANAGER
                {
                    orderable: false,
                    targets: 5,
                    className: 'text-center',
                    render: function (data) {
                        return data.branch_manager;
                    },
                },
                // PHONE
                {
                    orderable: false,
                    targets: 6,
                    className: 'text-center',
                    render: function (data) {
                        return data.phone;
                    },
                },
                // MOBILE
                {
                    orderable: false,
                    targets: 7,
                    className: 'text-center',
                    render: function (data) {
                        return data.mobile;
                    },
                },
                // CREATED AT
                {
                    orderable: false,
                    targets: 8,
                    className: 'text-center',
                    render: function (data) {
                        return data.created_at;
                    },
                },
                // CASHIERS
                {
                    orderable: false,
                    targets: 9,
                    className: 'text-center',
                    render: function (data) {
                        return data.cashiers;
                    },
                },
                // ACTIONS
                {
                    orderable: false,
                    targets: 10,
                    className: 'text-end',
                    render: function (data) {
                        return `<div class="btn-group mb-1">
                                                <button type="button" class="btn btn-outline-success info-warehouse" data-id="${data.id}">${lang.t('Products')}</button>
                                                <button type="button"
                                                    class="btn btn-outline-success dropdown-toggle dropdown-toggle-split"
                                                    data-bs-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false" data-display="static">
                                                    <span class="sr-only">${lang.t('Products')}</span>
                                                </button>

                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item edit-warehouse" data-id="${data.id}" href="#">${lang.t('Edit')}</a>
                                                    <a class="dropdown-item delete-warehouse" data-id="${data.id}" data-status="${data.status}" href="#">${lang.t('Delete')}</a>
                                                </div>
                                            </div>`;
                    },
                }
            ],
        });
    }
    // Eliminar
    warehouseDataTable.on('click', '.delete-warehouse', function (e) {
        e.preventDefault();

        var warehouseId = $(this).data('id');
        var warehouseStatus = $(this).data('status');

        // Verificar si el usuario está activo antes de permitir la eliminación
        if (warehouseStatus === 1) {
            // Realizar la solicitud POST para cambiar el estado del usuario
            $.ajax({
                url: '/home/warehouses/delete=' + warehouseId,
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    id: warehouseId
                },
                success: function (response) {
                    // Actualizar la tabla después de cambiar el estado del usuario
                    warehouseDataTable.DataTable().ajax.reload();
                },
                error: function (xhr) {
                    console.error(lang.t('Error when changing warehouse status') + ':', xhr.responseText);
                }
            });
        } else {
            // El usuario ya está inactivo, muestra un mensaje o realiza otra acción
            console.log('Este usuario ya está inactivo.');
        }
    });
    
    // Completa los campos con los datos correspondientes
    warehouseDataTable.on('click', '.edit-warehouse', function (e) {
        e.preventDefault();

        var warehouseId = $(this).data('id');

        $.ajax({
            url: '/home/warehouses/edit=' + warehouseId,
            method: 'GET',
            success: function (warehouseData) {
                $('#edit-name').val(warehouseData.name);
                $('#edit-branch_manager').val(warehouseData.branch_manager);
                $('#edit-address').val(warehouseData.address);
                $('#edit-location').val(warehouseData.location);
                $('#edit-phone').val(warehouseData.phone);
                $('#edit-mobile').val(warehouseData.mobile);
                $('#edit-status').val(warehouseData.status);
                $('#edit-details').val(warehouseData.details);
                $('#edit-cashiers').val(warehouseData.cashiers);

                // Configurar los atributos del formulario
                $('#editWarehouseForm').attr('enctype', 'multipart/form-data');
                $('#editWarehouseForm').attr('action', '/home/warehouses/edit=' + warehouseId);
                $('#editWarehouseForm').attr('method', 'POST');
            },
            error: function (xhr) {
                console.error('Error al obtener datos del usuario:', xhr.responseText);
            }
        });

        // Mostrar el modal después de configurar los atributos del formulario
        $('#editWarehouseModal').modal('show');
    });

    warehouseDataTable.on('click', '.info-warehouse', function (e) {
        var warehouseId = $(this).data('id');
        window.location.href = "/home/warehouses/profile=" + warehouseId;
    });

    // Download Template
    $('.template').on('click', function () {
        // URL de la plantilla que se va a descargar
        var templateUrl = '/admin/templates/warehouses.csv';

        // Crear un enlace temporal para la descarga
        var link = document.createElement('a');
        link.href = templateUrl;
        // Nombre del archivo a descargar
        link.download = 'plantilla_warehouses.csv';

        // Agregar el enlace al DOM y simular un clic para iniciar la descarga
        document.body.appendChild(link);
        link.click();

        // Eliminar el enlace del DOM después de la descarga
        document.body.removeChild(link);
    });

    // Import
    $('.import').on('click', function () {
        var fileInput = $('<input type="file" accept=".csv">');
        fileInput.hide();
        $('body').append(fileInput);
        fileInput.click();

        fileInput.on('change', function () {
            if (this.files.length > 0) {
                var file = this.files[0];
                var fileName = file.name;
                var fileExtension = fileName.split('.').pop().toLowerCase();

                if (fileExtension === 'csv') {
                    var importButton = $(this);
                    importButton.attr('disabled', true)
                        .html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>Loading...');

                    // Obtener el token CSRF
                    var csrfToken = $('meta[name="csrf-token"]').attr('content');

                    // Crear formData y agregar el token CSRF
                    var formData = new FormData();
                    formData.append('file', file);
                    formData.append('_token', csrfToken);

                    $.ajax({
                        url: '/home/warehouses/import',
                        method: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            console.log(response.message);
                            // Puedes recargar la tabla aquí
                            if (typeof productDataTable !== 'undefined') {
                                toastr.success('Importación exitosa');
                                // Tiempo en milisegundos antes de recargar
                                setTimeout(function () {
                                    window.location.reload();
                                }, 1500);
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error(xhr.responseJSON.error);

                            if (xhr.status === 422) {
                                // Mostrar mensaje Toastr de error específico para duplicados
                                toastr.error('Error al importar: ' + xhr.responseJSON.error);
                            } else {
                                // Mostrar mensaje Toastr de error general
                                toastr.error('Error al importar. Consulta los registros para más detalles.');
                            }
                        },
                        complete: function () {
                            // Restablecer el botón de importación y eliminar el input de archivo
                            importButton.removeAttr('disabled').html('Importar');
                            fileInput.remove();
                        }
                    });
                } else {
                    // Mostrar mensaje Toastr de advertencia
                    toastr.warning('Por favor, seleccione un archivo CSV válido.');
                }
            }
        });
    });

    // Export
    $('.export').on('click', function () {
        window.location.href = '/home/warehouses/export';
    });
});

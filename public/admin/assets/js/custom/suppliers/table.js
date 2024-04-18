$(document).ready(function () {
    "use strict";

    var supplierDataTable = $("#suppliers-data-table");

    if (supplierDataTable.length !== 0) {
        supplierDataTable.DataTable({
            info: false,
            order: [],
            scrollX: true,
            ajax: {
                url: "/home/suppliers/data",
            },
            "aLengthMenu": [[20, 30, 50, 75, -1], [20, 30, 50, 75, lang.t("All")]],
            "pageLength": 20,
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
                },
                {
                    data: null
                },
                {
                    data: null
                },
            ],
            columnDefs: [
                {
                    orderable: false,
                    targets: 0,
                    render: function (data) {
                        return data.id;
                    },
                },
                {
                    orderable: false,
                    targets: 1,
                    render: function (data) {
                        return data.social_reason;
                    },
                },
                {
                    orderable: false,
                    targets: 2,
                    render: function (data) {
                        return data.contact;
                    },
                },
                {
                    orderable: false,
                    targets: 3,
                    render: function (data) {
                        return data.cuit;
                    },
                },
                {
                    orderable: false,
                    targets: 4,
                    render: function (data) {
                        switch (data.status) {
                            case 'Active':
                                return `<span class="badge badge-success">${lang.t('Active')}</span>`;
                                break;
                            case 'Deleted':
                                return `<span class="badge badge-danger">${lang.t('Deleted')}</span>`;
                                break;
                            default:
                                return `<span class="badge badge-secondary">${lang.t('Inactive')}</span>`;
                                break;
                        }
                    },
                },
                {
                    orderable: false,
                    targets: 5,
                    render: function (data) {
                        return data.address;
                    },
                },
                {
                    orderable: false,
                    targets: 6,
                    render: function (data) {
                        return data.location;
                    },
                },
                {
                    orderable: false,
                    targets: 7,
                    render: function (data) {
                        return data.email;
                    },
                },
                {
                    orderable: false,
                    targets: 8,
                    render: function (data) {
                        if (!data.phone) {
                            return `<span class="badge badge-danger">${lang.t('No Phone')}</span>`;
                        } else {
                            return data.phone;
                        }
                    },
                },
                {
                    orderable: false,
                    targets: 9,
                    render: function (data) {
                        if (!data.mobile) {
                            return `<span class="badge badge-danger">${lang.t('No Mobile')}</span>`;
                        } else {
                            return data.mobile;
                        }
                    },
                },
                {
                    orderable: false,
                    targets: 10,
                    render: function (data) {
                        return data.created_at;
                    },
                },
                {
                    orderable: false,
                    targets: 11,
                    render: function (data) {
                        return data.details;
                    },
                },
                {
                    orderable: false,
                    targets: 12,
                    className: 'text-end',
                    render: function (data, row) {
                        return `<div class="btn-group mb-1">
                                                <button type="button"
                                                    class="btn btn-outline-success info-supplier" data-id="${data.id}">${lang.t('Info')}</button>
                                                <button type="button"
                                                    class="btn btn-outline-success dropdown-toggle dropdown-toggle-split"
                                                    data-bs-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false" data-display="static">
                                                    <span class="sr-only">${lang.t('Info')}</span>
                                                </button>

                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item edit-supplier" data-id="${data.id}" href="#">${lang.t('Edit')}</a>
                                                    <a class="dropdown-item delete-supplier" data-id="${data.id}" data-status="${data.status}" href="#">${lang.t('Delete')}</a>
                                                </div>
                                            </div>`;
                    },
                }
            ],
        });
    }

    // Eliminar
    supplierDataTable.on('click', '.delete-supplier', function (e) {
        e.preventDefault();

        var supplierId = $(this).data('id');
        var supplierStatus = $(this).data('status');

        // Verificar si el proveedor está activo antes de permitir la eliminación
        if (supplierStatus === "Active") {
            // Realizar la solicitud POST para cambiar el estado del proveedor
            $.ajax({
                url: '/home/suppliers/delete=' + supplierId,
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    id: supplierId
                },
                success: function (response) {
                    // Actualizar la tabla después de cambiar el estado del proveedor
                    supplierDataTable.DataTable().ajax.reload();
                },
                error: function (xhr) {
                    console.error(lang.t('Error when changing supplier status') + ':', xhr.responseText);
                }
            });
        } else {
            // El proveedor ya está inactivo, muestra un mensaje o realiza otra acción
            console.log('Este proveedor ya está inactivo.');
        }
    });

    // Completa los campos con los datos correspondientes
    supplierDataTable.on('click', '.edit-supplier', function (e) {
        e.preventDefault();

        var supplierId = $(this).data('id');

        $.ajax({
            url: '/home/suppliers/edit=' + supplierId,
            method: 'GET',
            success: function (supplierData) {
                $('#edit-social-reason').val(supplierData.social_reason);
                $('#edit-name').val(supplierData.name);
                $('#edit-lastname').val(supplierData.lastname);
                $('#edit-cuit').val(supplierData.cuit);
                $('#edit-status').val(supplierData.status);
                $('#edit-email').val(supplierData.email);
                $('#edit-phone').val(supplierData.phone);
                $('#edit-mobile').val(supplierData.mobile);
                $('#edit-address').val(supplierData.address);
                $('#edit-location').val(supplierData.location);
                $('#edit-details').val(supplierData.details);

                // Mostrar la imagen del proveedor si existe, de lo contrario, mostrar la imagen por defecto
                var supplierImage = supplierData.image ? '/' + supplierData.image : '/admin/assets/img/category/clothes.png';
                $('#defaultImage').attr('src', supplierImage);

                // Manejar cambios en el input file para previsualizar la nueva imagen
                $('#coverImageEdit').on('change', function () {
                    var input = this;

                    if (input.files && input.files[0]) {
                        var reader = new FileReader();

                        reader.onload = function (e) {
                            $('#defaultImage').attr('src', e.target.result);
                        };

                        reader.readAsDataURL(input.files[0]);
                    } else {
                        // Si se deja en blanco, volver a mostrar la imagen actual
                        $('#defaultImage').attr('src', supplierImage);
                    }
                });

                // Configurar los atributos del formulario
                $('#editSupplierForm').attr('enctype', 'multipart/form-data');
                $('#editSupplierForm').attr('action', '/home/suppliers/edit=' + supplierId);
                $('#editSupplierForm').attr('method', 'POST');
            },
            error: function (xhr) {
                console.error('Error al obtener datos del proveedor:', xhr.responseText);
            }
        });

        // Mostrar el modal después de configurar los atributos del formulario
        $('#editSupplierModal').modal('show');
    });

    // Modal Info
    supplierDataTable.on('click', '.info-supplier', function (e) {
        var supplierId = $(this).data('id');
        window.location.href = "/home/suppliers/profile=" + supplierId;
    });

    // Download Template
    $('.template').on('click', function () {
        // URL de la plantilla que se va a descargar
        var templateUrl = '/admin/templates/suppliers.csv'; // Reemplaza con la ruta correcta de tu plantilla

        // Crear un enlace temporal para la descarga
        var link = document.createElement('a');
        link.href = templateUrl;
        link.download = 'plantilla_suppliers.csv'; // Nombre del archivo a descargar

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
                        url: '/home/suppliers/import',
                        method: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            console.log(response.message);
                            // Puedes recargar la tabla aquí
                            if (typeof supplierDataTable !== 'undefined') {
                                toastr.success('Importación exitosa');
                                setTimeout(function () {
                                    // supplierDataTable.DataTable().ajax.reload();
                                    window.location.reload();
                                }, 1500); // Tiempo en milisegundos antes de recargar
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
        window.location.href = '/home/suppliers/export';
    });
});

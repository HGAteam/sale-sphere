$(document).ready(function () {
    "use strict";

    var customerDataTable = $("#customers-data-table");

    if (customerDataTable.length !== 0) {
        customerDataTable.DataTable({
            info: false,
            order: [],
            scrollX: true,
            ajax: {
                url: "/home/customers/data",
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
                }
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
                        return `<img class="cat-thumb" src="${data.image}" alt="Customer Image" />`;
                    },
                },
                {
                    orderable: false,
                    targets: 2,
                    render: function (data) {
                        return data.name + ' ' + data.lastname;
                    },
                },
                {
                    orderable: false,
                    targets: 3,
                    render: function (data) {
                        return data.dni;
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
                    className: 'text-end',
                    render: function (data) {
                        // Verifica si el estado es inactivo para decidir el texto del botón
                        var deleteButtonText = data.status === 0 ? 'Restore' : 'Delete';

                        return `<div class="btn-group mb-1">
                            <button type="button" class="btn btn-outline-success info-customer" data-id="${data.id}">${lang.t('Products')}</button>
                            <button type="button"
                                class="btn btn-outline-success dropdown-toggle dropdown-toggle-split"
                                data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false" data-display="static">
                                <span class="sr-only">${lang.t('Products')}</span>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item edit-customer" data-id="${data.id}" href="#">${lang.t('Edit')}</a>
                                <a class="dropdown-item delete-customer" data-id="${data.id}" data-status="${data.status}" href="#">${lang.t(deleteButtonText)}</a>
                            </div>
                        </div>`;
                    },
                }
            ],
        });
    }

    // Eliminar almacén
    customerDataTable.on('click', '.delete-customer', function (e) {
        e.preventDefault();

        var customerId = $(this).data('id');
        var customerStatus = $(this).data('status');

        var confirmMessage = customerStatus === 1 ? lang.t('Are you sure you want to delete this customer?') : lang.t('Do you want to restore this customer?');

        Swal.fire({
            title: lang.t('Confirm'),
            text: confirmMessage,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: lang.t('Yes'),
            cancelButtonText: lang.t('Cancel')
        }).then((result) => {
            if (result.isConfirmed) {
                var url = customerStatus === 1 ? '/home/customers/delete=' + customerId : '/home/customers/restore=' + customerId;

                // Realizar la solicitud POST para cambiar el estado del almacén
                $.ajax({
                    url: url,
                    method: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        id: customerId
                    },
                    success: function (response) {
                        // Actualizar la tabla después de cambiar el estado del almacén
                        customerDataTable.DataTable().ajax.reload();
                        Swal.fire(lang.t('Éxito'), response.message, 'success');
                    },
                    error: function (xhr) {
                        console.error(lang.t('Error when changing the customer status:'), xhr.responseText);
                        Swal.fire(lang.t('Error'), lang.t('There was an error changing the customer status.'), 'error');
                    }
                });
            }
        });
    });

    // Completa los campos con los datos correspondientes
    customerDataTable.on('click', '.edit-customer', function (e) {
        e.preventDefault();

        var customerId = $(this).data('id');

        $.ajax({
            url: '/home/customers/edit=' + customerId,
            method: 'GET',
            success: function (customerData) {
                $('#edit-social-reason').val(customerData.social_reason);
                $('#edit-name').val(customerData.name);
                $('#edit-lastname').val(customerData.lastname);
                $('#edit-dni').val(customerData.dni);
                $('#edit-status').val(customerData.status);
                $('#edit-email').val(customerData.email);
                $('#edit-phone').val(customerData.phone);
                $('#edit-mobile').val(customerData.mobile);
                $('#edit-address').val(customerData.address);
                $('#edit-location').val(customerData.location);
                $('#edit-details').val(customerData.details);

                var customerImage = customerData.image ? customerData.image : customerData.image;
                $('#defaultImageEdit').attr('src', customerImage);

                // Manejar cambios en el input file para previsualizar la nueva imagen
                $('#coverImageEdit').on('change', function () {
                    var input = this;

                    if (input.files && input.files[0]) {
                        var reader = new FileReader();

                        reader.onload = function (e) {
                            $('#defaultImageEdit').attr('src', e.target.result);
                        };

                        reader.readAsDataURL(input.files[0]);
                    } else {
                        // Si se deja en blanco, volver a mostrar la imagen actual
                        $('#defaultImageEdit').attr('src', customerImage);
                    }
                });
                // Configurar los atributos del formulario
                $('#editCustomerForm').attr('enctype', 'multipart/form-data');
                $('#editCustomerForm').attr('action', '/home/customers/edit=' + customerId);
                $('#editCustomerForm').attr('method', 'POST');
            },
            error: function (xhr) {
                console.error('Error al obtener datos del proveedor:', xhr.responseText);
            }
        });

        // Mostrar el modal después de configurar los atributos del formulario
        $('#editCustomerModal').modal('show');
    });

    // Info Customer
    customerDataTable.on('customer', '.info-customer', function(e) {
        e.preventDefault();
        var customerId = $(this).data('id');
        window.location.href = '/home/customers/profile=' + customerId ;
    });

    // Download Template
    $('.template').on('click', function () {
        // URL de la plantilla que se va a descargar
        var templateUrl = '/admin/templates/customers.csv'; // Reemplaza con la ruta correcta de tu plantilla

        // Crear un enlace temporal para la descarga
        var link = document.createElement('a');
        link.href = templateUrl;
        link.download = 'plantilla_customers.csv'; // Nombre del archivo a descargar

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
                        url: '/home/customers/import',
                        method: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            console.log(response.message);
                            // Puedes recargar la tabla aquí
                            if (typeof customerDataTable !== 'undefined') {
                                toastr.success('Importación exitosa');
                                setTimeout(function () {
                                    // customerDataTable.DataTable().ajax.reload();
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
        window.location.href = '/home/customers/export';
    });
});

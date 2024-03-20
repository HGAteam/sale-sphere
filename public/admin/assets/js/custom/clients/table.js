$(document).ready(function () {
    "use strict";

    var clientDataTable = $("#clients-data-table");

    if (clientDataTable.length !== 0) {
        clientDataTable.DataTable({
            info: false,
            order: [],
            scrollX: true,
            ajax: {
                url: "/home/clients/data",
            },
            "aLengthMenu": [[20, 30, 50, 75, -1], [20, 30, 50, 75, "All"]],
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
                            return `<img class="cat-thumb" src="${data.image}" alt="Client Image" />`;
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
                    render: function (data, row) {
                        return `<div class="btn-group mb-1">
                                                <button type="button"
                                                    class="btn btn-outline-success info-client">${lang.t('Info')}</button>
                                                <button type="button"
                                                    class="btn btn-outline-success dropdown-toggle dropdown-toggle-split"
                                                    data-bs-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false" data-display="static">
                                                    <span class="sr-only">${lang.t('Info')}</span>
                                                </button>

                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item edit-client" data-id="${data.id}" href="#">${lang.t('Edit')}</a>
                                                    <a class="dropdown-item delete-client" data-id="${data.id}" data-status="${data.status}" href="#">${lang.t('Delete')}</a>
                                                </div>
                                            </div>`;
                    },
                }
            ],
        });
    }

    // Eliminar
    clientDataTable.on('click', '.delete-client', function (e) {
        e.preventDefault();

        var clientId = $(this).data('id');
        var clientStatus = $(this).data('status');

        // Verificar si el proveedor está activo antes de permitir la eliminación
        if (clientStatus === "Active") {
            // Realizar la solicitud POST para cambiar el estado del proveedor
            $.ajax({
                url: '/home/clients/delete=' + clientId,
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    id: clientId
                },
                success: function (response) {
                    // Actualizar la tabla después de cambiar el estado del proveedor
                    clientDataTable.DataTable().ajax.reload();
                },
                error: function (xhr) {
                    console.error(lang.t('Error when changing client status') + ':', xhr.responseText);
                }
            });
        } else {
            // El proveedor ya está inactivo, muestra un mensaje o realiza otra acción
            console.log('Este proveedor ya está inactivo.');
        }
    });

    // Completa los campos con los datos correspondientes
    clientDataTable.on('click', '.edit-client', function (e) {
        e.preventDefault();

        var clientId = $(this).data('id');

        $.ajax({
            url: '/home/clients/edit=' + clientId,
            method: 'GET',
            success: function (clientData) {
                $('#edit-social-reason').val(clientData.social_reason);
                $('#edit-name').val(clientData.name);
                $('#edit-lastname').val(clientData.lastname);
                $('#edit-dni').val(clientData.dni);
                $('#edit-status').val(clientData.status);
                $('#edit-email').val(clientData.email);
                $('#edit-phone').val(clientData.phone);
                $('#edit-mobile').val(clientData.mobile);
                $('#edit-address').val(clientData.address);
                $('#edit-location').val(clientData.location);
                $('#edit-details').val(clientData.details);

                var clientImage = clientData.image ? '/' + clientData.image : '/admin/assets/img/category/clothes.png';
                $('#defaultImageEdit').attr('src', clientImage);

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
                        $('#defaultImageEdit').attr('src', clientImage);
                    }
                });
                // Configurar los atributos del formulario
                $('#editClientForm').attr('enctype', 'multipart/form-data');
                $('#editClientForm').attr('action', '/home/clients/edit=' + clientId);
                $('#editClientForm').attr('method', 'POST');
            },
            error: function (xhr) {
                console.error('Error al obtener datos del proveedor:', xhr.responseText);
            }
        });

        // Mostrar el modal después de configurar los atributos del formulario
        $('#editClientModal').modal('show');
    });

    // Modal Info
    // clientDataTable.on('click', '.info-client', function (e) {
    //     var clientId = $(this).data('id');
    //     window.location.href = "/home/clients/profile=" + clientId;
    // });
});

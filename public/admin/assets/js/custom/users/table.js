$(document).ready(function () {
    "use strict";

    var userDataTable = $("#users-data-table");

    if (userDataTable.length !== 0) {
        userDataTable.DataTable({
            info: false,
            order: [],
            scrollX: true,
            ajax: {
                url: "/home/users/data",
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
                            return `<img class="cat-thumb" src="${data.avatar}" alt="User Avatar" />`;
                    },
                },
                {
                    orderable: false,
                    targets: 2,
                    render: function (data) {
                        return data.name;
                    },
                },
                {
                    orderable: false,
                    targets: 3,
                    render: function (data) {
                        return `${lang.t(data.role)}`;
                    },
                },
                {
                    orderable: false,
                    targets: 4,
                    render: function (data) {
                        return data.email;
                    },
                },
                {
                    orderable: false,
                    targets: 5,
                    render: function (data) {
                        if (!data.phone) {
                            return `<span class="badge badge-danger">${lang.t('No Phone')}</span>`;
                        return `${lang.t(data.role)}`;
                    } else {
                            return data.phone;
                        }
                    },
                },
                {
                    orderable: false,
                    targets: 6,
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
                    targets: 7,
                    render: function (data) {
                        if (data.status == 0) {
                            return `<span class="badge badge-secondary">${lang.t('Inactive')}</span>`;
                        } else {
                            return `<span class="badge badge-success">${lang.t('Active')}</span>`;
                        }
                    },
                },
                {
                    orderable: false,
                    targets: 8,
                    render: function (data) {
                        return data.created_at;
                    },
                },
                {
                    orderable: false,
                    targets: 9,
                    className: 'text-end',
                    render: function (data) {
                        return `<div class="btn-group mb-1">
                                                <button type="button" class="btn btn-outline-success info-user" data-id="${data.id}">${lang.t('Info')}</button>
                                                <button type="button"
                                                    class="btn btn-outline-success dropdown-toggle dropdown-toggle-split"
                                                    data-bs-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false" data-display="static">
                                                    <span class="sr-only">${lang.t('Info')}</span>
                                                </button>

                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item edit-user" data-id="${data.id}" href="#">${lang.t('Edit')}</a>
                                                    <a class="dropdown-item delete-user" data-id="${data.id}" data-status="${data.status}" href="#">${lang.t('Delete')}</a>
                                                </div>
                                            </div>`;
                    },
                }
            ],
        });
    }

    // Eliminar
    userDataTable.on('click', '.delete-user', function (e) {
        e.preventDefault();

        var userId = $(this).data('id');
        var userStatus = $(this).data('status');

        // Verificar si el usuario está activo antes de permitir la eliminación
        if (userStatus === 1) {
            // Realizar la solicitud POST para cambiar el estado del usuario
            $.ajax({
                url: '/home/users/delete=' + userId,
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    id: userId
                },
                success: function (response) {
                    // Actualizar la tabla después de cambiar el estado del usuario
                    userDataTable.DataTable().ajax.reload();
                },
                error: function (xhr) {
                    console.error(lang.t('Error when changing user status') + ':', xhr.responseText);
                }
            });
        } else {
            // El usuario ya está inactivo, muestra un mensaje o realiza otra acción
            console.log('Este usuario ya está inactivo.');
        }
    });

    // Completa los campos con los datos correspondientes
    userDataTable.on('click', '.edit-user', function (e) {
        e.preventDefault();

        var userId = $(this).data('id');

        $.ajax({
            url: '/home/users/edit=' + userId,
            method: 'GET',
            success: function (userData) {
                $('#edit-name').val(userData.name);
                $('#edit-lastname').val(userData.lastname);
                $('#edit-role').val(userData.role);
                $('#edit-email').val(userData.email);
                $('#edit-phone').val(userData.phone);
                $('#edit-mobile').val(userData.mobile);
                $('#edit-address').val(userData.address);
                $('#edit-location').val(userData.location);

                // Mostrar la imagen del usuario si existe, de lo contrario, mostrar la imagen por defecto
                var userImage = userData.avatar ;
                $('#defaultImageEdit').attr('src', userImage);

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
                        $('#defaultImageEdit').attr('src', userImage);
                    }
                });

                // Configurar los atributos del formulario
                $('#editUserForm').attr('enctype', 'multipart/form-data');
                $('#editUserForm').attr('action', '/home/users/edit=' + userId);
                $('#editUserForm').attr('method', 'POST');
            },
            error: function (xhr) {
                console.error('Error al obtener datos del usuario:', xhr.responseText);
            }
        });

        // Mostrar el modal después de configurar los atributos del formulario
        $('#editUserModal').modal('show');
    });

    // Modal Info
    userDataTable.on('click', '.info-user', function (e) {
        var userId = $(this).data('id');
        window.location.href = "/home/users/profile=" + userId;
    });

    // Download Template
    $('.template').on('click', function () {
        // URL de la plantilla que se va a descargar
        var templateUrl = '/admin/templates/users.csv';

        // Crear un enlace temporal para la descarga
        var link = document.createElement('a');
        link.href = templateUrl;
        // Nombre del archivo a descargar
        link.download = 'plantilla_users.csv';

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
                        url: '/home/users/import',
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
        window.location.href = '/home/users/export';
    });
});

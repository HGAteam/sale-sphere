$(document).ready(function () {
    "use strict";

    var brandDataTable = $("#brands-data-table");

    if (brandDataTable.length !== 0) {
        brandDataTable.DataTable({
            info: false,
            order: [],
            scrollX: true,
            ajax: {
                url: "/home/brands/data",
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
                        if (!data.image) {
                            return `<img class="cat-thumb" src="/admin/assets/img/category/clothes.png" alt="Brand Image" />`;
                        } else {
                            return `<img class="cat-thumb" src="/${data.image}" alt="Brand Image" />`;
                        }
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
                        switch (data.status) {
                            case 'Published':
                                return `<span class="badge badge-success">${lang.t('Published')}</span>`;
                                break;
                            case 'Unpublished':
                                return `<span class="badge badge-warning">${lang.t('Unpublished')}</span>`;
                                break;
                            case 'Deleted':
                                return `<span class="badge badge-danger">${lang.t('Deleted')}</span>`;
                                break;
                            default:
                                return `<span class="badge badge-secondary">${lang.t('Draft')}</span>`;
                                break;
                        }
                    },
                },
                {
                    orderable: false,
                    targets: 4,
                    render: function (data) {
                        return data.created_at;
                    },
                },
                {
                    orderable: false,
                    targets: 5,
                    className: 'text-end',
                    render: function (data) {
                        return `<div class="btn-group mb-1">
                                                <button type="button" class="btn btn-outline-success">${lang.t('Actions')}</button>
                                                <button type="button"
                                                    class="btn btn-outline-success dropdown-toggle dropdown-toggle-split"
                                                    data-bs-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false" data-display="static">
                                                    <span class="sr-only">${lang.t('Actions')}</span>
                                                </button>

                                                <div class="dropdown-menu">
                                                <a class="dropdown-item edit-brand" data-id="${data.id}" href="#">${lang.t('Edit')}</a>
                                                <a class="dropdown-item delete-brand" data-id="${data.id}" data-status="${data.status}" href="#">${lang.t('Delete')}</a>
                                                </div>
                                            </div>`;
                    },
                }
            ],
        });
    }

    // Eliminar
    brandDataTable.on('click', '.delete-brand', function (e) {
        e.preventDefault();

        var brandId = $(this).data('id');
        var brandStatus = $(this).data('status');

        // Verificar si la marca está publicada o no publicada antes de permitir la eliminación
        if (brandStatus == 'Published' || brandStatus == 'Unpublished' || brandStatus == 'Draft') {
            // Realizar la solicitud POST para cambiar el estado del usuario
            $.ajax({
                url: '/home/brands/delete=' + brandId,
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    id: brandId
                },
                success: function (response) {
                    // Actualizar la tabla después de cambiar el estado del usuario
                    brandDataTable.DataTable().ajax.reload();
                },
                error: function (xhr) {
                    console.error(lang.t('Error when changing brand status') + ':', xhr.responseText);
                }
            });
        } else {
            // El usuario ya está inactivo, muestra un mensaje o realiza otra acción
            console.log('Esta marca ya no está publicada.');
        }
    });

    // Editar - Completa los campos con los datos correspondientes
    brandDataTable.on('click', '.edit-brand', function (e) {
        e.preventDefault();

        var brandId = $(this).data('id');

        $.ajax({
            url: '/home/brands/edit=' + brandId,
            method: 'GET',
            success: function (brandData) {
                $('#edit-name').val(brandData.name);
                $('#edit-details').val(brandData.details);
                $('#edit-status').val(brandData.status);

                // Mostrar la imagen del usuario si existe, de lo contrario, mostrar la imagen por defecto
                var brandImage = brandData.image ? '/' + brandData.image : '/admin/assets/img/category/clothes.png';
                $('#defaultImageEdit').attr('src', brandImage);

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
                        $('#defaultImageEdit').attr('src', brandImage);
                    }
                });

                // Configurar los atributos del formulario
                $('#editBrandForm').attr('enctype', 'multipart/form-data');
                $('#editBrandForm').attr('action', '/home/brands/edit=' + brandId);
                $('#editBrandForm').attr('method', 'POST');
            },
            error: function (xhr) {
                console.error('Error al obtener datos del usuario:', xhr.responseText);
            }
        });

        // Mostrar el modal después de configurar los atributos del formulario
        $('#editBrandModal').modal('show');
    });

    // Modal Info
    brandDataTable.on('click', '.info-brand', function (e) {
        var brandId = $(this).data('id');
        console.log("MODAL OPEN: " + brandId);
        // window.location.href = "/home/brands/profile=" + brandId;
    });

});

$(document).ready(function () {
    "use strict";

    var categoryDataTable = $("#categories-data-table");

    if (categoryDataTable.length !== 0) {
        categoryDataTable.DataTable({
            info: false,
            order: [],
            scrollX: true,
            ajax: {
                url: "/home/categories/data",
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
                            return `<img class="cat-thumb" src="${data.image}" alt="Category Image" />`;
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
                                                <a class="dropdown-item edit-category" data-id="${data.id}" href="#">${lang.t('Edit')}</a>
                                                <a class="dropdown-item delete-category" data-id="${data.id}" data-status="${data.status}" href="#">${lang.t('Delete')}</a>
                                                </div>
                                            </div>`;
                    },
                }
            ],
        });
    }

    // Eliminar
    categoryDataTable.on('click', '.delete-category', function (e) {
        e.preventDefault();

        var categoryId = $(this).data('id');
        var categoryStatus = $(this).data('status');

        // Verificar si la categoria está publicada o no publicada antes de permitir la eliminación
        if (categoryStatus == 'Published' || categoryStatus == 'Unpublished' || categoryStatus == 'Draft') {
            // Realizar la solicitud POST para cambiar el estado del usuario
            $.ajax({
                url: '/home/categories/delete=' + categoryId,
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    id: categoryId
                },
                success: function (response) {
                    // Actualizar la tabla después de cambiar el estado del usuario
                    categoryDataTable.DataTable().ajax.reload();
                },
                error: function (xhr) {
                    console.error(lang.t('Error when changing category status') + ':', xhr.responseText);
                }
            });
        } else {
            // El usuario ya está inactivo, muestra un mensaje o realiza otra acción
            console.log('Esta categoria ya no está publicada.');
        }
    });

    // Editar - Completa los campos con los datos correspondientes
    categoryDataTable.on('click', '.edit-category', function (e) {
        e.preventDefault();

        var categoryId = $(this).data('id');

        $.ajax({
            url: '/home/categories/edit=' + categoryId,
            method: 'GET',
            success: function (categoryData) {
                $('#edit-name').val(categoryData.name);
                $('#edit-details').val(categoryData.details);
                $('#edit-status').val(categoryData.status);

                // Mostrar la imagen del usuario si existe, de lo contrario, mostrar la imagen por defecto
                var categoryImage = categoryData.image ? categoryData.image : categoryData.image;
                $('#defaultImageEdit').attr('src', categoryImage);

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
                        $('#defaultImageEdit').attr('src', categoryImage);
                    }
                });

                // Configurar los atributos del formulario
                $('#editCategoryForm').attr('enctype', 'multipart/form-data');
                $('#editCategoryForm').attr('action', '/home/categories/edit=' + categoryId);
                $('#editCategoryForm').attr('method', 'POST');
            },
            error: function (xhr) {
                console.error('Error al obtener datos del usuario:', xhr.responseText);
            }
        });

        // Mostrar el modal después de configurar los atributos del formulario
        $('#editCategoryModal').modal('show');
    });

    // Modal Info
    categoryDataTable.on('click', '.info-category', function (e) {
        var categoryId = $(this).data('id');
        console.log("MODAL OPEN: " + categoryId);
        // window.location.href = "/home/categories/profile=" + categoryId;
    });

});

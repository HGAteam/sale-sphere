$(document).ready(function () {
    "use strict";
    $('[data-bs-toggle="tooltip"]').tooltip();
    var productDataTable = $("#products-data-table");
    // Declarar la variable table en un ámbito superior

    // Table
    if (productDataTable.length !== 0) {
        productDataTable.DataTable({
            select: {
                style: 'multi'
            },
            info: false,
            order: [],
            scrollX: true,
            ajax: {
                url: "/home/products/data",
            },
            "aLengthMenu": [[20, 30, 50, 75, -1], [20, 30, 50, 75, lang.t("All")]],
            "pageLength": 20,
            "dom": '<"row justify-content-between top-information"lf>rt<"row justify-content-between bottom-information"ip><"clear">',
            language: {
                "sProcessing": lang.t("Processing") + "...",
                "sLengthMenu": lang.t("Show") + "_MENU_" + lang.t("entries"),
                "sZeroRecords": lang.t("No matching records found"),
                "sEmptyTable": lang.t("No data available in table"),
                "sInfo": "Showing _START_ to _END_ of _TOTAL_ entries",
                "sInfoEmpty": "Showing 0 to 0 of 0 entries",
                "sInfoFiltered": "(filtered from _MAX_ total entries)",
                "sInfoPostFix": "",
                "sSearch": lang.t("Search") + ":",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": lang.t("Loading") + "...",
                "oPaginate": {
                    "sFirst": lang.t("First"),
                    "sLast": lang.t("Last"),
                    "sNext": lang.t("Next"),
                    "sPrevious": lang.t("Previous")
                },
                "oAria": {
                    "sSortAscending": ":" + lang.t("activate to sort column ascending"),
                    "sSortDescending": ":" + lang.t("activate to sort column descending")
                },
            },
            columns: [
                // Configurar las columnas según tus datos
                { data: null },
                { data: null },
                { data: null },
                { data: null },
                { data: null },
                { data: null },
                { data: null },
                { data: null },
                { data: null },
                { data: null },
                { data: null },
                { data: null },
                { data: null },
            ],
            columnDefs: [
                // ID
                {
                    orderable: true,
                    targets: 0,
                    render: function (data, row, type) {
                        return data.id;
                    },
                },
                // NAME
                {
                    orderable: true,
                    searchable: true,
                    targets: 1,
                    render: function (data) {
                        return data.name;
                    },
                },
                // BRAND
                {
                    orderable: false,
                    targets: 2,
                    searchable: true,
                    render: function (data) {
                        return data.brand;
                    },
                },
                // Category
                {
                    orderable: false,
                    targets: 3,
                    render: function (data) {
                        return data.category;
                    },
                },
                // Barcode
                {
                    orderable: true,
                    targets: 4,
                    searchable: true,
                    className: "text-center",
                    render: function (data) {
                        if (!data.barcode) {
                            return `<span class="badge badge-danger">${lang.t('No Barcode')}</span>`;
                        } else {
                            return data.barcode;
                        }
                    },
                },
                // Status
                {
                    orderable: false,
                    targets: 5,
                    render: function (data) {
                        switch (data.status) {
                            case 'Processed':
                                return `<span class="badge badge-success">${lang.t('Processed')}</span>`;
                                break;
                            case 'In Process':
                                return `<span class="badge badge-warning">${lang.t('In Process')}</span>`;
                                break;
                            default:
                                return `<span class="badge badge-info" data-bs-toggle="tooltip" data-bs-placement="top" title="${lang.t('La cantidad queda en 0 si se procesaron en cada sucursal correctamente y el estado cambia a Procesado')}.">${lang.t('To Enter Stock')}</span>`;
                                break;
                        }
                    },
                },
                // Purchase Price
                {
                    orderable: false,
                    targets: 6,
                    className: 'text-center',
                    render: function (data) {
                        return `${'$ ' + data.purchase_price}`;
                    }
                },
                // Selling Price
                {
                    orderable: false,
                    targets: 7,
                    className: 'text-center',
                    render: function (data) {
                        return `${'$ ' + data.selling_price}`;
                    },
                },
                // Wholesale Price
                {
                    orderable: false,
                    targets: 8,
                    className: 'text-center',
                    render: function (data) {
                        return `${'$ ' + data.wholesale_price}`;
                    },
                },
                // Quantity
                {
                    orderable: false,
                    targets: 9,
                    className: 'text-center',
                    render: function (data) {
                        return `<button type="button" class="btn btn-secondary increase-quantity" data-quantity="${data.quantity}" data-id="${data.id}" data-bs-toggle="tooltip" data-bs-placement="top" title="${lang.t('Increase Quantity')}">${lang.t(data.quantity)}</button>`;
                    },
                },
                // Unit
                {
                    orderable: false,
                    targets: 10,
                    className: 'text-center',
                    render: function (data) {
                        return `${lang.t(data.unit)}`;
                    },
                },
                // Updated On
                {
                    orderable: false,
                    targets: 11,
                    render: function (data) {
                        return data.updated_at;
                    },
                },
                // Actions
                {
                    orderable: false,
                    targets: 12,
                    className: 'text-end',
                    render: function (data, type, row) {
                        return `<div class="btn-group mb-1">
                            <button type="button" class="btn btn-outline-success">${lang.t('Actions')}</button>
                            <button type="button"
                                class="btn btn-outline-success dropdown-toggle dropdown-toggle-split"
                                data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false" data-display="static">
                                <span class="sr-only">${lang.t('Actions')}</span>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item edit-product" data-id="${row.id}" data-status="${row.status}"href="#" >${lang.t('Edit')}</a>
                                <a class="dropdown-item delete-product" data-id="${row.id}" data-status="${row.status}" href="#">${lang.t('Delete')}</a>
                            </div>
                        </div>`;
                    },
                }
            ],
            // buttons: [
            //     {
            //         text: lang.t('Import'),
            //         className: 'btn btn-warning ml-2 import',
            //     },
            //     {
            //         text: lang.t('Export'),
            //         className: 'btn btn-info ml-2 export',
            //     },
            //     {
            //         text: lang.t('Template'),
            //         className: 'btn btn-secondary ml-2 template',
            //     },
            //     {
            //         text: lang.t('Increase Prices'),
            //         className: 'btn btn-success ml-2 increase-prices',
            //     },
            // ],
        });
        // }).buttons().container().appendTo('.dt-buttons');
        // window.productDataTable = table;
    }

    // Manage click on the "Add Product" button.
    $('#btnSaveNew').on('click', function (e) {
        e.preventDefault();
        // Obtener el token CSRF
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        // Obtener datos del formulario y agregar el token CSRF
        var formData = new FormData($('#newProductForm')[0]);
        formData.append('_token', csrfToken);

        // Mostrar datos en la consola antes de enviar la solicitud
        console.log(formData);

        // Realizar la solicitud POST para guardar los cambios
        $.ajax({
            url: '/home/products/create',
            method: 'POST',
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
                $('#newProductModal').modal('hide');
                $('#newProductForm')[0].reset();

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

    // Cancel "Add Product"
    $('#btnCancelNew').on('click', function (e) {
        $('#newProductForm')[0].reset();
        $('#newProductModal').modal('hide');
    });

    // Download Template
    $('.template').on('click', function () {
        // URL de la plantilla que se va a descargar
        var templateUrl = '/admin/templates/products.csv'; // Reemplaza con la ruta correcta de tu plantilla

        // Crear un enlace temporal para la descarga
        var link = document.createElement('a');
        link.href = templateUrl;
        link.download = 'plantilla_products.csv'; // Nombre del archivo a descargar

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
                        url: '/home/products/import',
                        method: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            console.log(response.message);
                            // Puedes recargar la tabla aquí
                            if (typeof productDataTable !== 'undefined') {
                                toastr.success('Importación exitosa');
                                setTimeout(function () {
                                    // productDataTable.DataTable().ajax.reload();
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
        window.location.href = '/home/products/export';
    });

    // Delete
    productDataTable.on('click', '.delete-product', function (e) {
        e.preventDefault();

        var productId = $(this).data('id');
        var productStatus = $(this).data('status');

        // Verificar si el usuario está activo antes de permitir la eliminación
        if (productStatus != 'Deleted') {
            // Realizar la solicitud POST para cambiar el estado del usuario
            $.ajax({
                url: '/home/products/delete=' + productId,
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    id: productId
                },
                success: function (response) {
                    // Actualizar la tabla después de cambiar el estado del usuario
                    productDataTable.DataTable().ajax.reload();
                },
                error: function (xhr) {
                    console.error(lang.t('Error when changing product status') + ':', xhr.responseText);
                }
            });
        } else {
            // El usuario ya está inactivo, muestra un mensaje o realiza otra acción
            console.log('Este producto ya está inactivo.');
        }
    });

    // Edit
    productDataTable.on('click', '.edit-product', function (e) {
        e.preventDefault();

        var productId = $(this).data('id');
        // console.log(productId);

        // Hacer la solicitud AJAX para obtener los detalles del producto
        $.ajax({
            url: '/home/products/edit=' + productId,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                // Rellenar datos en el modal

                $('#edit_name').val(data.name);
                $('#edit_barcode').val(data.barcode);
                $('#edit_brands').val(data.brand_id);
                $('#edit_categories').val(data.category_id);
                $('#edit_description').val(data.description);
                // Para un campo de tipo checkbox con id 'edit_require_stock'
                $('#edit_requires_stock').prop('checked', data.requires_stock);
                // Para un campo de tipo checkbox con id 'edit_returnable'
                $('#edit_returnable').prop('checked', data.requires_returnable);
                $('#edit_purchase_price').val(data.purchase_price);
                $('#edit_selling_price').val(data.selling_price);
                $('#edit_wholesale_price').val(data.wholesale_price);
                $('#edit_quantity').val(data.quantity);
                $('#edit_unit').val(data.unit);
                // Mostrar el nombre de la imagen existente
                var existingImageName = data.image ? data.image.split('/').pop() : `${lang.t('No image selected')}`;
                $('#editImageName').text(`${lang.t('Existing Image')}` + ': ' + existingImageName);
                // Mostrar la imagen existente
                var productImage = data.image ? data.image : data.image;
                $('#editImagePreview').attr('src', productImage);
                $('#editProductModal form').attr({
                    'action': '/home/products/edit=' + productId, // Ajusta la URL de acción según tus necesidades
                    'method': 'POST',
                    'enctype': 'multipart/form-data'
                });
                // Mostrar el modal
                $('#editProductModal').modal('show');
            },
            error: function (error) {
                console.error('Error al obtener detalles del producto:', error);
            }
        });
    });

    // Open Increase Quantity
    productDataTable.on('click', '.increase-quantity', function (e) {
        e.preventDefault();

        var productId = $(this).data('id');
        var productQuantity = $(this).data('quantity');

        $.ajax({
            url: '/home/products/edit=' + productId,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                // Rellenar datos en el modal
                $('#product').val(productId);
                $('#current_quantity').val(productQuantity);

                $('#increaseProductQuantityModal form').attr({
                    'action': '/home/products/' + productId + '/increase-quantity', // Ajusta la URL de acción según tus necesidades
                    'method': 'POST',
                    'enctype': 'multipart/form-data'
                });
                $('#increaseProductQuantityModal').modal('show');
            },
            error: function (error) {
                console.error('Error al obtener detalles del producto:', error);
            }
        });
    });

    // Cancel Increase Quantity
    $('#btnCancelProductIncrease').on('click', function () {
        $('#increaseProductQuantityForm')[0].reset();
        $('#increaseProductQuantityModal').modal('hide');
    });

    // Save Product Increase Quantity
    $('#btnProductIncrease').on('click', function (e) {
        e.preventDefault();
        // Obtener el token CSRF
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        // Obtener datos del formulario y agregar el token CSRF
        var formData = new FormData($('#increaseProductQuantityForm')[0]);
        formData.append('_token', csrfToken);

        $.ajax({
            url: $('#increaseProductQuantityForm').attr('action'),
            method: $('#increaseProductQuantityForm').attr('method'),
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
                $('#increaseProductQuantityModal').modal('hide');
                $('#increaseProductQuantityForm')[0].reset();

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

    // Open Change Prices
    $('.increase-prices').on('click', function (e) {
        e.preventDefault();
        $('#IncreasePricesModal').modal('show');
    });

    // Cancel Change Prices
    $('#btnCancelPriceIncrese').on('click', function (e) {
        $('#IncreasePricesForm')[0].reset();
        $('#IncreasePricesModal').modal('hide');
    });

    // Apply Change Prices
    $('#btnApplyPriceIncrease').on('click', function (e) {
        e.preventDefault();
        // Obtener el token CSRF
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        // Obtener datos del formulario y agregar el token CSRF
        var formData = new FormData($('#IncreasePricesForm')[0]);
        formData.append('_token', csrfToken);

        $.ajax({
            url: '/home/products/product-increase-prices',
            method: 'POST',
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
                $('#IncreasePricesForm')[0].reset();

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
});

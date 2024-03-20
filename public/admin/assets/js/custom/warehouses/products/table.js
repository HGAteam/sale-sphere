$(document).ready(function () {
    "use strict";

    var warehouseDataTable = $("#warehouse-data-table");

    if (warehouseDataTable.length !== 0) {
        warehouseDataTable.DataTable({
            info: false,
            order: [],
            scrollX: true,
            ajax: {
                url: window.location.pathname + '/products',
            },
            "aLengthMenu": [[10, 20, 30, 50, 75, -1], [10, 20, 30, 50, 75, "All"]],
            "pageLength": 10,
            "dom": '<"row justify-content-between top-information"lf>rt<"row justify-content-between bottom-information"ip><"clear">',
            columns: [
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
                            case 'In Stock':
                                return `<span class="badge badge-success">${lang.t('In Stock')}</span>`;
                                break;
                            case 'Out Stock':
                                return `<span class="badge badge-secondary">${lang.t('Out Stock')}</span>`;
                                break;
                            case 'Request Stock':
                                return `<span class="badge badge-warning">${lang.t('Request Stock')}</span>`;
                                break;
                            case 'Empty':
                                return `<span class="badge badge-danger">${lang.t('Empty')}</span>`;
                                break;
                            default:
                                return `<span class="badge badge-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="${lang.t('La cantidad queda en 0 si se procesaron en cada sucursal correctamente y el estado cambia a Procesado')}.">${lang.t('To Enter Stock')}</span>`;
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
                        return `<a href="/home/warehouses/profile=${data.warehouse_id}/products=${data.product_id}/increase-quantity" class="btn btn-secondary increase-quantity" data-quantity="${data.quantity}" data-product="${data.product_id}" data-bs-toggle="tooltip" data-bs-placement="top" title="${lang.t('Increase Quantity')}">${lang.t(data.quantity)}</a>`;
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
                                <a class="dropdown-item edit-product" href="data-id="${row.id}" data-status="${row.status}" href="#" >${lang.t('Edit')}</a>
                                <a class="dropdown-item delete-product" data-id="${row.id}" data-status="${row.status}" href="#">${lang.t('Delete')}</a>
                            </div>
                        </div>`;
                    },
                }
            ],
        });
    }

    // Open Increase Quantity
    warehouseDataTable.on('click', '.increase-quantity', function (e) {
        e.preventDefault();
        var productId = $(this).data('product');
        var productQuantity = $(this).data('quantity');
        // Obtener el valor de href del enlace clicado
        var hrefValue = $(this).attr('href');
        // console.log(hrefValue);

        $('#product').val(productId);
        $('#current_quantity').val(productQuantity);
        // obtener la cantidad total de productos en el stock principal

        $.ajax({
            url: window.location.pathname + '/products=' + productId + '/product-quantity',
            type: 'GET',
            success: function (response) {
                if (response.hasOwnProperty('quantity')) {
                    var quantity = response.quantity;
                    // cantidad obtenida
                    // console.log('Cantidad del producto:', quantity);
                    $('#product_span').text(quantity);
                } else {
                    // Si no existe
                    console.error('El producto no existe');
                }
            },
            error: function (xhr, status, error) {
                console.error('Error al obtener la cantidad del producto:', error);
            }
        });

        $('#increaseProductQuantityForm').attr({
            'action': hrefValue,
            'method': 'POST',
            'enctype': 'multipart/form-data'
        });

        $('#increaseProductQuantityModal').modal('show');
    });

    // Open Validator
    $('.validate-stock').on('click', function (e) {
        e.preventDefault();
        $('#validateStockModal').modal('show');
        $.ajax({
            url: window.location.pathname + '/get-validations',
            type: 'GET',
            success: function (response) {
                if (response.hasOwnProperty('products')) {
                    var products = response.products;
                    loadProductsInModal(products);
                } else {
                    console.error('No se pudieron cargar los productos.');
                }
            },
            error: function (xhr, status, error) {
                console.error('Error al obtener los productos:', error);
            }
        });
    });
    function loadProductsInModal(products) {
        // Limpiar el contenido del modal
        $('#products-container').empty();

        // Iterar sobre los productos y crear los campos correspondientes en el modal
        products.forEach(function (product) {
            var html = `
            <div class="row product">
                <div class="col-sm-6 col-lg-5">
                    <div class="form-group">
                        <label>Nombre del Producto: </label>
                        <input type="text" class="form-control" value="${product.product.name}" disabled>
                    </div>
                </div>
                <div class="col-sm-2 col-lg-2">
                    <div class="form-group">
                        <label>Cantidad: </label>
                        <input type="text" class="form-control" value="${product.quantity}" disabled>
                    </div>
                </div>
                <div class="col-sm-4 col-lg-5">
                    <div class="form-group">
                        <label>Código de Barra: </label>
                        <input type="text" class="form-control barcode-input" data-product-id="${product.product_id}">
                    </div>
                </div>
            </div>
            `;
            $('#products-container').append(html);
        });
    }

    // Manejar el evento de cambio en los campos de código de barras
$('#products-container').on('input', '.barcode-input', function () {
    var barcode = $(this).val();
    var productId = $(this).data('product-id');
    var token = $('meta[name="csrf-token"]').attr('content'); // Obtener el token CSRF de la metaetiqueta

    // Guardar una referencia al contexto actual
    var $this = $(this);

    // Realizar una solicitud AJAX al backend para procesar la validación
    $.ajax({
        url: window.location.pathname + '/process-validation',
        type: 'POST',
        data: {
            _token: token,
            barcode: barcode,
            product_id: productId
        },
        success: function (response) {
            // Ocultar el elemento del producto validado
            $this.closest('.product').hide().remove(); // Remover el elemento del DOM

            toastr.success(response.message);

            // Verificar si es el último elemento
            if ($('#products-container .product').length === 0) {
                // Cerrar el modal
                $('#validateStockModal').modal('hide');
                // Recargar la página
                window.location.reload();
            }
        },
        error: function (xhr, status, error) {
            toastr.error('Error al procesar la validación:', error);
            // console.error('Error al procesar la validación:', error);
        }
    });
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
                // setTimeout(() => {
                    // console.log($('#increaseProductQuantityForm').attr('action'));
                    // Cerrar el modal
                    $('#increaseProductQuantityModal').modal('hide');
                    $('#increaseProductQuantityForm')[0].reset();
                    toastr.success(response.message);
                // }, 1000);

                // Recargar el DataTable
                window.location.reload();
                // warehouseDataTable.DataTable().ajax.reload();
            },
            error: function (xhr) {
                // Mostrar el mensaje de error real y detalles
                console.error(xhr);

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
                    var errorMessage = xhr.responseText || 'Error desconocido';
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: errorMessage,
                    });
                }
            },
        });
    });

    // Cancel Increase Quantity
    $('#btnCancelProductIncrease').on('click', function () {
        $('#increaseProductQuantityForm')[0].reset();
        $('#increaseProductQuantityModal').modal('hide');
    });

    // Cancel Add Product Button
    $('#btnCancelAddProduct').on('click', function () {
        $('#addProductsToWarehouseForm')[0].reset();
        $('#addProductsToWarehouse').modal('hide');
    });

    // Cancel Validation Stock
    $('#btnCancelValidationStock').on('click', function (e) {
        e.preventDefault();
        $('#validateStockForm')[0].reset();
        $('#validateStockModal').modal('hide');
    });

    $('#closeValidateStock').on('click', function (e) {
        e.preventDefault();
        $('#validateStockForm')[0].reset();
        $('#validateStockModal').modal('hide');
    });
});

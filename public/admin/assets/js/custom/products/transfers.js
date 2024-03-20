$(document).ready(function () {
    "use strict";
    $('[data-bs-toggle="tooltip"]').tooltip();
    var transferDataTable = $("#transfers-data-table");

    if (transferDataTable.length !== 0) {
        transferDataTable.DataTable({
            info: false,
            order: [],
            scrollX: true,
            ajax: {
                url: "/home/products/transfers/data",
            },
            "aLengthMenu": [[20, 30, 50, 75, -1], [20, 30, 50, 75, "All"]],
            "pageLength": 20,
            "dom": '<"row justify-content-between top-information"lfB>rt<"row justify-content-between bottom-information"ip><"clear">',
            language: {
                "sProcessing": lang.t("Processing") + "...",
                "sLengthMenu": lang.t("Show") + "_MENU_" + lang.t("entries"),
                "sZeroRecords": lang.t("No matching records found"),
                "sEmptyTable": lang.t("No data available in table"),
                "sSearch": lang.t("Search") + ":",
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
                // WAREHOUSE FROM
                {
                    orderable: false,
                    targets: 1,
                    className: "text-center",
                    render: function (data) {
                        return data.from_warehouse;
                    },
                },
                // WAREHOUSE TO
                {
                    orderable: false,
                    targets: 2,
                    className: "text-center",
                    render: function (data) {
                        return data.to_warehouse;
                    },
                },
                // PRODUCT
                {
                    orderable: false,
                    targets: 3,
                    render: function (data) {
                        return data.product;
                    },
                },
                // Quantity
                {
                    orderable: false,
                    targets: 4,
                    className: "text-center",
                    render: function (data) {
                        return data.quantity;
                    },
                },
                // Status
                {
                    orderable: false,
                    targets: 5,
                    className: "text-center",
                    render: function (data) {
                        switch (data.status) {
                            case 'In Progress':
                                return `<span class="badge badge-primary">${lang.t('In Progress')}</span>`;
                                break;
                            case 'Transfered':
                                return `<span class="badge badge-success">${lang.t('Transfered')}</span>`;
                                break;
                            default:
                                return `<span class="badge badge-danger">${lang.t('Canceled')}</span>`;
                                break;
                        }
                    },
                },
                // Details
                {
                    orderable: false,
                    targets: 6,
                    render: function (data) {
                        return data.details;
                    },
                },
                // Created At
                {
                    orderable: false,
                    targets: 7,
                    render: function (data) {
                        return data.created_at;
                    },
                },
                // Updated At
                {
                    orderable: false,
                    targets: 8,
                    render: function (data) {
                        return data.updated_at;
                    },
                },
                // Actions
                {
                    orderable: false,
                    targets: 9,
                    className: 'text-end',
                    render: function (data, type, row) {
                        if (data.status == 'In Progress') {
                            return `<div class="btn-group mb-1">
                            <button type="button" class="btn btn-outline-success">${lang.t('Actions')}</button>
                            <button type="button"
                            class="btn btn-outline-success dropdown-toggle dropdown-toggle-split"
                            data-bs-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false" data-display="static">
                            <span class="sr-only">${lang.t('Actions')}</span>
                            </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item process-transfer" data-id="${row.id}" data-status="${row.status}" href="#">${lang.t('Process')}</a>
                                    <a class="dropdown-item cancel-transfer" data-id="${row.id}" data-status="${row.status}" href="#">${lang.t('Cancel')}</a>
                                </div>
                            </div>`;
                        }else{
                            switch (data.status) {
                                case 'Transfered':
                                    return `<span class="badge badge-success">${lang.t('Transfered')}</span>`;
                                    break;
                                default:
                                    return `<span class="badge badge-danger">${lang.t('Canceled')}</span>`;
                                    break;
                            }
                        }
                    },
                }
            ],
        });
    }

    // Cancel
    transferDataTable.on('click', '.cancel-transfer', function (e) {
        e.preventDefault();

        var transferId = $(this).data('id');
        var transferStatus = $(this).data('status');

        // Verificar si el usuario está activo antes de permitir la eliminación
        if (transferStatus === 'In Progress') {
            // Realizar la solicitud POST para cambiar el estado del usuario
            $.ajax({
                url: '/home/products/transfers/cancel=' + transferId,
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    id: transferId
                },
                success: function (response) {
                    // Actualizar la tabla después de cambiar el estado del usuario
                    transferDataTable.DataTable().ajax.reload();
                },
                error: function (xhr) {
                    console.error(lang.t('Error when changing transfer status') + ':', xhr.responseText);
                }
            });
        } else {
            // El usuario ya está inactivo, muestra un mensaje o realiza otra acción
            console.log('La transferencia ya se actualizo con aterioridad');
        }
    });

    // Process
    transferDataTable.on('click', '.process-transfer', function (e) {
        e.preventDefault();

        var transferId = $(this).data('id');
        var transferStatus = $(this).data('status');

        // Verificar si el usuario está activo antes de permitir la eliminación
        if (transferStatus === 'In Progress') {
            // Realizar la solicitud POST para cambiar el estado del usuario
            $.ajax({
                url: '/home/products/transfers/process=' + transferId,
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    id: transferId
                },
                success: function (response) {
                    // Actualizar la tabla después de cambiar el estado del usuario
                    transferDataTable.DataTable().ajax.reload();
                },
                error: function (xhr) {
                    console.error(lang.t('Error when changing transfer status') + ':', xhr.responseText);
                }
            });
        } else {
            // El usuario ya está inactivo, muestra un mensaje o realiza otra acción
            console.log('La transferencia ya se actualizo con aterioridad');
        }
    });
});

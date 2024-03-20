$(document).ready(function () {
    "use strict";

    var clientDataTable = $("#cash_registers-data-table");

    if (clientDataTable.length !== 0) {
        clientDataTable.DataTable({
            info: false,
            order: [],
            scrollX: true,
            ajax: {
                url: "/home/cash-registers/data",
            },
            "aLengthMenu": [[20, 30, 50, 75, -1], [20, 30, 50, 75, "All"]],
            "pageLength": 20,
            "dom": `<"row justify-content-between top-information"lf>rt<"row justify-content-between bottom-information"ip><"clear">`,
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
                // Warehouse
                {
                    orderable: false,
                    targets: 1,
                    render: function (data) {
                        return data.warehouse
                    },
                },
                // User
                {
                    orderable: false,
                    targets: 2,
                    render: function (data) {
                        return data.user;
                    },
                },
                // Name
                {
                    orderable: false,
                    targets: 3,
                    render: function (data) {
                        return data.name;
                    },
                },
                // Status
                {
                    orderable: false,
                    targets: 4,
                    render: function (data) {
                        switch (data.status) {
                            case 'Open':
                                return `<span class="badge badge-success">Open</span>`;
                                break;
                            default:
                                return `<span class="badge badge-secondary">Closed</span>`;
                                break;
                        }
                    },
                },
                // Balance
                {
                    orderable: false,
                    targets: 5,
                    render: function (data) {
                        return data.balance;
                    },
                },
                // Opening Balance
                {
                    orderable: false,
                    targets: 6,
                    render: function (data) {
                        if (!data.opening_balance) {
                            reurn`<span class="badge badge-success">Not Closed</span>`;
                        }
                        return data.opening_balance;
                    },
                },
                // Closing Balance
                {
                    orderable: false,
                    targets: 7,
                    render: function (data) {
                        if (!data.closing_balance) {
                            reurn`<span class="badge badge-success">Not Closed</span>`;
                        }
                        return data.closing_balance;
                    },
                },
                // Creatd On
                {
                    orderable: false,
                    targets: 8,
                    render: function (data) {
                        return data.created_at;
                    },
                },
                // Updated On
                {
                    orderable: false,
                    targets: 9,
                    render: function (data) {
                        return data.updated_at;
                    },
                },
                // Action
                {
                    orderable: false,
                    targets: 10,
                    className: 'text-end',
                    render: function (data) {
                        return `<div class="btn-group mb-1">
                                                <button type="button"
                                                    class="btn btn-outline-success">Info</button>
                                                <button type="button"
                                                    class="btn btn-outline-success dropdown-toggle dropdown-toggle-split"
                                                    data-bs-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false" data-display="static">
                                                    <span class="sr-only">Info</span>
                                                </button>

                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="#">Edit</a>
                                                    <a class="dropdown-item" href="#">Delete</a>
                                                </div>
                                            </div>`;
                    },
                }
            ],
        });
    }

});

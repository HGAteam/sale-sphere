@extends('layouts.app')
@section('styles')
    <!-- Data Tables -->
    <link href="{{ asset('admin/assets/plugins/data-tables/datatables.bootstrap5.min.css') }}" rel='stylesheet'>
    <link href="{{ asset('admin/assets/plugins/data-tables/responsive.datatables.min.css') }}" rel='stylesheet'>
   <link href="{{asset('admin/assets/css/extra.css')}}" rel="stylesheet">
   @endsection
@section('content')
    @include('layouts.admin.partials.breadcrumb', [
        'breadcrumb' => $breadcrumb,
        ($pageTitle = $warehouse->name),
        ($modalName = trans('Warehouses')),
        ($modalLink = '#'),
        ($href = '/home/warehouses'),
        ($modalName2 = trans('Add Products')),
        ($modalLink2 = '#addProductsToWarehouse'),
        ($href2 = ''),
    ])

    <div class="row">
        <div class="col-12">
            <div class="ec-vendor-list card card-default">
                <div class="card-header py-0">
                    <div class="card-title">
                        <h1>{{ __('Product List') }}</h1>
                    </div>
                    <div class="card-toolbar">
                        @if($stock)
                        <button type="button" class="m-3 btn btn-warning btn-responsive validate-stock">{{ __('Validate Stock') }}</button>
                        @endif
                        @if($stock != NUll)
                        <button type="button" class="m-3 btn btn-primary btn-responsive export">{{ __('Export') }}</button>
                        <button type="button" class="m-3 btn btn-secondary btn-responsive return-stock">{{ __('Return to Stock') }}</button>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="warehouse-data-table" class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th style="min-width:200px">{{ __('Name') }}</th>
                                    <th style="min-width:120px">{{ __('Brand') }}</th>
                                    <th style="min-width:120px">{{ __('Category') }}</th>
                                    <th style="min-width:150px">{{ __('Barcode') }}</th>
                                    <th style="min-width:100px">{{ __('Status') }}</th>
                                    <th style="min-width:150px">{{ __('Purchase Price') }}</th>
                                    <th style="min-width:120px">{{ __('Selling Price') }}</th>
                                    <th style="min-width:120px">{{ __('Wholesale Price') }}</th>
                                    <th style="min-width:100px">{{ __('Quantity') }}</th>
                                    <th style="min-width:100px">{{ __('Unit') }}</th>
                                    <th style="min-width:100px">{{ __('Updated On') }}</th>
                                    <th class="text-end" style="min-width:100px"></th>
                                </tr>
                            </thead>
                            <tbody style="height: 200px"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Increase Product Quantity -->
    <div class="modal fade" id="increaseProductQuantityModal" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="increaseProductQuantityModal" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="increaseProductQuantityModalLabel">{{ __('Increase Product Quantity') }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form id="increaseProductQuantityForm">
                    @csrf
                    <div class="modal-body">
                        <div class="row g-3">
                            <!-- Product -->
                            <div class="col-sm-12 col-lg-12 my-3">
                                <label class="form-label">{{ __('Your product is') }}:</label>
                                <select id="product" class="form-select" name="product" disabled>
                                    @foreach (\App\Models\Product::orderBy('name', 'ASC')->get() as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                <small class="text-secondary">{{ __('In Main Stock') }}: <span
                                        id="product_span">0</span></small>
                            </div>

                            <!-- Current Quantity -->
                            <div class="col-sm-6 col-lg-6 my-3">
                                <label class="form-label" for="current_quantity">{{ __('Current Quantity') }}:</label>
                                <input type="number" class="form-control" id="current_quantity" name="current_quantity"
                                    disabled>
                            </div>

                            <!-- Quantity to be added -->
                            <div class="col-sm-6 col-lg-6 my-3">
                                <label class="form-label" for="quantity_to_add">{{ __('Quantity to be added') }}:</label>
                                <input type="number" class="form-control" id="quantity_to_add" name="quantity_to_add">
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btnCancelProductIncrease"
                            class="btn btn-secondary mb-4">{{ __('Cancel') }}</button>
                        <button type="button" id="btnProductIncrease"
                            class="btn btn-primary mb-4">{{ __('Increase') }}</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- Modal Add Products -->
    <div class="modal fade" action="#" method="POST" id="addProductsToWarehouse" data-bs-backdrop="static"
        data-bs-keyboard="false" tabindex="-1" aria-labelledby="addProductsToWarehouse" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="addProductsToWarehouseForm" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addProductsToWarehouseLabel">{{ __('Add Products') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row d-flex justify-content-center">
                            <div class="col-sm-12 col-lg-12">
                                <div class="alert alert-warning d-flex align-items-center add-products-alert"
                                    role="alert">
                                    <span class="mdi mdi-information-outline"
                                        style="font-size:48px;margin-right:20px;"></span>
                                    <div>
                                        {{ __('No existen productos para agregar al Stock. Puede que los productos ya se encuentren en la lista o no han sido creados aún.') }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-lg-6 products">
                                <div class="form-group">
                                    <label for="products">{{ __('Products') }}</label>
                                    <select style="min-height: 200px" multiple class="form-control form-control-sm"
                                        name="products" id="products">
                                        @foreach ($available_products as $product)
                                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-6 products">
                                <div class="form-group">
                                    <label for="add_products">{{ __('Added Products') }}</label>
                                    <select style="min-height: 200px" multiple class="form-control" name="add_products[]"
                                        id="add_products">
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            id="btnCancelAddProduct">{{ __('Cancel') }}</button>
                        <button type="button" class="btn btn-primary products"
                            id="btnAddProduct">{{ __('Add Products') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Validate Stock -->
    <div class="modal fade" action="#" method="POST" id="validateStockModal" data-bs-backdrop="static"
        data-bs-keyboard="false" tabindex="-1" aria-labelledby="validateStock" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="validateStockForm" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title" id="validateStockLabel">{{ __('Validate Stock') }}</h5>
                        <button id="closeValidateStock" type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row d-flex justify-content-center" id="products-container">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            id="btnCancelValidationStock">{{ __('Cancel') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('admin/assets/plugins/data-tables/jquery.datatables.min.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/data-tables/datatables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/data-tables/datatables.responsive.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/custom/warehouses/products/table.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Obtener los productos ya agregados y almacenarlos en un array
            var addedProducts = {!! json_encode($available_products) !!};
            addedProducts = Array.isArray(addedProducts) ? addedProducts : [];

            var warehouseDataTable = $("#warehouse-data-table")

            // Verificar si no hay opciones disponibles en el campo "Products"
            if ($('#products option').length === 0) {
                // Mostrar el alert de advertencia y ocultar el formulario
                $('.add-products-alert').removeClass('d-none');
                $('.products').hide();
                return;
            }

            // Ocultar el alert y mostrar el formulario si estaba oculto
            $('.add-products-alert').addClass('d-none');

            // Al cargar la página, ocultar los productos ya agregados del campo "Products"
            $('#products option').each(function() {
                var productId = $(this).val();
                if (addedProducts.includes(productId)) {
                    $(this).remove();
                }
            });

            // Al hacer clic en las opciones del primer select
            $('#products').on('change', function() {
                var selectedOption = $(this).find(':selected');
                selectedOption.remove();
                $('#add_products').append(selectedOption);
            });

            // Al hacer clic en las opciones del segundo select
            $('#add_products').on('change', function() {
                var selectedOption = $(this).find(':selected');
                selectedOption.remove();
                $('#products').append(selectedOption);
                console.log($('#products').append(selectedOption));
            });

            // Manage click on the "Add Product" button.
            $('#btnAddProduct').on('click', function(e) {
                e.preventDefault();

                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                // Obtener los productos seleccionados en add_products[]
                var selectedProducts = $('#add_products').val();
                // Verificar los productos seleccionados en la consola
                console.log(selectedProducts);
                var formData = new FormData($('#addProductsToWarehouseForm')[0]);
                formData.append('_token', csrfToken);

                $.ajax({
                    url: window.location.pathname + '/add-products',
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function(response) {
                        // Obtener valores seleccionados del array add_products[]
                        var selectedProducts = $('#add_products').val();

                        // Mostrar mensaje de éxito con los valores seleccionados
                        var successMessage = 'Productos agregados correctamente.';
                        toastr.success(successMessage);
                        // setTimeout(function() {
                        //     // Luego de que desaparezca el toast, actualizar la pantalla
                        //     location.reload();
                        // }, 2000);
                        // Cerrar el modal y recargar el DataTable
                        $('#addProductsToWarehouse').modal('hide');
                        $('#addProductsToWarehouseForm')[0].reset();
                        warehouseDataTable.DataTable().ajax.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            var errorMessage = '';
                            for (var field in errors) {
                                errorMessage += errors[field].join('\n') + '\n';
                            }
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

        });
    </script>
@endsection

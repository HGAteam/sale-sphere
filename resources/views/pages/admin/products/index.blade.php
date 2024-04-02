@extends('layouts.app')
@section('styles')
    <!-- Data Tables -->
    <link href="{{ asset('admin/assets/plugins/data-tables/datatables.bootstrap5.min.css') }}" rel='stylesheet'>
    <link href="{{ asset('admin/assets/plugins/data-tables/responsive.datatables.min.css') }}" rel='stylesheet'>
    <link href="{{ asset('admin/assets/plugins/data-tables/datatables/buttons/css/buttons.bootstrap5.min.css') }}"
        rel="stylesheet">
    <link href="{{ asset('admin/assets/plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet" />
   <link href="{{asset('admin/assets/css/extra.css')}}" rel="stylesheet">
    @endsection
@section('content')
    @include('layouts.admin.partials.breadcrumb', [
        'breadcrumb' => $breadcrumb,
        ($pageTitle = trans('Products')),
        ($modalLink = '#newProductModal'),
        ($href = ''),
        ($modalName = trans('Add Product')),
        ($modalLink2 = '#'),
        ($href2 = ''),
        ($modalName2 = ''),
    ])

    <div class="row">
        <div class="col-12">
            <div class="ec-cat-list card card-default">
                <div class="card-header py-0">
                    <div class="card-title">
                        <h1>{{__('Product List')}}</h1>
                    </div>
                    <div class="card-toolbar">
                        <button type="button" class="m-3 btn btn-warning btn-responsive import">{{__('Import')}}</button>
                        @if(App\Models\Product::count())
                        <button type="button" class="m-3 btn btn-primary btn-responsive export">{{__('Export')}}</button>
                        @endif
                        <button type="button" class="m-3 btn btn-secondary btn-responsive template">{{__('Template')}}</button>
                        <button type="button" class="m-3 btn btn-info btn-responsive increase-prices">{{__('Increase Prices')}}</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="products-data-table" class="table">
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

    <!-- Modal New Product -->
    <div class="modal fade" id="newProductModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="newProductModal" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newProductModalLabel">{{ __('Add Product') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="newProductForm">
                    @csrf
                    <div class="modal-body">
                        <div class="row ec-vendor-uploads">
                            <div class="col-lg-4 my-3">
                                <div class="ec-vendor-img-upload">
                                    <div class="ec-vendor-main-img">
                                        <div class="avatar-upload">
                                            <div class="avatar-edit">
                                                <input type='file' id="imageUpload" name="image"
                                                    class="ec-image-upload" accept=".png, .jpg, .jpeg" />
                                                <label for="imageUpload">
                                                    <img src="{{ asset('admin/assets/img/icons/edit.svg') }}"
                                                        class="svg_img header_svg" alt="Product Image" />
                                                </label>
                                            </div>
                                            <div class="avatar-preview ec-preview">
                                                <div class="imagePreview ec-div-preview">
                                                    <img class="ec-image-preview"
                                                        src="{{ asset('admin/assets/img/products/vender-upload-preview.jpg') }}"
                                                        alt="Product Image" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="ec-vendor-upload-detail">
                                    <div class="row g-3">
                                        <!-- Product Name -->
                                        <div class="col-sm-6 col-md-6 my-3">
                                            <label for="name" class="form-label">{{ __('Product Name') }}</label>
                                            <input type="text" class="form-control" id="name" name="name">
                                        </div>
                                        <!-- Barcode -->
                                        <div class="col-sm-6 col-md-6 my-3">
                                            <label class="form-label" for="barcode">{{ __('Barcode') }}</label>
                                            <input type="text" class="form-control" id="barcode" name="barcode">
                                        </div>
                                        <!-- Brand -->
                                        <div class="col-sm-6 col-md-6 my-3">
                                            <label class="form-label">{{ __('Select Brand') }}</label>
                                            <select name="brands" id="brands" class="form-select">
                                                @foreach (\App\Models\Brand::orderBy('name', 'ASC')->get() as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <!-- Categories -->
                                        <div class="col-sm-6 col-md-6 my-3">
                                            <label class="form-label">{{ __('Select Categories') }}</label>
                                            <select name="categories" id="categories" class="form-select">
                                                @foreach (\App\Models\Category::orderBy('name', 'ASC')->get() as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <!-- Description -->
                                        <div class="col-md-12 my-3">
                                            <label class="form-label" for="description">{{ __('Description') }}</label>
                                            <textarea class="form-control" id="description" name="description" rows="2"></textarea>
                                            <div class="form-check m-3">
                                                <input class="form-check-input" type="checkbox" name="require_stock"
                                                    id="require_stock" required>
                                                <label class="form-check-label" for="require_stock">
                                                    {{ __('Require Stock') }}
                                                </label>
                                            </div>
                                            <div class="form-check m-3">
                                                <input class="form-check-input" type="checkbox" name="returnable"
                                                    id="returnable" required>
                                                <label class="form-check-label" for="returnable">
                                                    {{ __('Product Returnable') }}
                                                </label>
                                            </div>
                                        </div>
                                        <!-- Purchase Price -->
                                        <div class="col-sm-4 col-md-4 my-3">
                                            <label class="form-label" for="purchase_price">{{ __('Purchase Price') }}
                                                <span></span></label>
                                            <input type="number" step="0.01" class="form-control"
                                                id="purchase_price" name="purchase_price">
                                        </div>
                                        <!-- Selling Price -->
                                        <div class="col-sm-4 col-md-4 my-3">
                                            <label class="form-label" for="selling_price">{{ __('Selling Price') }}
                                                <span></span></label>
                                            <input type="number" step="0.01" class="form-control" id="selling_price"
                                                name="selling_price">
                                        </div>
                                        <!-- Wholesale Price -->
                                        <div class="col-sm-4 col-md-4 my-3">
                                            <label class="form-label" for="wholesale_price">{{ __('Wholesale Price') }}
                                                <span></span></label>
                                            <input type="number" step="0.01" class="form-control"
                                                id="wholesale_price" name="wholesale_price">
                                        </div>
                                        <!-- Unit -->
                                        <div class="col-sm-6 col-md-6 my-3">
                                            <label class="form-label" for="unit">{{ __('Select Unit') }}</label>
                                            <select name="unit" id="unit" class="form-select">
                                                <option value="Grams">{{ __('Grams') }}</option>
                                                <option value="Unit">{{ __('Unit') }}</option>
                                                <option value="Liters">{{ __('Liters') }}</option>
                                            </select>
                                        </div>
                                        <!-- Quantity -->
                                        <div class="col-sm-6 col-md-6 my-3">
                                            <label class="form-label" for="quantity">{{ __('Quantity') }}</label>
                                            <input type="number" class="form-control" id="quantity" name="quantity">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btnCancelNew"
                            class="btn btn-secondary mb-4">{{ __('Cancel') }}</button>
                        <button type="button" id="btnSaveNew" class="btn btn-primary mb-4">{{ __('Save') }}</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- Modal Edit Product -->
    <div class="modal fade" id="editProductModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="editProductModal" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProductModalLabel">{{ __('Edit Product') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editProductForm">
                    @csrf
                    <div class="modal-body">
                        <div class="row ec-vendor-uploads">
                            <div class="col-lg-4 my-3">
                                <div class="ec-vendor-img-upload">
                                    <div class="ec-vendor-main-img">
                                        <div class="avatar-upload">
                                            <div class="avatar-edit">
                                                <input type='file' id="editImageUpload" name="edit_image"
                                                    class="ec-image-upload" accept=".png, .jpg, .jpeg" />
                                                <label for="editImageUpload">
                                                    <img src="{{ asset('admin/assets/img/icons/edit.svg') }}"
                                                        class="svg_img header_svg" alt="edit" />
                                                </label>
                                            </div>
                                            <div class="avatar-preview ec-preview">
                                                <div class="imagePreview ec-div-preview">
                                                    <img class="ec-image-preview" id="editImagePreview" alt="edit" />
                                                </div>
                                            </div>
                                            <div id="editImageName"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="ec-vendor-upload-detail">
                                    <div class="row g-3">
                                        <!-- Product Name -->
                                        <div class="col-sm-6 col-md-6 my-3">
                                            <label for="edit_name" class="form-label">{{ __('Product Name') }}</label>
                                            <input type="text" class="form-control" id="edit_name" name="edit_name">
                                        </div>
                                        <!-- Barcode -->
                                        <div class="col-sm-6 col-md-6 my-3">
                                            <label class="form-label" for="edit_barcode">{{ __('Barcode') }}</label>
                                            <input type="text" class="form-control" id="edit_barcode"
                                                name="edit_barcode">
                                        </div>
                                        <!-- Brand -->
                                        <div class="col-sm-6 col-md-6 my-3">
                                            <label for="edit_brands" class="form-label">{{ __('Select Brand') }}</label>
                                            <select name="edit_brands" id="edit_brands" class="form-select">
                                                @foreach (\App\Models\Brand::orderBy('name', 'ASC')->get() as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <!-- Categories -->
                                        <div class="col-sm-6 col-md-6 my-3">
                                            <label for="edit_categories"
                                                class="form-label">{{ __('Select Categories') }}</label>
                                            <select name="edit_categories" id="edit_categories" class="form-select">
                                                @foreach (\App\Models\Category::orderBy('name', 'ASC')->get() as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <!-- Description -->
                                        <div class="col-md-12 my-3">
                                            <label class="form-label"
                                                for="edit_description">{{ __('Description') }}</label>
                                            <textarea class="form-control" id="edit_description" name="edit_description" rows="2"></textarea>
                                            <div class="form-check m-3">
                                                <input class="form-check-input" type="checkbox"
                                                    name="edit_requires_stock" id="edit_requires_stock" required>
                                                <label class="form-check-label" for="edit_requires_stock">
                                                    {{ __('Require Stock') }}
                                                </label>
                                            </div>
                                            <div class="form-check m-3">
                                                <input class="form-check-input" type="checkbox" name="edit_returnable"
                                                    id="edit_returnable" required>
                                                <label class="form-check-label" for="edit_returnable">
                                                    {{ __('Product Returnable') }}
                                                </label>
                                            </div>
                                        </div>
                                        <!-- Purchase Price -->
                                        <div class="col-sm-4 col-md-4 my-3">
                                            <label class="form-label"
                                                for="edit_purchase_price">{{ __('Purchase Price') }}
                                                <span></span></label>
                                            <input type="number" step="0.01" class="form-control"
                                                id="edit_purchase_price" name="edit_purchase_price">
                                        </div>
                                        <!-- Selling Price -->
                                        <div class="col-sm-4 col-md-4 my-3">
                                            <label class="form-label" for="edit_selling_price">{{ __('Selling Price') }}
                                                <span></span></label>
                                            <input type="number" step="0.01" class="form-control"
                                                id="edit_selling_price" name="edit_selling_price">
                                        </div>
                                        <!-- Wholesale Price -->
                                        <div class="col-sm-4 col-md-4 my-3">
                                            <label class="form-label"
                                                for="edit_wholesale_price">{{ __('Wholesale Price') }}
                                                <span></span></label>
                                            <input type="number" step="0.01" class="form-control"
                                                id="edit_wholesale_price" name="edit_wholesale_price">
                                        </div>
                                        <!-- Unit -->
                                        <div class="col-sm-6 col-md-6 my-3">
                                            <label class="form-label" for="edit_unit">{{ __('Select Unit') }}</label>
                                            <select name="edit_unit" id="edit_unit" class="form-select">
                                                <option value="Grams">{{ __('Grams') }}</option>
                                                <option value="Unit">{{ __('Unit') }}</option>
                                                <option value="Liters">{{ __('Liters') }}</option>
                                            </select>
                                        </div>
                                        <!-- Quantity -->
                                        <div class="col-sm-6 col-md-6 my-3">
                                            <label class="form-label" for="edit_quantity">{{ __('Quantity') }}</label>
                                            <input type="number" class="form-control" id="edit_quantity"
                                                name="edit_quantity">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btnCancelUpdate"
                            class="btn btn-secondary mb-4">{{ __('Cancel') }}</button>
                        <button type="button" id="btnUpdate" class="btn btn-primary mb-4">{{ __('Update') }}</button>
                    </div>
                </form>

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

    <!-- Modal Increase Prices -->
    <div class="modal fade" id="IncreasePricesModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="IncreasePricesModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="IncreasePricesModalLabel">{{ __('Increase Prices') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form id="IncreasePricesForm">
                    @csrf
                    <div class="modal-body">
                        @if (App\Models\Product::orderBy('name', 'ASC')->count() == 0)
                            <div class="alert alert-warning d-flex align-items-center" role="alert">
                                <span class="mdi mdi-information-outline"
                                    style="font-size:48px;margin-right:20px;"></span>
                                <div>
                                    {{ __('There are currently no products. To create or import products you must use the correct options to Add Product or Import.') }}
                                </div>
                            </div>
                        @else
                            <div class="row g-3">
                                <!-- Product-->
                                <div class="col-sm-12 col-lg-12 my-3">
                                    <label class="form-label">{{ __('Product') }}:</label>
                                    <select name="from_product" id="from_product" class="form-select">
                                        <option value="">{{ __('All') }}</option>
                                        @foreach (\App\Models\Product::orderBy('name', 'ASC')->get() as $product)
                                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- New Purchase Price -->
                                <div class="row justify-content-center mb-3">
                                    <label for="increase_purchase_price"
                                        class="col-sm-4 col-lg-4 col-form-label">{{ __('Purchase Price') }}</label>
                                    <div class="col-sm-6">
                                        <div class="input-group">
                                            <span class="input-group-text">%</span>
                                            <input type="number" class="form-control"
                                                style="border:1px solid rgb(206, 212, 218)" step="0.01"
                                                id="increase_purchase_price" name="increase_purchase_price">
                                        </div>
                                    </div>
                                </div>

                                <!-- New Wholesale Price -->
                                <div class="row justify-content-center mb-3">
                                    <label for="increase_wholesale_price"
                                        class="col-sm-4 col-lg-4 col-form-label">{{ __('Wholesale Price') }}</label>
                                    <div class="col-sm-6">
                                        <div class="input-group">
                                            <span class="input-group-text">%</span>
                                            <input type="number" class="form-control"
                                                style="border:1px solid rgb(206, 212, 218)" step="0.01"
                                                id="increase_wholesale_price" name="increase_wholesale_price">
                                        </div>
                                    </div>
                                </div>

                                <!-- New Selling Price -->
                                <div class="row justify-content-center mb-3">
                                    <label for="increase_selling_price"
                                        class="col-sm-4 col-lg-4 col-form-label">{{ __('Selling Price') }}</label>
                                    <div class="col-sm-6">
                                        <div class="input-group">
                                            <span class="input-group-text">%</span>
                                            <input type="number" class="form-control"
                                                style="border:1px solid rgb(206, 212, 218)" step="0.01"
                                                id="increase_selling_price" name="increase_selling_price">
                                        </div>
                                    </div>
                                </div>

                            </div>
                        @endif

                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btnCancelPriceIncrese"
                            class="btn btn-secondary mb-4">{{ __('Cancel') }}</button>
                        @if (App\Models\Product::orderBy('name', 'ASC')->count() != 0)
                            <button type="button" id="btnApplyPriceIncrease"
                                class="btn btn-primary mb-4">{{ __('Apply Price Increase') }}</button>
                        @endif
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
    <script src="{{ asset('admin/assets/plugins/data-tables/datatables/buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/data-tables/datatables/buttons/js/buttons.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/data-tables/datatables/buttons/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/data-tables/datatables/buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/data-tables/datatables/buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/data-tables/datatables/JSZip-3.10.1/jszip.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/custom/products/table.js') }}"></script>
    <script>
        document.getElementById('editImageUpload').addEventListener('change', function() {
            var fileName = this.value.split('\\').pop();
            document.getElementById('editImageName').innerText = fileName;

            // Previsualizar la imagen seleccionada
            var input = this;
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#editImagePreview').attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            } else {
                // Si se deja en blanco, volver a mostrar la imagen existente
                var productImage =
                    '/admin/assets/img/category/clothes.png'; // Ajusta la ruta de la imagen por defecto
                $('#editImagePreview').attr('src', productImage);
            }
        });
    </script>
    <script src="{{ asset('admin/assets/js/custom/products/update.js') }}"></script>
@endsection

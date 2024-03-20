@extends('layouts.app')
@section('styles')
    <!-- Data Tables -->
    <link href="{{ asset('admin/assets/plugins/data-tables/datatables.bootstrap5.min.css') }}" rel='stylesheet'>
    <link href="{{ asset('admin/assets/plugins/data-tables/responsive.datatables.min.css') }}" rel='stylesheet'>
@endsection

@section('content')
    @include('layouts.admin.partials.breadcrumb', [
        'breadcrumb' => $breadcrumb,
        ($pageTitle = trans('Products')),
        ($modalLink = '#'),
        ($href = '/home/products/create'),
        ($modalName = trans('Add Product')),
        ($modalLink2 = ''),
        ($href2 = '/home/products'),
        ($modalName2 = trans('View Products')),
    ])

    <div class="row">
        <div class="col-12">
            <div class="ec-cat-list card card-default">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="transfers-data-table" class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th style="min-width:150px">{{ __('From Warehouse') }}</th>
                                    <th style="min-width:150px">{{ __('To Warehouse') }}</th>
                                    <th style="min-width:150px">{{ __('Product') }}</th>
                                    <th style="min-width:150px">{{ __('Quantity') }}</th>
                                    <th style="min-width:120px">{{ __('Status') }}</th>
                                    <th style="min-width:200px">{{ __('Details') }}</th>
                                    <th style="min-width:120px">{{ __('Created At') }}</th>
                                    <th style="min-width:120px">{{ __('Updated At') }}</th>
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

    <!-- Modal Transfer -->
    {{-- <div class="modal fade" id="transferProductModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="transferProductModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="transferProductModalLabel">{{ __('Transfer Product') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form id="transferProductForm">
                    @csrf
                    <div class="modal-body">
                        <div class="row g-3">
                            <!-- Product -->
                            <div class="col-sm-7 col-lg-7 my-3">
                                <label class="form-label">{{ __('Your product to transfer is') }}:</label>
                                <select id="product" class="form-select" name="product" disabled>
                                    @foreach (\App\Models\Product::orderBy('name', 'ASC')->get() as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- Warehouse FROM-->
                            <div class="col-sm-5 col-lg-5 my-3">
                                <label class="form-label">{{ __('You will transfer from') }}:</label>
                                <select name="warehouse_from" id="warehouse_from" class="form-select disabled" disabled>
                                    @foreach (\App\Models\Warehouse::orderBy('name', 'ASC')->get() as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Warehouse TO-->
                            <div class="col-sm-6 col-lg-6 my-3">
                                <label class="form-label">{{ __('Up to the warehouse') }}:</label>
                                <select name="warehouse_to" id="warehouse_to" class="form-select">
                                    @foreach (\App\Models\Warehouse::orderBy('name', 'ASC')->get() as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Quantity -->
                            <div class="col-sm-6 col-lg-6 my-3">
                                <label class="form-label" for="quantity">{{ __('The amount of') }}:</label>
                                <input type="number" class="form-control" id="quantity" name="quantity">
                            </div>

                            <!-- Details -->
                            <div class="col-sm-12 col-lg-12 my-3">
                                <label class="form-label"
                                    for="details">{{ __('Write the reason for the transfer of the product') }}</label>
                                <textarea class="form-control" id="details" name="details" style="min-height:100px;max-height:150px;"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btnCancel" class="btn btn-secondary mb-4">{{ __('Cancel') }}</button>
                        <button type="button" id="btnTransfer" class="btn btn-primary mb-4">{{ __('Transfer') }}</button>
                    </div>
                </form>

            </div>
        </div>
    </div> --}}
@endsection

@section('scripts')
    <script src="{{ asset('admin/assets/plugins/data-tables/jquery.datatables.min.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/data-tables/datatables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/data-tables/datatables.responsive.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/custom/products/transfers.js') }}"></script>
    {{-- <script src="{{ asset('admin/assets/js/custom/products/update.js') }}"></script> --}}
@endsection

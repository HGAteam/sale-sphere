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
        ($pageTitle = trans('Warehouses')),
        ($modalLink = '#addWarehouse'),
        ($href = ''),
        ($modalName = trans('Add Warehouse')),
        ($modalLink2 = '#'),
        ($href2 = ''),
        ($modalName2 = ''),
    ])

    <div class="row">
        <div class="col-12">
            <div class="ec-vendor-list card card-default">
                <div class="card-header py-0">
                    <div class="card-title">
                        <h1>{{__('Warehouse List')}}</h1>
                    </div>
                    <div class="card-toolbar">
                        <button type="button" class="m-3 btn btn-warning btn-responsive import">{{__('Import')}}</button>
                        <button type="button" class="m-3 btn btn-primary btn-responsive export">{{__('Export')}}</button>
                        <button type="button" class="m-3 btn btn-secondary btn-responsive template">{{__('Template')}}</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="warehouses-data-table" class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th style="min-width:120px">{{ __('Name') }}</th>
                                    <th style="min-width:150px">{{ __('Location') }}</th>
                                    <th style="min-width:150px">{{ __('Address') }}</th>
                                    <th style="min-width:120px">{{ __('Status') }}</th>
                                    <th style="min-width:120px">{{ __('Branch Manager') }}</th>
                                    <th style="min-width:120px">{{ __('Phone') }}</th>
                                    <th style="min-width:120px">{{ __('Mobile') }}</th>
                                    <th style="min-width:120px">{{ __('Created At') }}</th>
                                    <th style="min-width:120px">{{ __('Cashiers') }}</th>
                                    <th class="text-end" style="min-width:100px">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody style="height: 200px"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Warehouse Modal  -->
    <div class="modal fade modal-add-contact" id="addWarehouse" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <form method="POST" action="#" id="add_new" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header px-4">
                        <h5 class="modal-title" id="exampleModalCenterTitle">{{ __('Add New Warehouse') }}</h5>
                    </div>

                    <div class="modal-body px-4">
                        <div class="row mb-2">
                            <!-- Name -->
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="name">{{ __('Name') }}</label>
                                    <input type="text" class="form-control" id="name" name="name" value="">
                                </div>
                            </div>

                            <!-- Location -->
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="location">{{ __('Location') }}</label>
                                    <input type="text" class="form-control" id="location" name="location"
                                        value="">
                                </div>
                            </div>

                            <!-- Address -->
                            <div class="col-lg-6">
                                <div class="form-group mb-4">
                                    <label for="address">{{ __('Address') }}</label>
                                    <input type="text" class="form-control" id="address" name="address" value="">
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="col-lg-6">
                                <div class="form-group mb-4">
                                    <label for="status">{{ __('Status') }}</label>
                                    <select class="form-control" id="status" name="status">
                                        <option value="1">{{ __('Active') }}</option>
                                        <option value="0">{{ __('Inactive') }}</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Branch Manager -->
                            <div class="col-lg-6">
                                <div class="form-group mb-4">
                                    <label for="branch_manager">{{ __('Branch Manager') }}</label>
                                    <input type="text" class="form-control" id="branch_manager" name="branch_manager"
                                        value="">
                                </div>
                            </div>

                            <!-- CASHIERS -->
                            <div class="col-lg-6">
                                <div class="form-group mb-4">
                                    <label for="cashiers">{{ __('Cashiers') }}</label>
                                    <input type="number" class="form-control" id="cashiers" name="cashiers"
                                        value="">
                                </div>
                            </div>
                            <!-- Phone -->
                            <div class="col-lg-6">
                                <div class="form-group mb-4">
                                    <label for="phone">{{ __('Phone') }}</label>
                                    <input type="text" class="form-control" id="phone" name="phone" value="">
                                </div>
                            </div>

                            <!-- Mobile -->
                            <div class="col-lg-12">
                                <div class="form-group mb-4">
                                    <label for="mobile">{{ __('Mobile') }}</label>
                                    <input type="text" class="form-control" id="mobile" name="mobile"
                                        value="">
                                </div>
                            </div>

                            <!-- Details -->
                            <div class="col-lg-12">
                                <div class="form-group mb-4">
                                    <label for="details">{{ __('Details') }}</label>
                                    <textarea class="form-control" id="details" name="details"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer px-4">
                        <button type="button" id="btnCancel"
                            class="btn btn-secondary btn-pill">{{ __('Cancel') }}</button>
                        <button type="button" id="btnSave"
                            class="btn btn-primary btn-pill">{{ __('Save Warehouse') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Warehouse Modal  -->
    <div class="modal fade modal-add-contact" id="editWarehouseModal" tabindex="-1" role="dialog"
        aria-labelledby="EditModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <form id="editWarehouseForm">
                    <div class="modal-header px-4">
                        <h5 class="modal-title" id="EditModalCenterTitle">{{ __('Update Warehouse') }}</h5>
                    </div>

                    <div class="modal-body px-4">
                        <div class="row mb-2">
                            <!-- Name -->
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="edit-name">{{ __('Name') }}</label>
                                    <input type="text" class="form-control" id="edit-name" name="edit_name"
                                        value="">
                                </div>
                            </div>

                            <!-- Location -->
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="edit-location">{{ __('Location') }}</label>
                                    <input type="text" class="form-control" id="edit-location" name="edit_location"
                                        value="">
                                </div>
                            </div>

                            <!-- Address -->
                            <div class="col-lg-6">
                                <div class="form-group mb-4">
                                    <label for="edit-address">{{ __('Address') }}</label>
                                    <input type="text" class="form-control" id="edit-address" name="edit_address"
                                        value="">
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="col-lg-6">
                                <div class="form-group mb-4">
                                    <label for="edit-status">{{ __('Status') }}</label>
                                    <select class="form-control" id="edit-status" name="edit_status">
                                        <option value="1">{{ __('Active') }}</option>
                                        <option value="0">{{ __('Inactive') }}</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Branch Manager -->
                            <div class="col-lg-6">
                                <div class="form-group mb-4">
                                    <label for="edit-branch_manager">{{ __('Branch Manager') }}</label>
                                    <input type="text" class="form-control" id="edit-branch_manager"
                                        name="edit_branch_manager" value="">
                                </div>
                            </div>

                            <!-- CASHIERS -->
                            <div class="col-lg-6">
                                <div class="form-group mb-4">
                                    <label for="edit-cashiers">{{ __('Cashiers') }}</label>
                                    <input type="number" class="form-control" id="edit-cashiers" name="edit_cashiers"
                                        value="">
                                </div>
                            </div>

                            <!-- Phone -->
                            <div class="col-lg-6">
                                <div class="form-group mb-4">
                                    <label for="edit-phone">{{ __('Phone') }}</label>
                                    <input type="text" class="form-control" id="edit-phone" name="edit_phone"
                                        value="">
                                </div>
                            </div>

                            <!-- Mobile -->
                            <div class="col-lg-12">
                                <div class="form-group mb-4">
                                    <label for="edit-mobile">{{ __('Mobile') }}</label>
                                    <input type="text" class="form-control" id="edit-mobile" name="edit_mobile"
                                        value="">
                                </div>
                            </div>

                            <!-- Details -->
                            <div class="col-lg-12">
                                <div class="form-group mb-4">
                                    <label for="edit-details">{{ __('Details') }}</label>
                                    <textarea class="form-control" id="edit-details" name="edit_details"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer px-4">
                        <button type="button" id="btnCancelChanges"
                            class="btn btn-secondary btn-pill">{{ __('Cancel') }}</button>
                        <button type="button" id="btnSaveChanges"
                            class="btn btn-primary btn-pill">{{ __('Save Warehouse') }}</button>
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
    <script src="{{ asset('admin/assets/js/custom/warehouses/table.js') }}"></script>
    <script src="{{ asset('admin/assets/js/custom/warehouses/add.js') }}"></script>
    <script src="{{ asset('admin/assets/js/custom/warehouses/update.js') }}"></script>
@endsection

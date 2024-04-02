@extends('layouts.app')
@section('styles')
    <!-- Data Tables -->
    <link href="{{asset('admin/assets/css/extra.css')}}" rel="stylesheet">
    <link href="{{ asset('admin/assets/plugins/data-tables/datatables.bootstrap5.min.css') }}" rel='stylesheet'>
    <link href="{{ asset('admin/assets/plugins/data-tables/responsive.datatables.min.css') }}" rel='stylesheet'>
   @endsection

@section('content')
    @include('layouts.admin.partials.breadcrumb', [
        'breadcrumb' => $breadcrumb,
        ($pageTitle = trans('Suppliers')),
        ($modalLink = '#addSupplier'),
        ($modalName = trans('Add Supplier')),
        ($href = ''),
    ])

    <div class="row">
        <div class="col-12">
            <div class="ec-cat-list card card-default">
                <div class="card-header py-0">
                    <div class="card-title">
                        <h1>{{__('Supplier List')}}</h1>
                    </div>
                    <div class="card-toolbar">
                        <button type="button" class="m-3 btn btn-warning btn-responsive import">{{__('Import')}}</button>
                        @if($suppliers)
                        <button type="button" class="m-3 btn btn-primary btn-responsive export">{{__('Export')}}</button>
                        @endif
                        <button type="button" class="m-3 btn btn-secondary btn-responsive template">{{__('Template')}}</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="suppliers-data-table" class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th style="min-width:150px">{{ __('Social Reason') }}</th>
                                    <th style="min-width:150px">{{ __('Contact') }}</th>
                                    <th style="min-width:150px">{{ __('Cuit') }}</th>
                                    <th style="min-width:120px">{{ __('Status') }}</th>
                                    <th style="min-width:100px">{{ __('Address') }}</th>
                                    <th style="min-width:100px">{{ __('Location') }}</th>
                                    <th style="min-width:150px">{{ __('Email') }}</th>
                                    <th style="min-width:120px">{{ __('Phone') }}</th>
                                    <th style="min-width:120px">{{ __('Mobile') }}</th>
                                    <th style="min-width:100px">{{ __('Details') }}</th>
                                    <th style="min-width:100px">{{ __('Created') }}</th>
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

    <!-- Add Supplier Modal  -->
    <div class="modal fade modal-add-contact" data-bs-backdrop="static" id="addSupplier" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <form method="POST" action="#" id="add_new" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header px-4">
                        <h5 class="modal-title" id="exampleModalCenterTitle">{{ __('Add Supplier') }}</h5>
                    </div>

                    <div class="modal-body px-4">
                        {{-- Avatar --}}
                        <div class="form-group row mb-6">
                            <label for="coverImage"
                                class="col-sm-4 col-lg-2 col-form-label">{{ __('Supplier Image') }}</label>
                            <div class="col-sm-8 col-lg-10">
                                <div class="custom-file mb-1">
                                    <input type="file" class="custom-file-input" id="coverImage" name="image">
                                    <label class="custom-file-label" for="coverImage"
                                        id="customFileLabelImage">{{ __('Choose file') }}...</label>
                                    <div class="invalid-feedback">{{ __('Example invalid custom file feedback') }}</div>
                                </div>
                            </div>
                        </div>
                        {{-- INPUTS --}}
                        <div class="row mb-2">
                            {{-- SOCIAL REASON --}}
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="social-reason">{{ __('Social Reason') }}</label>
                                    <input type="text" class="form-control" id="social-reason" name="social_reason" value="John">
                                </div>
                            </div>
                             {{-- FIRST NAME --}}
                             <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="name">{{ __('First Name') }}</label>
                                    <input type="text" class="form-control" id="name" name="name" value="John">
                                </div>
                            </div>
                            {{-- LAST NAME --}}
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="lastname">{{ __('Last Name') }}</label>
                                    <input type="text" class="form-control" id="lastname" name="lastname"
                                        value="Deo">
                                </div>
                            </div>
                            {{-- CUIT --}}
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="cuit">{{ __('CUIT') }}</label>
                                    <input type="text" class="form-control" id="cuit" name="cuit" value="Deo">
                                </div>
                            </div>
                            {{-- EMAIL --}}
                            <div class="col-lg-6">
                                <div class="form-group mb-4">
                                    <label for="email">{{ __('Email') }}</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        value="johnexample@gmail.com">
                                </div>
                            </div>
                            {{-- PHONE --}}
                            <div class="col-lg-6">
                                <div class="form-group mb-4">
                                    <label for="phone">{{ __('Phone') }}</label>
                                    <input type="text" class="form-control" placholder="(0381) 433-30-54" id="phone"
                                        name="phone" value="{{ old('phone') }}">
                                </div>
                            </div>
                            {{-- MOBILE --}}
                            <div class="col-lg-6">
                                <div class="form-group mb-4">
                                    <label for="mobile">{{ __('Mobile') }}</label>
                                    <input type="text" class="form-control" placholder="+5493814333054"
                                        id="mobile" name="mobile" value="{{ old('mobile') }}">
                                </div>
                            </div>
                            {{-- ADDRESS --}}
                            <div class="col-lg-6">
                                <div class="form-group mb-4">
                                    <label for="address">{{ __('Address') }}</label>
                                    <input type="text" class="form-control" id="address"
                                        placeholder="{{ __('Address') }}" name="address" value="">
                                </div>
                            </div>
                            {{-- LOCATION --}}
                            <div class="col-lg-6">
                                <div class="form-group mb-4">
                                    <label for="location">{{ __('Location') }}</label>
                                    <input type="text" class="form-control" id="location"
                                        placeholder="{{ __('Location') }}" name="location" value="">
                                </div>
                            </div>
                            {{-- DETAILS --}}
                            <div class="col-lg-6">
                                <div class="form-group mb-4">
                                    <label for="details">{{ __('Details') }}</label>
                                    <textarea class="form-control" id="details" name="details"></textarea>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer px-4">
                        <button type="button" class="btn btn-secondary btn-pill"
                            id="btnCancel">{{ __('Cancel') }}</button>
                        <button type="button" class="btn btn-primary btn-pill"
                            id="btnSave">{{ __('Save') }}</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <!-- Modal para editar Supplier -->
    <div class="modal fade" id="editSupplierModal" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="editSupplierModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editSupplierModalLabel">{{ __('Edit Supplier') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Agrega aquí los campos del formulario para editar el usuario -->
                    <form id="editSupplierForm">
                        @csrf
                        <!-- Avatar -->
                        <div class="form-group row mb-6">
                            <label for="coverImageEdit" class="col-sm-4 col-lg-4">{{ __('Supplier Image') }}
                                <div class="">
                                    <!-- Imagen por defecto -->
                                    <img id="defaultImage" class="mb-5" src="/admin/assets/img/category/clothes.png"
                                        alt="Default Image" style="max-width: 100%; max-height: 150px;">
                                </div>
                            </label>
                            <div class="col-sm-8 col-lg-8">
                                <div class="custom-file my-8">
                                    <input type="file" class="custom-file-input" id="coverImageEdit"
                                        name="edit_image">
                                    <label class="custom-file-label" for="coverImageEdit"
                                        id="customFileLabelEditImage">{{ __('Choose file') }}...</label>
                                    <div class="invalid-feedback">{{ __('Example invalid custom file feedback') }}</div>
                                </div>
                            </div>
                        </div>
                        <!-- INPUTS -->
                        <div class="row mb-2">
                            <!-- SOCIAL REASON -->
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="edit-social-reason">{{ __('Social Reason') }}</label>
                                    <input type="text" class="form-control" id="edit-social-reason" name="edit_social_reason"
                                        value="">
                                </div>
                            </div>
                             <!-- FIRST NAME -->
                             <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="edit-name">{{ __('First Name') }}</label>
                                    <input type="text" class="form-control" id="edit-name" name="edit_name"
                                        value="">
                                </div>
                            </div>
                            <!-- LAST NAME -->
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="edit-lastname">{{ __('Last Name') }}</label>
                                    <input type="text" class="form-control" id="edit-lastname" name="edit_lastname"
                                        value="">
                                </div>
                            </div>
                            <!-- CUIT -->
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="edit-cuit">{{ __('CUIT') }}</label>
                                    <input type="text" class="form-control" id="edit-cuit" name="edit_cuit"
                                        value="">
                                </div>
                            </div>
                            <!-- STATUS -->
                            <div class="col-lg-6">
                                <div class="form-group mb-4">
                                    <label for="edit-status">{{ __('Status') }}</label>
                                    <select class="form-control" id="edit-status" name="edit_status">
                                        @if (auth()->user()->role == 'Admin')
                                            <option value="Deleted">{{ __('Deleted') }}</option>
                                        @endif
                                        <option value="Active">{{ __('Active') }}</option>
                                        <option value="Inactive">{{ __('Inactive') }}</option>
                                    </select>
                                </div>
                            </div>
                            <!-- EMAIL -->
                            <div class="col-lg-6">
                                <div class="form-group mb-4">
                                    <label for="edit-email">{{ __('Email') }}</label>
                                    <input type="email" class="form-control" id="edit-email" name="edit_email"
                                        value="">
                                </div>
                            </div>
                            <!-- PHONE -->
                            <div class="col-lg-6">
                                <div class="form-group mb-4">
                                    <label for="edit-phone">{{ __('Phone') }}</label>
                                    <input type="text" class="form-control" placholder="(0381) 433-30-54"
                                        id="edit-phone" name="edit_phone" value="{{ old('edit_phone') }}">
                                </div>
                            </div>
                            <!-- MOBILE -->
                            <div class="col-lg-6">
                                <div class="form-group mb-4">
                                    <label for="edit-mobile">{{ __('Mobile') }}</label>
                                    <input type="text" class="form-control" placholder="+5493814333054"
                                        id="edit-mobile" name="edit_mobile" value="{{ old('edit_mobile') }}">
                                </div>
                            </div>
                            <!-- ADDRESS -->
                            <div class="col-lg-6">
                                <div class="form-group mb-4">
                                    <label for="edit-address">{{ __('Address') }}</label>
                                    <input type="text" class="form-control" id="edit-address"
                                        placeholder="{{ __('Address') }}" name="edit_address" value="">
                                </div>
                            </div>
                            <!-- LOCATION -->
                            <div class="col-lg-6">
                                <div class="form-group mb-4">
                                    <label for="edit-location">{{ __('Location') }}</label>
                                    <input type="text" class="form-control" id="edit-location"
                                        placeholder="{{ __('Location') }}" name="edit_location" value="">
                                </div>
                            </div>
                            {{-- DETAILS --}}
                            <div class="col-lg-6">
                                <div class="form-group mb-4">
                                    <label for="edit-details">{{ __('Details') }}</label>
                                    <textarea class="form-control" id="edit-details" name="edit_details"></textarea>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="btnCancelChanges">{{ __('Close') }}</button>
                    <button type="button" class="btn btn-primary" id="btnSaveChanges">{{ __('Save changes') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('admin/assets/plugins/data-tables/jquery.datatables.min.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/data-tables/datatables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/data-tables/datatables.responsive.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/custom/suppliers/table.js') }}"></script>
    <script src="{{ asset('admin/assets/js/custom/suppliers/add.js') }}"></script>
    <script src="{{ asset('admin/assets/js/custom/suppliers/update.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Cambiar el texto del botón "Choose file..." al seleccionar un archivo
        document.getElementById('coverImage').addEventListener('change', function() {
            var fileName = this.value.split('\\').pop(); // Obtener solo el nombre del archivo
            document.getElementById('customFileLabel').innerText = fileName;
        });
        document.getElementById('coverImageEdit').addEventListener('change', function() {
            var fileName = this.value.split('\\').pop(); // Obtener solo el nombre del archivo
            document.getElementById('customFileLabelEditImage').innerText = fileName;
        });
    </script>
@endsection

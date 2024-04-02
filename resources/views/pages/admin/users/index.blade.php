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
        ($pageTitle = trans('Users')),
        ($modalLink = '#addUser'),
        ($modalName = trans('Add Member')),
        ($href = ''),
    ])

    <div class="row">
        <div class="col-12">
            <div class="ec-cat-list card card-default">
                <div class="card-header py-0">
                    <div class="card-title">
                        <h1>{{__('User List')}}</h1>
                    </div>
                    <div class="card-toolbar">
                        <button type="button" class="m-3 btn btn-warning btn-responsive import">{{__('Import')}}</button>
                        <button type="button" class="m-3 btn btn-primary btn-responsive export">{{__('Export')}}</button>
                        <button type="button" class="m-3 btn btn-secondary btn-responsive template">{{__('Template')}}</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="users-data-table" class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th style="min-width:150px">{{ __('Avatar') }}</th>
                                    <th style="min-width:150px">{{ __('Name') }}</th>
                                    <th style="min-width:150px">{{ __('Role') }}</th>
                                    <th style="min-width:150px">{{ __('Email') }}</th>
                                    <th style="min-width:120px">{{ __('Phone') }}</th>
                                    <th style="min-width:120px">{{ __('Mobile') }}</th>
                                    <th style="min-width:120px">{{ __('Status') }}</th>
                                    <th style="min-width:100px">{{ __('Join On') }}</th>
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
    <!-- Add User Modal  -->
    <div class="modal fade modal-add-contact" data-bs-backdrop="static" id="addUser" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <form method="POST" action="#" id="add_new" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header px-4">
                        <h5 class="modal-title" id="exampleModalCenterTitle">{{ __('Add New User') }}</h5>
                    </div>

                    <div class="modal-body px-4">
                        {{-- Avatar --}}
                        <div class="form-group row mb-6">
                            <label for="coverImage" class="col-sm-4 col-lg-2 col-form-label">{{ __('User Image') }}</label>
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
                            {{-- ROLE --}}
                            <div class="col-lg-6">
                                <div class="form-group mb-4">
                                    <label for="role">{{ __('Role') }}</label>
                                    <select class="form-control" id="role" name="role">
                                        @if (auth()->user()->role == 'Admin')
                                            <option value="Owner">{{ __('Owner') }}</option>
                                            <option value="Admin">{{ __('Admin') }}</option>
                                        @endif
                                        <option value="Cashier">{{ __('Cashier') }}</option>
                                        <option value="Supplier">{{ __('Supplier') }}</option>
                                        <option value="Client">{{ __('Client') }}</option>
                                    </select>
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
                                    <label for="event">{{ __('Address') }}</label>
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
                            {{-- PASSWORD --}}

                            <div class="col-lg-6">
                                <div class="form-group mb-4">
                                    <label for="password">{{ __('Password') }}</label>
                                    <input id="password" type="password" class="form-control"
                                        placeholder="{{ __('Password') }}" name="password" required
                                        autocomplete="new-password">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group mb-4">
                                    <label for="password-confirm">{{ __('Confirm Password') }}</label>
                                    <input id="password-confirm" type="password" class="form-control"
                                        placeholder="{{ __('Confirm Password') }}" name="password_confirmation" required
                                        autocomplete="new-password">
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

    <!-- Modal para editar usuario -->
    <div class="modal fade" id="editUserModal" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">{{ __('Edit User') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Agrega aquí los campos del formulario para editar el usuario -->
                    <form id="editUserForm">
                        @csrf
                        <!-- Avatar -->
                        <div class="form-group row mb-6">
                            <label for="coverImageEdit" class="col-sm-4 col-lg-4">{{ __('User Image') }}
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
                            <!-- ROLE -->
                            <div class="col-lg-6">
                                <div class="form-group mb-4">
                                    <label for="edit-role">{{ __('Role') }}</label>
                                    <select class="form-control" id="edit-role" name="edit_role">
                                        @if (auth()->user()->role == 'Admin')
                                            <option value="Owner">{{ __('Owner') }}</option>
                                            <option value="Admin">{{ __('Admin') }}</option>
                                        @endif
                                        <option value="Cashier">{{ __('Cashier') }}</option>
                                        <option value="Supplier">{{ __('Supplier') }}</option>
                                        <option value="Client">{{ __('Client') }}</option>
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
    <script src="{{ asset('admin/assets/js/custom/users/table.js') }}"></script>
    <script src="{{ asset('admin/assets/js/custom/users/add.js') }}"></script>
    <script src="{{ asset('admin/assets/js/custom/users/update.js') }}"></script>
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

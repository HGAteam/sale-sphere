@extends('layouts.app')
@section('styles')
    <!-- Data Tables -->
    <link href="{{ asset('admin/assets/plugins/data-tables/datatables.bootstrap5.min.css') }}" rel='stylesheet'>
    <link href="{{ asset('admin/assets/plugins/data-tables/responsive.datatables.min.css') }}" rel='stylesheet'>
@endsection

@section('content')
    @include('layouts.admin.partials.breadcrumb', [
        'breadcrumb' => $breadcrumb,
        ($pageTitle = trans('Clients')),
        ($modalLink = '#addClient'),
        ($modalName = trans('Add Client')),
        ($href = ''),
    ])

    <div class="row">
        <div class="col-12">
            <div class="ec-cat-list card card-default">
                <div class="card-header py-0">
                    <div class="card-title">
                        <h1>{{__('Client List')}}</h1>
                    </div>
                    <div class="card-toolbar">
                        <button type="button" class="m-3 btn btn-warning import">{{__('Import')}}</button>
                        @if($clients)
                        <button type="button" class="m-3 btn btn-primary export">{{__('Export')}}</button>
                        @endif
                        <button type="button" class="m-3 btn btn-secondary template">{{__('Template')}}</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="clients-data-table" class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th style="min-width:100px">{{ __('Profile') }}</th>
                                    <th style="min-width:150px">{{ __('Contact') }}</th>
                                    <th style="min-width:150px">{{ __('DNI') }}</th>
                                    <th style="min-width:120px">{{ __('Status') }}</th>
                                    <th style="min-width:100px">{{ __('Address') }}</th>
                                    <th style="min-width:100px">{{ __('Location') }}</th>
                                    <th style="min-width:150px">{{ __('Email') }}</th>
                                    <th style="min-width:120px">{{ __('Phone') }}</th>
                                    <th style="min-width:120px">{{ __('Mobile') }}</th>
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

    <!-- Add Clients Modal  -->
    <div class="modal fade modal-add-contact" data-bs-backdrop="static" id="addClient" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <form method="POST" action="#" id="add_new" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header px-4">
                        <h5 class="modal-title" id="exampleModalCenterTitle">{{ __('Add Client') }}</h5>
                    </div>

                    <div class="modal-body px-4">
                        <!-- Avatar -->
                        <div class="form-group row">
                            <label for="coverImage" class="col-sm-4 col-lg-4">{{ __('Client Image') }}
                                <div class="">
                                    <!-- Imagen por defecto -->
                                    <img id="defaultImage" class="mb-5" src="/admin/assets/img/category/clothes.png"
                                        alt="Default Image" style="max-width: 100%; max-height: 150px;">
                                </div>
                            </label>
                            <div class="col-sm-12 col-lg-12">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="coverImage" name="image">
                                    <label class="custom-file-label" for="coverImage"
                                        id="customFileLabel">{{ __('Choose file') }}...</label>
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
                            {{-- DNI --}}
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="dni">{{ __('DNI') }}</label>
                                    <input type="text" class="form-control" id="dni" name="dni" value="">
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
                            <div class="col-lg-12">
                                <div class="form-group mb-4">
                                    <label for="details">{{ __('Details') }}</label>
                                    <textarea class="form-control" id="details" name="details"></textarea>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer px-4">
                        <button type="button" class="btn btn-secondary btn-pill" id="btnCancel">{{ __('Cancel') }}</button>
                        <button type="button" class="btn btn-primary btn-pill" id="btnSave">{{ __('Save') }}</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <!-- Modal para editar Clients -->
    <div class="modal fade" id="editClientModal" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="editClientModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editClientModalLabel">{{ __('Edit Client') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">x</button>
                </div>
                <div class="modal-body">
                    <!-- Agrega aquí los campos del formulario para editar el usuario -->
                    <form id="editClientForm">
                        @csrf
                        <!-- Avatar -->
                        <div class="form-group row mb-6">
                            <label for="coverImageEdit" class="col-sm-4 col-lg-4">{{ __('Client Image') }}
                                <div class="">
                                    <!-- Imagen por defecto -->
                                    <img id="defaultImageEdit" class="mb-5"
                                        src="/admin/assets/img/category/clothes.png" alt="Default Image"
                                        style="max-width: 100%; max-height: 150px;">
                                </div>
                            </label>
                            <div class="col-sm-8 col-lg-8">
                                <div class="custom-file my-8">
                                    <input type="file" class="custom-file-input" id="coverImageEdit"
                                        name="edit_image">
                                    <label class="custom-file-label" for="coverImageEdit"
                                        id="customFileLabelEditImage">{{ __('Choose file') }}...</label>
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
                            <!-- DNI -->
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="edit-dni">{{ __('DNI') }}</label>
                                    <input type="text" class="form-control" id="edit-dni" name="edit_dni"
                                        value="">
                                </div>
                            </div>
                            <!-- STATUS -->
                            <div class="col-lg-6">
                                <label for="edit-status">{{ __('Status') }}</label>
                                <div class="form-group mb-4">
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
                            <div class="col-lg-12">
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
    <script src="{{ asset('admin/assets/js/custom/clients/table.js') }}"></script>
    <script src="{{ asset('admin/assets/js/custom/clients/add.js') }}"></script>
    <script src="{{ asset('admin/assets/js/custom/clients/update.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            // Mostrar la imagen por defecto
            var userImage = '/admin/assets/img/category/clothes.png';
            $('#defaultImage').attr('src', userImage);

            // Manejar cambios en el input file para previsualizar la nueva imagen
            $('#coverImage').on('change', function() {
                var input = this;

                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        $('#defaultImage').attr('src', e.target.result);
                    };

                    reader.readAsDataURL(input.files[0]);
                } else {
                    // Si se deja en blanco, volver a mostrar la imagen actual
                    $('#defaultImage').attr('src', userImage);
                }
            });
        });

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

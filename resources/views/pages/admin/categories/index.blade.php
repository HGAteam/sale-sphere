@extends('layouts.app')
@section('styles')
    <!-- Data Tables -->
    <link href="{{ asset('admin/assets/plugins/data-tables/datatables.bootstrap5.min.css') }}" rel='stylesheet'>
    <link href="{{ asset('admin/assets/plugins/data-tables/responsive.datatables.min.css') }}" rel='stylesheet'>
@endsection

@section('content')
    @include('layouts.admin.partials.breadcrumb', [
        'breadcrumb' => $breadcrumb,
        ($pageTitle = trans('Categories')),
        ($modalLink = '#'),
        ($modalName = trans('Add Category')),
        ($href = ''),
    ])

    <div class="row">

        <div class="col-xl-4 col-lg-12">
            <div class="ec-cat-list card card-default mb-24px">
                <div class="card-body">
                    <div class="ec-cat-form">
                        <h4>{{ __('Add New Category') }}</h4>

                        <form method="POST" action="#" id="add_new" enctype="multipart/form-data">
                             @csrf
                            <!-- Avatar -->
                            <div class="form-group row">
                                <label for="coverImage" class="col-sm-4 col-lg-4">{{ __('Category Image') }}
                                    <div class="">
                                        <!-- Imagen por defecto -->
                                        <img id="defaultImage" class="mb-5" src="/admin/assets/img/category/clothes.png"
                                            alt="Default Image" style="max-width: 100%; max-height: 150px;">
                                    </div>
                                </label>
                                <div class="col-sm-12 col-lg-12">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="coverImage" name="image">
                                        <label class="custom-file-label" for="coverImage" id="customFileLabel">{{ __('Choose file') }}...</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Name -->
                            <div class="form-group row">
                                <label for="name" class="col-12 col-form-label">{{ __('Name') }}</label>
                                <div class="col-12">
                                    <input id="name" name="name" class="form-control"
                                        type="text">
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="form-group row">
                                <label class="col-12 col-form-label" for="status">{{ __('Status') }}</label>
                                <div class="col-12">
                                    <select class="form-control" id="status" name="status">
                                        <option value="Published">{{ __('Published') }}</option>
                                        <option value="Unpublished">{{ __('Unpublished') }}</option>
                                        <option value="Draft">{{ __('Draft') }}</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="form-group row">
                                <label class="col-12 col-form-label">{{ __('Details') }}</label>
                                <div class="col-12">
                                    <textarea id="details" name="details" cols="40" rows="4" class="form-control"></textarea>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <button type="button" id="btnSave" class="btn btn-primary">{{__('Submit')}}</button>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-8 col-lg-12">
            <div class="ec-cat-list card card-default">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="categories-data-table" class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th style="min-width:100px">{{ __('Thumb') }}</th>
                                    <th style="min-width:150px">{{ __('Name') }}</th>
                                    <th style="min-width:100px">{{ __('Status') }}</th>
                                    <th style="min-width:150px">{{ __('Created At') }}</th>
                                    <th style="min-width:100px" class="text-end"></th>
                                </tr>
                            </thead>

                            <tbody style="min-width: 200px"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Modal para editar categoria -->
    <div class="modal fade" id="editCategoryModal" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="editCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCategoryModalLabel">{{ __('Edit Category') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Agrega aquí los campos del formulario para editar el usuario -->
                    <form id="editCategoryForm">
                        @csrf
                        <!-- Avatar -->
                        <div class="form-group row mb-6">
                            <label for="coverImageEdit" class="col-sm-4 col-lg-4">{{ __('Category Image') }}
                                <div class="">
                                    <!-- Imagen por defecto -->
                                    <img id="defaultImageEdit" class="mb-5" src="/admin/assets/img/category/clothes.png"
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
                            <!-- NAME -->
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="edit-name">{{ __('Name') }}</label>
                                    <input type="text" class="form-control" id="edit-name" name="edit_name"
                                        value="John">
                                </div>
                            </div>
                            <!-- Status -->
                            <div class="col-lg-6">
                                <div class="form-group mb-4">
                                    <label for="edit-status">{{ __('Status') }}</label>
                                    <select class="form-control" id="edit-status" name="edit_status">
                                        <option value="Published">{{ __('Published') }}</option>
                                        <option value="Unpublished">{{ __('Unpublished') }}</option>
                                        <option value="Draft">{{ __('Draft') }}</option>
                                        @if (auth()->user()->role == 'Admin')
                                            <option value="Deleted">{{ __('Deleted') }}</option>
                                        @endif
                                    </select>
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
    <script src="{{ asset('admin/assets/js/custom/categories/table.js') }}"></script>
    <script src="{{ asset('admin/assets/js/custom/categories/add.js') }}"></script>
    <script src="{{ asset('admin/assets/js/custom/categories/update.js') }}"></script>

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

@extends('layouts.app')
@section('content')
    @include('layouts.admin.partials.breadcrumb', [
        'breadcrumb' => $breadcrumb,
        ($pageTitle = trans('Settings')),
        ($modalLink = '#'),
        ($modalName = ''),
        ($href = ''),
    ])

    <!-- Start Register -->
    <div class="container">
        <div class="ec-cat-list card card-default mb-24px">
            <div class="card-body">
                <form action="{{ route('settings.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row justify-content-center mb-3">
                        <label for="business_name" class="col-sm-4 col-md-3 col-form-label">{{ __('Business Name') }}:</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" id="business_name" name="business_name"
                                value="{{ old('business_name', $setting->business_name) }}">
                        </div>
                    </div>

                    <div class="row justify-content-center mb-3">
                        <label for="owner_name" class="col-sm-4 col-md-3 col-form-label">{{ __('Owner Name') }}:</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" id="owner_name" name="owner_name"
                                value="{{ old('owner_name', $setting->owner_name) }}">
                        </div>
                    </div>

                    <div class="row justify-content-center mb-3">
                        <label for="central_location"
                            class="col-sm-4 col-md-3 col-form-label">{{ __('Central Location') }}:</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" id="central_location" name="central_location"
                                value="{{ old('central_location', $setting->central_location) }}">
                        </div>
                    </div>

                    <div class="row justify-content-center mb-3">
                        <label for="location_code"
                            class="col-sm-4 col-md-3 col-form-label">{{ __('Location Code') }}:</label>
                        <div class="col-sm-5">
                            <textarea id="location_code" class="form-control" name="location-code" style="max-height: 100px">{{ old('location_code', $setting->location_code) }}</textarea>
                        </div>
                    </div>

                    <div class="row justify-content-center mb-3">
                        <label for="email" class="col-sm-4 col-md-3 col-form-label">{{ __('Email') }}:</label>
                        <div class="col-sm-5">
                            <input type="email" class="form-control" id="email" name="email"
                                value="{{ old('email', $setting->email) }}">
                        </div>
                    </div>

                    <div class="row justify-content-center mb-3">
                        <label for="cuit" class="col-sm-4 col-md-3 col-form-label">{{ __('CUIT') }}:</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" id="cuit" name="cuit"
                                value="{{ old('cuit', $setting->cuit) }}">
                        </div>
                    </div>

                    <div class="form-group row justify-content-center mb-3">
                        <label for="logo" class="col-sm-4 col-md-3 col-form-label">
                            <img id="defaultImage" class="mb-5"
                                src="{{ $setting->logo ? asset($setting->logo) : asset('/admin/assets/img/category/clothes.png') }}"
                                alt="Default Image" style="max-width: 100%; max-height: 150px;">

                        </label>
                        <div class="col-sm-5 my-8">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="logo" name="logo"
                                    value="{{ old('logo', $setting->logo) }}">
                                <label class="custom-file-label" for="logo"
                                    id="customFileLabel">{{ $setting->logo ? $setting->logo : __('Choose file') }}...</label>
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-center mb-3">
                        <label for="phone" class="col-sm-4 col-md-3 col-form-label">{{ __('Phone') }}:</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" id="phone" name="phone"
                                value="{{ old('phone', $setting->phone) }}">
                        </div>
                    </div>

                    <div class="row justify-content-center mb-3">
                        <label for="mobile" class="col-sm-4 col-md-3 col-form-label">{{ __('Mobile') }}:</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" id="mobile" name="mobile"
                                value="{{ old('mobile', $setting->mobile) }}">
                        </div>
                    </div>

                    <!-- Agrega más campos según sea necesario -->

                    <div class="row justify-content-center">
                        <div class="col-md-8 col-sm-9">
                            <button type="submit" id="save_settings" data-reload="true"
                                class="btn btn-primary mb-5 button-ajax">
                                @include('layouts.admin.partials._button-indicator', [
                                    'label' => __('Update Settings'),
                                ])
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Register -->

@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            // Mostrar la imagen existente si hay una
            var logoUrl = '{{ $setting->logo ? asset($setting->logo) : asset('/admin/assets/img/category/clothes.png') }}';
            $('#defaultImage').attr('src', logoUrl);

            // Mostrar el nombre del archivo si existe
            var fileName = '{{ $setting->logo }}';
            if (fileName) {
                document.getElementById('customFileLabel').innerText = fileName;
            }

            // Manejar cambios en el input file para previsualizar la nueva imagen y actualizar el nombre del archivo
            $('#logo').on('change', function() {
                var input = this;

                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        $('#defaultImage').attr('src', e.target.result);
                    };

                    reader.readAsDataURL(input.files[0]);
                } else {
                    // Si se deja en blanco, volver a mostrar la imagen actual
                    $('#defaultImage').attr('src', logoUrl);
                }

                // Actualizar el nombre del archivo solo en customFileLabel
                var fileName = this.value.split('\\').pop();
                document.getElementById('customFileLabel').innerText = fileName;
            });
        });
    </script>

    <script src="{{ asset('admin/assets/js/button-ajax.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection

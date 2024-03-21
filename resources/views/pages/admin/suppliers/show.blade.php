@extends('layouts.app')
@section('content')
    @include('layouts.admin.partials.breadcrumb', [
        'breadcrumb' => $breadcrumb,
        ($pageTitle = 'Profile'),
        ($modalLink = '#addSupplier'),
        ($modalName = trans('Go Back')),
        ($href = '/home/suppliers'),
    ])

    <div class="card bg-white profile-content">
        <div class="row">
            <div class="col-lg-4 col-xl-3">
                <div class="profile-content-left profile-left-spacing">
                    <div class="text-center widget-profile px-0 border-0">
                        <div class="card-img mx-auto rounded-circle">
                            <img src="{{ $supplier->image }}" alt="{{ $supplier->social_reason }}">
                        </div>
                        <div class="card-body">
                            <h4 class="py-2 text-dark">{{ $supplier->contact }}</h4>
                            <p>{{ $supplier->contact }}</p>
                            @switch($supplier->status)
                                @case('Active')
                                <span class="mt-3 badge badge-primary">{{ __($supplier->status) }}</span>
                                    @break
                                @case('Inactive')
                                <span class="mt-3 badge badge-secondary">{{ __($supplier->status) }}</span>
                                    @break
                                @default
                                <span class="mt-3 badge badge-danger">{{ __($supplier->status) }}</span>
                            @endswitch
                        </div>
                    </div>

                    <hr class="w-100">

                    <div class="contact-info text-center pt-4">
                        <h5 class="text-dark">{{ __('Contact Information') }}</h5>
                        <p class="text-dark font-weight-medium pt-24px mb-2">{{ __('Email address') }}</p>
                        <p>{{ $supplier->email }}</p>
                        <p class="text-dark font-weight-medium pt-24px mb-2">{{ __('Status') }}</p>
                        <p>
                            @switch($supplier->status)
                            @case('Active')
                            {{ __($supplier->status) }}
                                @break
                            @case('Inactive')
                            {{ __($supplier->status) }}
                                @break
                            @default
                            {{ __($supplier->status) }}
                        @endswitch
                        </p>
                        <p class="text-dark font-weight-medium pt-24px mb-2">{{ __('Phone Number') }}</p>
                        <p>
                            @if ($supplier->phone)
                                {{ $supplier->phone }}
                            @else
                                <b>--</b>
                            @endif
                        </p>
                        <p class="text-dark font-weight-medium pt-24px mb-2">{{ __('Mobile Number') }}</p>
                        <p>
                            @if ($supplier->mobile)
                                {{ $supplier->mobile }}
                            @else
                                <b>--</b>
                            @endif
                        </p>
                        <p class="text-dark font-weight-medium pt-24px mb-2">{{ __('Address') }}</p>
                        <p>
                            @if ($supplier->location && $supplier->address)
                                {{ $supplier->location . ', ' . $supplier->address }}
                            @else
                                <b>--</b>
                            @endif
                        </p>
                        <p class="text-dark font-weight-medium pt-24px mb-2">{{ __('Created At') }}</p>
                        <p>{{ $supplier->created_at->format('d M, Y') }}</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-8 col-xl-9">
                <div class="profile-content-right profile-right-spacing py-5">
                    <ul class="nav nav-tabs px-3 px-xl-5 nav-style-border" id="myProfileTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile"
                                type="button" role="tab" aria-controls="profile"
                                aria-selected="true">{{ __('Profile') }}</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="personal-info-tab" data-bs-toggle="tab"
                                data-bs-target="#personal-info" type="button" role="tab" aria-controls="personal-info"
                                aria-selected="true">{{ __('Personal Info') }}</button>
                        </li>
                    </ul>
                    <div class="tab-content px-3 px-xl-5" id="myTabContent">

                        <!-- Profile -->
                        <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <div class="tab-widget mt-5">
                                <div class="row">

                                    <div class="col-xl-4 col-sm-4">
                                        <div class="media widget-media p-3 bg-white border">
                                            <div class="icon rounded-circle mr-3 bg-primary">
                                                <i class="mdi mdi-account-outline text-white "></i>
                                            </div>

                                            <div class="media-body align-self-center">
                                                <h4 class="text-primary mb-2">0</h4>
                                                <p>{{ __('Suppliers') }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-sm-4">
                                        <div class="media widget-media p-3 bg-white border">
                                            <div class="icon rounded-circle bg-warning mr-3">
                                                <i class="mdi mdi-cart-outline text-white "></i>
                                            </div>

                                            <div class="media-body align-self-center">
                                                <h4 class="text-primary mb-2">0</h4>
                                                <p>{{ __('Total Sales') }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-sm-4">
                                        <div class="media widget-media p-3 bg-white border">
                                            <div class="icon rounded-circle mr-3 bg-success">
                                                <i class="mdi mdi-ticket-percent text-white "></i>
                                            </div>

                                            <div class="media-body align-self-center">
                                                <h4 class="text-primary mb-2">0</h4>
                                                <p>{{ __('Promotions') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xl-12">

                                        <!-- Notification Table -->
                                        <div class="card card-default">
                                            <div class="card-header justify-content-between mb-1">
                                                <h2>Latest Notifications</h2>
                                                <div>
                                                    <button class="text-black-50 mr-2 font-size-20"><i
                                                            class="mdi mdi-cached"></i></button>
                                                    <div class="dropdown show d-inline-block widget-dropdown">
                                                        <a class="dropdown-toggle icon-burger-mini" href="#"
                                                            role="button" id="dropdown-notification"
                                                            data-bs-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false" data-display="static"></a>
                                                        <ul class="dropdown-menu dropdown-menu-right"
                                                            aria-labelledby="dropdown-notification">
                                                            <li class="dropdown-item"><a href="#">Action</a></li>
                                                            <li class="dropdown-item"><a href="#">Another action</a>
                                                            </li>
                                                            <li class="dropdown-item"><a href="#">Something else
                                                                    here</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="card-body compact-notifications" data-simplebar
                                                style="height: 434px;">
                                                <div class="media pb-3 align-items-center justify-content-between">
                                                    <div
                                                        class="d-flex rounded-circle align-items-center justify-content-center mr-3 media-icon iconbox-45 bg-primary text-white">
                                                        <i class="mdi mdi-cart-outline font-size-20"></i>
                                                    </div>
                                                    <div class="media-body pr-3 ">
                                                        <a class="mt-0 mb-1 font-size-15 text-dark" href="#">New
                                                            Order</a>
                                                        <p>Selena has placed an new order</p>
                                                    </div>
                                                    <span class=" font-size-12 d-inline-block"><i
                                                            class="mdi mdi-clock-outline"></i> 10
                                                        AM</span>
                                                </div>

                                                <div class="media py-3 align-items-center justify-content-between">
                                                    <div
                                                        class="d-flex rounded-circle align-items-center justify-content-center mr-3 media-icon iconbox-45 bg-success text-white">
                                                        <i class="mdi mdi-email-outline font-size-20"></i>
                                                    </div>
                                                    <div class="media-body pr-3">
                                                        <a class="mt-0 mb-1 font-size-15 text-dark" href="#">New
                                                            Enquiry</a>
                                                        <p>Phileine has placed an new order</p>
                                                    </div>
                                                    <span class=" font-size-12 d-inline-block"><i
                                                            class="mdi mdi-clock-outline"></i> 9
                                                        AM</span>
                                                </div>


                                                <div class="media py-3 align-items-center justify-content-between">
                                                    <div
                                                        class="d-flex rounded-circle align-items-center justify-content-center mr-3 media-icon iconbox-45 bg-warning text-white">
                                                        <i class="mdi mdi-stack-exchange font-size-20"></i>
                                                    </div>
                                                    <div class="media-body pr-3">
                                                        <a class="mt-0 mb-1 font-size-15 text-dark" href="#">Support
                                                            Ticket</a>
                                                        <p>Emma has placed an new order</p>
                                                    </div>
                                                    <span class=" font-size-12 d-inline-block"><i
                                                            class="mdi mdi-clock-outline"></i> 10
                                                        AM</span>
                                                </div>

                                                <div class="media py-3 align-items-center justify-content-between">
                                                    <div
                                                        class="d-flex rounded-circle align-items-center justify-content-center mr-3 media-icon iconbox-45 bg-primary text-white">
                                                        <i class="mdi mdi-cart-outline font-size-20"></i>
                                                    </div>
                                                    <div class="media-body pr-3">
                                                        <a class="mt-0 mb-1 font-size-15 text-dark" href="#">New
                                                            order</a>
                                                        <p>Ryan has placed an new order</p>
                                                    </div>
                                                    <span class=" font-size-12 d-inline-block"><i
                                                            class="mdi mdi-clock-outline"></i> 10
                                                        AM</span>
                                                </div>

                                                <div class="media py-3 align-items-center justify-content-between">
                                                    <div
                                                        class="d-flex rounded-circle align-items-center justify-content-center mr-3 media-icon iconbox-45 bg-info text-white">
                                                        <i class="mdi mdi-calendar-blank font-size-20"></i>
                                                    </div>
                                                    <div class="media-body pr-3">
                                                        <a class="mt-0 mb-1 font-size-15 text-dark" href="">Comapny
                                                            Meetup</a>
                                                        <p>Phileine has placed an new order</p>
                                                    </div>
                                                    <span class=" font-size-12 d-inline-block"><i
                                                            class="mdi mdi-clock-outline"></i> 10
                                                        AM</span>
                                                </div>

                                                <div class="media py-3 align-items-center justify-content-between">
                                                    <div
                                                        class="d-flex rounded-circle align-items-center justify-content-center mr-3 media-icon iconbox-45 bg-warning text-white">
                                                        <i class="mdi mdi-stack-exchange font-size-20"></i>
                                                    </div>
                                                    <div class="media-body pr-3">
                                                        <a class="mt-0 mb-1 font-size-15 text-dark" href="#">Support
                                                            Ticket</a>
                                                        <p>Emma has placed an new order</p>
                                                    </div>
                                                    <span class=" font-size-12 d-inline-block"><i
                                                            class="mdi mdi-clock-outline"></i> 10
                                                        AM</span>
                                                </div>

                                                <div class="media py-3 align-items-center justify-content-between">
                                                    <div
                                                        class="d-flex rounded-circle align-items-center justify-content-center mr-3 media-icon iconbox-45 bg-success text-white">
                                                        <i class="mdi mdi-email-outline font-size-20"></i>
                                                    </div>
                                                    <div class="media-body pr-3">
                                                        <a class="mt-0 mb-1 font-size-15 text-dark" href="#">New
                                                            Enquiry</a>
                                                        <p>Phileine has placed an new order</p>
                                                    </div>
                                                    <span class=" font-size-12 d-inline-block"><i
                                                            class="mdi mdi-clock-outline"></i> 9
                                                        AM</span>
                                                </div>

                                            </div>
                                            <div class="mt-3"></div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- Personal Info -->
                        <div class="tab-pane fade" id="personal-info" role="tabpanel"
                            aria-labelledby="personal-info-tab">
                            <div class="tab-pane-content mt-5">
                                <form method="POST" action="#" enctype="multipart/form-data">
                                    @csrf
                                    <!-- Avatar -->
                                    <div class="form-group row mb-6">
                                        <label for="coverImage" class="col-sm-4 col-lg-4">{{ __('User Image') }}
                                            <div class="">
                                                <!-- Imagen por defecto -->
                                                <img id="defaultImage" class="mb-5" src="{{ $supplier->image }}"
                                                    alt="Default Image" style="max-width: 100%; max-height: 150px;">
                                            </div>
                                        </label>
                                        <div class="col-sm-8 col-lg-8">
                                            <div class="custom-file my-8">
                                                <input type="file" class="custom-file-input" id="coverImage"
                                                    name="image" required>
                                                <label class="custom-file-label" for="coverImage"
                                                    id="customFileLabel">{{ __('Choose file') }}...</label>
                                                <div class="invalid-feedback">
                                                    {{ __('Example invalid custom file feedback') }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Inputs -->
                                    <div class="row mb-2">
                                        <!-- Name -->
                                        <div class="col-lg-6 col-sm-6">
                                            <div class="form-group">
                                                <label for="social_reason">{{ __('Social Reason') }}</label>
                                                <input type="text" class="form-control" id="social_reason" name="social_reason"
                                                    value="{{ old('social_reason', $supplier->social_reason) }}">
                                            </div>
                                        </div>
                                        <!-- Last Name -->
                                        <div class="col-lg-6 col-sm-6">
                                            <div class="form-group">
                                                <label for="contact">{{ __('Contact') }}</label>
                                                <input type="text" class="form-control" id="contact"
                                                    name="contact" value="{{ old('contact', $supplier->contact) }}">
                                            </div>
                                        </div>
                                        <!-- Email -->
                                        <div class="col-lg-12 col-sm-12">
                                            <div class="form-group mb-4">
                                                <label for="email">{{ __('Email') }}</label>
                                                <input type="email" class="form-control" id="email" name="email"
                                                    value="{{ old('email', $supplier->email) }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <!-- Location -->
                                        <div class="col-lg-6 col-sm-6">
                                            <div class="form-group">
                                                <label for="location">{{ __('Location') }}</label>
                                                <input type="text" class="form-control" id="location"
                                                    name="location" value="{{ old('location', $supplier->location) }}">
                                            </div>
                                        </div>
                                        <!-- Address -->
                                        <div class="col-lg-6 col-sm-6">
                                            <div class="form-group">
                                                <label for="address">{{ __('Address') }}</label>
                                                <input type="text" class="form-control" id="address" name="address"
                                                    value="{{ old('address', $supplier->address) }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <!-- Phone -->
                                        <div class="col-lg-6 col-sm-6">
                                            <div class="form-group">
                                                <label for="phone">{{ __('Phone') }}</label>
                                                <input type="text" class="form-control" id="phone" name="phone"
                                                    value="{{ old('phone', $supplier->phone) }}">
                                            </div>
                                        </div>
                                        <!-- Mobile -->
                                        <div class="col-lg-6 col-sm-6">
                                            <div class="form-group">
                                                <label for="mobile">{{ __('Mobile') }}</label>
                                                <input type="text" class="form-control" id="mobile" name="mobile"
                                                    value="{{ old('mobile', $supplier->mobile) }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-end mt-5">
                                        <button type="submit" id="save_personal_info" data-reload="true"
                                            class="btn btn-lg btn-primary w-100 mb-5 button-ajax">
                                            @include('layouts.admin.partials._button-indicator', [
                                                'label' => __('Update Profile'),
                                            ])
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var supplierData = @json($supplier); // Convertir el objeto PHP a JSON

            // Mostrar la imagen del usuario si existe, de lo contrario, mostrar la imagen por defecto
            var supplierImage = supplierData && supplierData.image ? supplierData.image : supplierData.image;
            var defaultImage = document.getElementById('defaultImage');
            defaultImage.src = supplierImage;
            defaultImage.alt = supplierData ? supplierData.social_reason + ' ' + supplierData.contact : 'Default Image';

            // Manejar cambios en el input file para previsualizar la nueva imagen
            var coverImage = document.getElementById('coverImage');
            var customFileLabel = document.getElementById('customFileLabel');
            coverImage.addEventListener('change', function() {
                var input = this;

                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        defaultImage.src = e.target.result;
                    };

                    reader.readAsDataURL(input.files[0]);

                    // Mostrar el nombre de la imagen seleccionada
                    customFileLabel.innerText = input.files[0].social_reason;
                } else {
                    // Si se deja en blanco, volver a mostrar la imagen actual
                    defaultImage.src = supplierImage;
                    customFileLabel.innerText = 'Choose file';
                }
            });

            // Mostrar el nombre de la imagen si ya está cargada
            if (supplierData && supplierData.image) {
                customFileLabel.innerText = supplierData.image.split('/').pop();
            }
        });
    </script>
    <script src="{{ asset('admin/assets/js/button-ajax.js') }}"></script>
@endsection

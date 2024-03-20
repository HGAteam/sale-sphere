@extends('layouts.app')
@section('content')
    @include('layouts.admin.partials.breadcrumb', [
        'breadcrumb' => $breadcrumb,
        ($pageTitle = 'Profile'),
        ($modalLink = '#addUser'),
        ($modalName = 'Go Back'),
        ($href = '/home/users'),
    ])

    <div class="card bg-white profile-content">
        <div class="row">
            <div class="col-lg-4 col-xl-3">
                <div class="profile-content-left profile-left-spacing">
                    <div class="text-center widget-profile px-0 border-0">
                        <div class="card-img mx-auto rounded-circle">
                            @if ($user->avatar)
                                <img src="{{ asset($user->avatar) }}" alt="{{ $user->name . ' ' . $user->lastname }}">
                            @else
                                <img src="{{ asset('admin/assets/img/user/u1.jpg') }}"
                                    alt="{{ $user->name . ' ' . $user->lastname }}">
                            @endif

                        </div>
                        <div class="card-body">
                            <h4 class="py-2 text-dark">{{ $user->name . ' ' . $user->lastname }}</h4>
                            <p>{{ $user->email }}</p>
                            <span class="mt-3 badge badge-primary">{{ __($user->role) }}</span>
                            {{-- <a class="btn btn-primary my-3" href="#">{{ __('Follow') }}</a> --}}
                        </div>
                    </div>

                    <hr class="w-100">

                    <div class="contact-info text-center pt-4">
                        <h5 class="text-dark">{{ __('Contact Information') }}</h5>
                        <p class="text-dark font-weight-medium pt-24px mb-2">{{ __('Email address') }}</p>
                        <p>{{ $user->email }}</p>
                        <p class="text-dark font-weight-medium pt-24px mb-2">{{ __('Status') }}</p>
                        <p>
                            @switch($user->status)
                                @case(1)
                                    {{ __('Active') }}
                                @break

                                @default
                                    {{ __('Inactive') }}
                            @endswitch
                        </p>
                        <p class="text-dark font-weight-medium pt-24px mb-2">{{ __('Phone Number') }}</p>
                        <p>
                            @if ($user->phone)
                                {{ $user->phone }}
                            @else
                                <b>--</b>
                            @endif
                        </p>
                        <p class="text-dark font-weight-medium pt-24px mb-2">{{ __('Mobile Number') }}</p>
                        <p>
                            @if ($user->mobile)
                                {{ $user->mobile }}
                            @else
                                <b>--</b>
                            @endif
                        </p>
                        <p class="text-dark font-weight-medium pt-24px mb-2">{{ __('Address') }}</p>
                        <p>
                            @if ($user->location && $user->address)
                                {{ $user->location . ', ' . $user->address }}
                            @else
                                <b>--</b>
                            @endif
                        </p>
                        <p class="text-dark font-weight-medium pt-24px mb-2">{{ __('Created At') }}</p>
                        <p>{{ $user->created_at->format('d M, Y') }}</p>
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
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="settings-tab" data-bs-toggle="tab" data-bs-target="#settings"
                                type="button" role="tab" aria-controls="settings"
                                aria-selected="false">{{ __('Account Settings') }}</button>
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
                                                <h4 class="text-primary mb-2">546</h4>
                                                <p>{{ __('Bought') }}</p>
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
                                                <h4 class="text-primary mb-2">02</h4>
                                                <p>{{ __('Voucher') }}</p>
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
                                <form method="POST"
                                    action="{{ route('users.update_personal_info', ['id' => $user->id]) }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <!-- Avatar -->
                                    <div class="form-group row mb-6">
                                        <label for="coverImage" class="col-sm-4 col-lg-4">{{ __('User Image') }}
                                            <div class="">
                                                <!-- Imagen por defecto -->
                                                <img id="defaultImage" class="mb-5"
                                                    src="/admin/assets/img/category/clothes.png" alt="Default Image"
                                                    style="max-width: 100%; max-height: 150px;">
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
                                                <label for="edit-name">{{ __('First name') }}</label>
                                                <input type="text" class="form-control" id="edit-name" name="name"
                                                    value="{{ old('name', $user->name) }}">
                                            </div>
                                        </div>
                                        <!-- Last Name -->
                                        <div class="col-lg-6 col-sm-6">
                                            <div class="form-group">
                                                <label for="edit-lastname">{{ __('Last name') }}</label>
                                                <input type="text" class="form-control" id="edit-lastname"
                                                    name="lastname" value="{{ old('lastname', $user->lastname) }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <!-- Location -->
                                        <div class="col-lg-6 col-sm-6">
                                            <div class="form-group">
                                                <label for="edit-location">{{ __('Location') }}</label>
                                                <input type="text" class="form-control" id="edit-location"
                                                    name="location" value="{{ old('location', $user->location) }}">
                                            </div>
                                        </div>
                                        <!-- Address -->
                                        <div class="col-lg-6 col-sm-6">
                                            <div class="form-group">
                                                <label for="edit-address">{{ __('Address') }}</label>
                                                <input type="text" class="form-control" id="edit-address"
                                                    value="{{ old('address', $user->address) }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <!-- Phone -->
                                        <div class="col-lg-6 col-sm-6">
                                            <div class="form-group">
                                                <label for="edit-phone">{{ __('Phone') }}</label>
                                                <input type="text" class="form-control" id="edit-phone"
                                                    name="phone" value="{{ old('phone', $user->phone) }}">
                                            </div>
                                        </div>
                                        <!-- Mobile -->
                                        <div class="col-lg-6 col-sm-6">
                                            <div class="form-group">
                                                <label for="edit-mobile">{{ __('Mobile') }}</label>
                                                <input type="text" class="form-control" id="edit-mobile"
                                                    name="mobile" value="{{ old('mobile', $user->mobile) }}">
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

                        <!-- Settings -->
                        <div class="tab-pane fade" id="settings" role="tabpanel" aria-labelledby="settings-tab">
                            <div class="tab-pane-content mt-5">
                                <form method="POST"
                                    action="{{ route('users.update_password', ['id' => $user->id]) }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <!-- Email -->
                                    <div class="form-group mb-4">
                                        <label for="email">{{ __('Email') }}</label>
                                        <input type="email" class="form-control" id="email"
                                            value="{{ old('email', $user->email) }}">
                                    </div>

                                    <!-- Old Password -->
                                    <div class="form-group mb-4">
                                        <label for="oldPassword">{{ __('Old Password') }}</label>
                                        <input type="password" class="form-control" id="oldPassword"
                                            name="old_password">
                                    </div>

                                    <!-- New Password -->
                                    <div class="form-group mb-4">
                                        <label for="newPassword">{{ __('New password') }}</label>
                                        <input type="password" class="form-control" id="newPassword"
                                            name="new_password">
                                    </div>

                                    <!-- Confirm Password -->
                                    <div class="form-group mb-4">
                                        <label for="conPassword">{{ __('Confirm password') }}</label>
                                        <input type="password" class="form-control" id="conPassword"
                                            name="confirm_password">
                                    </div>

                                    <!-- Button Submit -->
                                    <div class="d-flex justify-content-end mt-5">
                                        <button type="submit" id="save_new_password" data-reload="true"
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
            var userData = @json($user); // Convertir el objeto PHP a JSON

            // Mostrar la imagen del usuario si existe, de lo contrario, mostrar la imagen por defecto
            var userImage = userData && userData.avatar ? '/' + userData.avatar :
                '/admin/assets/img/category/clothes.png';
            var defaultImage = document.getElementById('defaultImage');
            defaultImage.src = userImage;
            defaultImage.alt = userData ? userData.name + ' ' + userData.lastname : 'Default Image';

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
                    customFileLabel.innerText = input.files[0].name;
                } else {
                    // Si se deja en blanco, volver a mostrar la imagen actual
                    defaultImage.src = userImage;
                    customFileLabel.innerText = 'Choose file';
                }
            });

            // Mostrar el nombre de la imagen si ya está cargada
            if (userData && userData.avatar) {
                customFileLabel.innerText = userData.avatar.split('/').pop();
            }
        });
    </script>

    <script src="{{ asset('admin/assets/js/button-ajax.js') }}"></script>
@endsection

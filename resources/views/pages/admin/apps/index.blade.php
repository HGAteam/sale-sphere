@extends('layouts.app')
@section('styles')
    <style>

        /* Estilo para el icono de verificación */
        .features li::before,
        .benefits li::before {
            content: "\f134"; /* Código de la check con circulo */
            font-family: "Material Design Icons"; /* Familia de fuentes de los iconos */
            margin-right: 5px; /* Espacio entre el icono y el texto */
            color: green; /* Color del icono */
        }

        /* Estilo para el texto dentro de los elementos <li> */
        .features li,
        .benefits li {
            font-size: 0.9em; /* Tamaño de fuente más pequeño */
            font-weight: lighter; /* Peso de fuente más ligero */
        }
    </style>
@endsection

@section('content')
    @include('layouts.admin.partials.breadcrumb', [
        'breadcrumb' => $breadcrumb,
        ($pageTitle = trans('Apps')),
        ($modalLink = '#'),
        ($modalName = ''),
        ($href = ''),
    ])

    <div class="card card-default p-4 ec-card-space">
        <div class="ec-vendor-card mt-m-24px row">

            @foreach (\App\Models\Module::orderBy('id', 'ASC')->get() as $module)
                <div class="col-lg-6 col-xl-6 col-xxl-3">
                    <div class="card card-default mt-24px">
                        <a href="javascript:0" class="view-detail">
                            <i class="mdi mdi-eye-plus-outline"></i>
                        </a>
                        <div class="vendor-info card-body text-center p-4">
                            <a href="javascript:void(0);" class="text-secondary d-inline-block mb-3 modal-application">
                                <div class="image mb-3">
                                    <img src="{{ asset($module->image) }}" class="img-fluid rounded-circle"
                                        alt="Avatar Image">
                                </div>

                                <h5 class="card-title text-dark">{{ __($module->title) }}</h5>
                                <p>{!! $module->details !!}</p>
                            </a>
                            <div class="row justify-content-center ec-vendor-detail">
                                <div class="col-sm-6 col-lg-6">
                                    @if ($module->status != 'Completed')
                                        @if ($module->status == 'In process')
                                        <h6 class="text-uppercase bg-primary text-white">{{ __('Awaiting Answers') }}</h6>
                                        @else
                                        <h6 class="text-uppercase bg-success text-white">{{ __('Price') }}</h6>
                                        <h5>$ {{ $module->price }}</h5>
                                        @endif
                                    @else
                                        <h6 class="text-uppercase bg-secondary text-white">{{ __('Currently Added') }}</h6>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>

    <!-- Applications Modal -->
    <div class="modal fade" id="modal-application" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header justify-content-end border-bottom-0">
                    <button type="button" class="btn-close-icon" data-bs-dismiss="modal" aria-label="Close">
                        <i class="mdi mdi-close"></i>
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <div class="row no-gutters">
                        <div class="col-md-6">
                            <div class="profile-content-left px-4">
                                <div class="text-center widget-profile px-0 border-0">
                                    <div class="card-img mx-auto rounded-circle">
                                        <img src="{{ asset('images/apps/default.jpg') }}" alt="user image">
                                    </div>
                                    <div class="card-body">
                                        <h4 class="py-2 text-dark"></h4>
                                        <p>{{__('Detalles')}}</p>
                                        <a class="btn btn-success btn-pill my-3 buy-now" href="#">{{ __('Buy') }} $ <span></span></a>
                                        <a class="btn btn-secondary btn-pill my-3 disabled currently-added" href="javascript:void(0)">{{ __('Currently Added') }}</a>
                                        <a class="btn btn-primary btn-pill my-3 disabled in-process" href="javascript:void(0)">{{ __('In Process') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="contact-info px-4">
                                <h4 class="text-dark mb-1">{{ __('Application Details') }}</h4>
                                <p class="text-dark font-weight-medium pt-3 mb-2">{{ __('Benefits') }}</p>
                                <ul class="benefits" id="benefitsList"></ul>
                                <p class="text-dark font-weight-medium pt-3 mb-2">{{ __('Features') }}</p>
                                <ul class="features" id="featuresList"></ul>
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
    $(document).ready(function(){
        // Manejar evento de clic en el botón que abre el modal
        $('.view-detail').click(function(){
            // Obtener el índice del módulo
            var index = $(this).closest('.col-lg-6').index();
            // Obtener la información del módulo correspondiente
            var module = {!! json_encode(\App\Models\Module::orderBy('id', 'ASC')->get()) !!}[index];

            // Actualizar el contenido del modal con la información del módulo
            $('#modal-application .modal-title').text(module.title);
            $('#modal-application .profile-content-left img').attr('src', module.image);
            $('#modal-application .buy-now span').text(module.price);
            $('#modal-application .profile-content-left h4').text(module.title);
            $('#modal-application .profile-content-left p').html(module.details);

            // Insertar beneficios
            $('#benefitsList').html(module.benefits);

            // Insertar características
            $('#featuresList').html(module.features);

            // Mostrar el modal
            $('#modal-application').modal('show');

            // Mostrar u ocultar botones según el estado del módulo
            if (module.status === 'Completed') {
                $('#modal-application .buy-now').hide(); // Ocultar botón de compra
                $('#modal-application .in-process').hide(); // Mostrar botón de in process
                $('#modal-application .currently-added').show(); // Mostrar botón "Currently Added"
            } else if (module.status === 'Pending') {
                $('#modal-application .buy-now').show(); // Mostrar botón de compra
                $('#modal-application .in-process').hide(); // Mostrar botón de in process
                $('#modal-application .currently-added').hide(); // Ocultar botón "Currently Added"
            } else if (module.status === 'In process') {
                $('#modal-application .buy-now').hide(); // Mostrar botón de compra
                $('#modal-application .currently-added').hide(); // Ocultar botón "Currently Added"
                $('#modal-application .in-process').show(); // Mostrar botón de in process
            }
        });
    });
</script>
@endsection

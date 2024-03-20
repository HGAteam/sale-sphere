<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="description" content="Pamela - Almacén de productos varios de San Miguel de Tucumán">

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>{{ !config('app.name')? config('app.name') :  $pageTitle.' | '.config('app.name') }}</title>

<!-- GOOGLE FONTS -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link
    href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300;400;500;600;700;800&family=Poppins:wght@300;400;500;600;700;800;900&family=Roboto:wght@400;500;700;900&display=swap"
    rel="stylesheet">

<link href="https://cdn.materialdesignicons.com/4.4.95/css/materialdesignicons.min.css" rel="stylesheet" />

<!-- PLUGINS CSS STYLE -->
<link href="{{ asset('admin/assets/plugins/daterangepicker/daterangepicker.css') }}" rel="stylesheet">
<link href="{{ asset('admin/assets/plugins/simplebar/simplebar.css') }}" rel="stylesheet" />
<link href="{{ asset('admin/assets/plugins/toastr/build/toastr.min.css') }}" rel="stylesheet" >

<!-- Ekka CSS -->
<link id="ekka-css" href="{{ asset('admin/assets/css/ekka.css') }}" rel="stylesheet" />
<link href="{{ asset('plugins/sweetalert2/dist/sweetalert2.css') }}" rel="stylesheet">
<!-- FAVICON -->
<link href="{{ asset('admin/assets/img/logo/icon.png') }}" rel="shortcut icon" />

@yield('styles')

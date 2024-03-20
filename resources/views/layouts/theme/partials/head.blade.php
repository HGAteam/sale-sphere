<meta charset="UTF-8">
     <meta http-equiv="x-ua-compatible" content="ie=edge" />
     <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">

     <title>{{ config('app.name')? config('app.name') : 'Algo | ' . config('app.name')}}</title>

     <meta name="keywords"
         content="apparel, catalog, clean, ecommerce, ecommerce HTML, electronics, fashion, html eCommerce, html store, minimal, multipurpose, multipurpose ecommerce, online store, responsive ecommerce template, shops" />
     <meta name="description" content="Best ecommerce html template for single and multi vendor store.">
     <meta name="author" content="ashishmaraviya">

     <!-- site Favicon -->
     <link rel="icon" href="{{ asset('admin/assets/img/logo/icon.png') }}" sizes="32x32" />
     <link rel="apple-touch-icon" href="{{asset('theme/assets/images/favicon/favicon.png')}}" />
     <meta name="msapplication-TileImage" content="assets/images/favicon/favicon.png')}}" />

     @yield('meta-tags')

     <!-- css Icon Font -->
     <link rel="stylesheet" href="{{asset('theme/assets/css/vendor/ecicons.min.css')}}" />

     <!-- css All Plugins Files -->
     <link rel="stylesheet" href="{{asset('theme/assets/css/plugins/animate.css')}}" />
     <link rel="stylesheet" href="{{asset('theme/assets/css/plugins/swiper-bundle.min.css')}}" />
     <link rel="stylesheet" href="{{asset('theme/assets/css/plugins/jquery-ui.min.css')}}" />
     <link rel="stylesheet" href="{{asset('theme/assets/css/plugins/countdownTimer.css')}}" />
     <link rel="stylesheet" href="{{asset('theme/assets/css/plugins/slick.min.css')}}" />
     <link rel="stylesheet" href="{{asset('theme/assets/css/plugins/bootstrap.css')}}" />

     <!-- Main Style -->
     <link rel="stylesheet" href="{{asset('theme/assets/css/demo1.css')}}" />
     <link rel="stylesheet" href="{{asset('theme/assets/css/style.css')}}" />
     <link rel="stylesheet" href="{{asset('theme/assets/css/responsive.css')}}" />

     <!-- Background css -->
     <link rel="stylesheet" id="bg-switcher-css" href="{{asset('theme/assets/css/backgrounds/bg-4.css')}}">

     @yield('styles')

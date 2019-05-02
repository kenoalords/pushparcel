<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | {{ config('app.name') }} - {{ config('app.description') }}</title>
    <!-- Primary Meta Tags -->
    <meta name="title" content="@yield('title') | {{ config('app.name') }} - {{ config('app.description') }}">
    <meta name="description" content="@yield( 'description' )">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ Request::url() }}">
    <meta property="og:title" content="@yield('title') | {{ config('app.name') }} - {{ config('app.description') }}">
    <meta property="og:description" content="@yield('description')">
    <meta property="og:image" content="https://metatags.io/assets/meta-tags-16a33a6a8531e519cc0936fbba0ad904e52d35f34a46c97a2c9f6f7dd7d336f2.png">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ Request::url() }}">
    <meta property="twitter:title" content="@yield('title') | {{ config('app.name') }} - {{ config('app.description') }}">
    <meta property="twitter:description" content="@yield('description')">
    <meta property="twitter:image" content="https://metatags.io/assets/meta-tags-16a33a6a8531e519cc0936fbba0ad904e52d35f34a46c97a2c9f6f7dd7d336f2.png">
    <!-- Fonts -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,700,900" rel="stylesheet" type="text/css">
    <link rel="icon" href="{{ asset('images/icon.png') }}">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}?v=1.1" rel="stylesheet">
    <script type="text/javascript">
        window.push = {
            basePrice: {{ env('BASE_PRICE') }},
            costPerKmShort: {{ env('COST_PER_KILOMETER_SHORT') }},
            costPerKmLong: {{ env('COST_PER_KILOMETER_LONG') }},
            officeAddress: "{{ config('app.office_address') }}",
            pickupCostPerKM: {{ env('PICKUP_COST_PER_KM') }},
            contactNumber: "{{ config('app.contact_number') }}",
        }
    </script>
</head>
<body>
    <div id="app">
        @include('partials.menu')
        @yield('content')
        @include('partials.footer')
    </div>
    <!-- <script type="text/javascript" src="https://js.paystack.co/v1/inline.js"></script> -->
    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('app.google_maps_key') }}&libraries=places"></script>
    <script type="text/javascript" src="{{ asset('js/app.js') }}?v=1.1"></script>
    @if ( App::environment() === 'production' )
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-139456203-1"></script>
        <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-139456203-1');
        </script>
    @endif
</body>
</html>

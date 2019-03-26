<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} - {{ config('app.description') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,700,900" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script type="text/javascript">
        window.push = {
            basePrice: {{ env('BASE_PRICE') }},
            costPerKmShort: {{ env('COST_PER_KILOMETER_SHORT') }},
            costPerKmLong: {{ env('COST_PER_KILOMETER_LONG') }}
        }
    </script>
</head>
<body>
    <div id="app">
        @include('partials.menu')
        @yield('content')
        @include('partials.footer')
    </div>
    <script type="text/javascript" src="https://js.paystack.co/v1/inline.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDIMAdin_T1ln_sMQ_N8wAZaYXAoiBvMAY&libraries=places"></script>
    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
</body>
</html>

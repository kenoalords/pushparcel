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
    <meta property="og:image" content="{{ asset('images/social-banner.jpg') }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ Request::url() }}">
    <meta property="twitter:title" content="@yield('title') | {{ config('app.name') }} - {{ config('app.description') }}">
    <meta property="twitter:description" content="@yield('description')">
    <meta property="twitter:image" content="{{ asset('images/social-banner.jpg') }}">
    <!-- Fonts -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,700,900|Lato:300,400,700,900" rel="stylesheet" type="text/css">
    <link rel="icon" href="{{ asset('images/icon.png') }}">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}?v=1.4" rel="stylesheet">
    <script type="text/javascript">
        window.push = {
            basePrice: {{ env('BASE_PRICE') }},
            costPerKmShort: {{ env('COST_PER_KILOMETER_SHORT') }},
            costPerKmLong: {{ env('COST_PER_KILOMETER_LONG') }},
            officeAddress: "{{ config('app.office_address') }}",
            pickupCostPerKM: {{ env('PICKUP_COST_PER_KM') }},
            contactNumber: "{{ config('app.contact_number') }}",
            images: "{{ asset('images') }}"
        }
    </script>
    @if ( App::environment() === 'production' )
        <!-- Facebook Pixel Code -->
        <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
        n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s)}(window, document,'script',
        'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '2238608086214969');
        fbq('track', 'PageView');
        </script>
        <noscript><img height="1" width="1" style="display:none"
        src="https://www.facebook.com/tr?id=2238608086214969&ev=PageView&noscript=1"
        /></noscript>
        <!-- End Facebook Pixel Code -->
    @endif
</head>
<body>
    <div id="app">
        @include('partials.menu')
        @yield('content')
        @include('partials.footer')
    </div>

    <div class="modal disclaimer">
        <div class="modal-background"></div>
        <div class="modal-content">
            <div class="box">
                <h2 class="title is-3 is-size-5-mobile has-text-danger has-text-centered">
                    <span class="icon"><i class="fas fa-exclamation-triangle"></i></span> <span>Disclaimer!</span>
                </h2>
                <hr>
                <p>
                    Dealing directly with our riders is highly prohibited and against our company policy.
                </p>
                <p>
                    <span class="has-text-weight-bold">{{ config('app.name') }}</span> will not be held liable for loss of goods as a result of dealing directly with our riders. Call or WhatsApp <a href="tel:{{ config('app.contact_number') }}" class="has-text-weight-bold">{{ config('app.contact_number') }}</a> to request a pickup today.
                </p>
                <hr>
                <p class="has-text-centered">
                    <a href="javascript:;" class="close button is-danger">I understand</a>
                </p>
            </div>
        </div>
    </div>
    <!-- <script type="text/javascript" src="https://js.paystack.co/v1/inline.js"></script> -->

    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('app.google_maps_key') }}&libraries=places"></script>
    <script type="text/javascript" src="{{ asset('js/app.js') }}?v=1.4"></script>
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

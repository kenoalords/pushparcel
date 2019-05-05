@extends('layouts.app')

@section('content')

<div class="section is-medium">
    <div class="container is-740 has-text-centered">
        <h1 class="title is-2 is-size-4-mobile">Contact Us</h1>
        <p>Got questions about our services? Send us a mail <a href="mailto:{{ config('app.contact_email') }}"><strong>{{ config('app.contact_email') }}</strong></a> or call us on <a href="tel:{{ config('app.contact_number') }}"><strong>{{ config('app.contact_number') }}</strong></a></p>
        <hr>
        @include('partials.social-media')
    </div>
</div>

@endsection

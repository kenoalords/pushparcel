@extends('layouts.app')

@section('title', 'Service Areas')
@section('description', 'We are currently expanding our reach and bringing PushParcel dispatch rider service to a location near you')

@section('content')

<div class="section is-medium">
    <div class="container is-740">
        <h1 class="title is-2 is-size-4-mobile">Service Areas</h1>
        <p>We are currently expanding our reach and bringing PushParcel dispatch rider service to a location near you. Check out our current service areas below before making your request.</p>
        @include('partials.service-areas')
        <p class="has-text-grey">P.S. This list is constantly updated, if you don't find your location now, you can always check back or call us on <a href="tel:{{ config('app.contact_number') }}">{{ config('app.contact_number') }}</a> or send us a mail <a href="mailto:{{ config('app.contact_email') }}">{{ config('app.contact_email') }}</a></p>
        <hr>
        <a href="{{ route('request_pickup') }}" class="button is-highlight">Request pickup</a>
    </div>
</div>
<div class="section is-light">
    @include('partials.calculator')
</div>

@endsection

@extends('layouts.app')
@section('title', 'Request Pickup')
@section('description', 'Our dispatch riders are ready to pickup and deliver your packages within Lagos. Fill the form below to get started')
@section('content')

<div class="section is-medium">
    <div class="container is-740">
        <h2 class="title is-2 is-size-4-mobile">Request Pickup</h2>
        @if( env('CAN_MAKE_REQUEST') === true )
            <p>Please <a href="{{ route('service_areas') }}" class="has-text-weight-bold" target="_blank">check our service areas</a> to be sure we can pickup your parcel before making your request.</p>
            <hr>
            <parcel :user="null"></parcel>
            <noscript>
                <div class="notification is-danger">Please enable JavaScript on your browser in other to make a request. <a href="https://enable-javascript.com/" target="_blank">Click here to find out how to enable JavaScript</a></div>
            </noscript>
        @else
            <div class="box">
                <h4 class="title is-5 has-text-danger">Sorry, this service is currently unavailable.</h4>
                <p>To request a pickup and delivery, please call us now on <a href="tel:{{ config('app.contact_number') }}" class="has-text-weight-bold">{{ config('app.contact_number') }}</a> or send an email to <a href="mailto:{{ config('app.contact_email') }}" class="has-text-weight-bold">{{ config('app.contact_email') }}</a>,</p>
                <p>If you'd like to have an estimated cost for your intended delivery, <a href="{{ route('get_estimate') }}" class="has-text-weight-bold">click here to get an estimated cost for delivery.</a></p>
            </div>
        @endif
    </div>
</div>

@endsection

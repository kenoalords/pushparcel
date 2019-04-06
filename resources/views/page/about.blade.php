@extends('layouts.app')

@section('title', 'About Us')
@section('description', 'Our goal is to help your business grow by reaching more of your customers with our professional dispatch rider delivery service within Lagos')

@section('content')

<div class="section is-medium">
    <div class="container is-740">
        <h1 class="title is-2 is-size-5-mobile">About Us</h1>
        <div class="content">
            <p>Getting your goods to customers should be hassel-free, that's why at <a href="{{ config('app.url') }}">PushParcel</a>, we focus on quality of service delivery in a timely manner.</p>
            <p>Our goal is to help your business grow by reaching more of your customers with our professional dispatch rider delivery service within Lagos.</p>
            <p><a href="{{ config('app.url') }}">PushParcel</a> give you the convinience of delivering your parcels within Lagos on time.</p>
            <p>Our team of professional dispatch riders are trained to meet your delivery needs within the shortest possible time.</p>

            <p>
                <strong><a href="{{ route('contact') }}">Contact us</a> . <a href="{{ route('get_estimate') }}">Get an estimate</a></strong>
            </p>

        </div>
        <hr>
        @include('partials.social-media')
    </div>
</div>
<div class="section is-light">
    @include('partials.calculator')
</div>

@endsection

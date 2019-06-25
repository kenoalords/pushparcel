@extends('layouts.app')

@section('title', 'Home')
@section('description', 'PushParcel is a dispatch rider delivery service that gives you the convinience of delivering your parcels within Lagos on time.')

@section('content')

<section class="hero is-medium" id="hero">
    <div class="hero-body">
        <div class="container">
            <div class="columns">
                <div class="column is-8">
                    <h1 class="title is-1 is-size-3-mobile has-text-white">
                        Send parcels for as little as N400 within Lagos.
                    </h1>
                    <p class="has-text-white">
                        Save time and money with our professional dispatch delivery service. Focus on selling, let's focus on delivery.
                    </p>
                    <p>
                        <a href="{{ route('get_estimate') }}" class="button is-highlight">Get Estimate</a>
                        <span class="or">OR</span>
                        <a href="tel:{{ config('app.contact_number') }}" class="button is-white contact_number">
                            <img src="{{ asset('images/telephone.svg') }}" alt="Phone Icon">
                            Call us now
                        </a>
                        <!-- <a href="#" class="button is-primary">Get estimate</a> -->
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section is-medium">
    <div class="container">
        <div class="columns is-centered">
            <div class="column is-8 has-text-centered">
                <h3 class="title is-3 is-size-4-mobile">One less thing to worry about</h3>
                <p>Enjoy the convenience of having your parcels delivered on time and in perfect condition.</p>
            </div>
        </div>
        <div class="columns icon-steps">
            <div class="column is-4">
                <figure class="image">
                    <img src="{{ asset('images/moving.svg') }}" alt="Pick up">
                </figure>
                <h4 class="title is-5">Request Pickup</h4>
                <p>Request parcel pickup from the comfort of your home, shop or office.</p>
                <p>
                    <a href="{{ route('request_pickup') }}" class="button is-highlight">Request Pickup</a>
                </p>
            </div>
            <div class="column is-4">
                <figure class="image">
                    <img src="{{ asset('images/money.svg') }}" alt="Get estimate">
                </figure>
                <h4 class="title is-5">Get Estimate</h4>
                <p>Calculate your delivery cost and only pay for distance covered. That's it.</p>
                <p>
                    <a href="{{ route('get_estimate') }}" class="button is-highlight">Get Estimate</a>
                </p>
            </div>
            <div class="column is-4">
                <figure class="image is-larger">
                    <img src="{{ asset('images/motocross.svg') }}" alt="Super Fast Delivery">
                </figure>
                <h4 class="title is-5">Super Fast Delivery</h4>
                <p>Enjoy super fast same day and next day pickup and delivery.</p>
                <p>
                    <a href="{{ route('track_parcel') }}" class="button is-highlight">Track Parcel</a>
                </p>
            </div>
        </div>
    </div>
</section>

<section class="section is-medium is-dark is-payment">
    <div class="container">
        <div class="columns">
            <div class="column is-5">
                <figure class="image is-128x128" style="margin: 1em auto">
                    <img src="{{ asset('images/money-white.svg') }}" alt="Get estimate">
                </figure>
            </div>
            <div class="column is-7">
                <h3 class="title is-3 is-size-5-mobile">Enjoy convenient payment options</h3>
                <!-- <p>Want to pay for our dispatch service online or during pickup?</p> -->
                <p>Enjoy the freedom to choose which payment option works best for you. You can choose to pay online or pay when our dispatch rider picks up your package.</p>
                <p>Our online payment option is safe, secured and powered by <a href="https://paystack.com">PayStack</a></p>
                <p>
                    <a href="{{ route('request_pickup') }}" class="button is-highlight">Request Pickup</a>
                </p>
            </div>
        </div>
    </div>
</section>


@include('partials.calculator')

@endsection

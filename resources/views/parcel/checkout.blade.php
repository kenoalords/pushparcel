@extends('layouts.app')
@section('title', 'Checkout')
@section('content')

<div class="section is-medium">
    <div class="container">
        @if ($errors->any())
            <div class="notification is-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if( isset($notify) && $notify != '' )
            <div class="notification is-danger">{{ $notify }}</div>
        @endif
        <h2 class="title is-3">Checkout</h2>
        <p>Find below your delivery request details</p>
        <hr>
        <div class="columns parcel-details">
            <div class="column">
                <h4 class="title is-5">Sender details</h4>
                <p class="has-text-weight-bold">{{ $parcel->sender_name }}</p>
                <p>{{ $parcel->sender_address }}</p>
                <p>{{ $parcel->sender_phone }}</p>
                <p><a href="mailto:{{ $parcel->sender_email }}">{{ $parcel->sender_email }}</a></p>
            </div>
            <div class="column">
                <h4 class="title is-5">Receiver details</h4>
                <p class="has-text-weight-bold">{{ $parcel->receiver_name }}</p>
                <p>{{ $parcel->receiver_address }}</p>
                <p>{{ $parcel->receiver_phone }}</p>
                <p><a href="mailto:{{ $parcel->receiver_email }}">{{ $parcel->receiver_email }}</a></p>
            </div>
        </div>
        <div class="box">
            <div class="parcel-meta-details level is-mobile">
                <div class="level-item">
                    <div>
                        <span class="spaced-text">Price</span>
                        <h2 class="title is-4 has-text-danger">N{{ number_format(round($parcel->price)) }}</h2>
                    </div>
                </div>
                <div class="level-item">
                    <div>
                        <span class="spaced-text">Distance</span>
                        <h2 class="title is-4 has-text-danger">{{ $parcel->distance }}km</h2>
                    </div>
                </div>

                <div class="level-item">
                    <div>
                        <span class="spaced-text">Status</span>
                        <h2 class="title is-4 has-text-danger">{{ ucfirst($parcel->status) }}</h2>
                    </div>
                </div>
            </div>
        </div>
        <!-- <hr> -->
        <div class="has-text-centered">
            <h3 class="title is-4">How would you like to pay?</h3>
            <p>Select an option below and click <strong>Place Order</strong></p>
            <form class="checkout-form" action="{{ route('parcel_checkout', ['parcel'=>$parcel]) }}" method="post">
                @csrf
                <div class="field">
                    <label>
                        <input type="radio" name="payment_type" value="online"> Pay Online
                    </label>
                    <label>
                        <input type="radio" name="payment_type" value="pop"> Pay on Pickup
                    </label>
                </div>
                <div class="field">
                    <button type="submit" class="button is-highlight is-medium">Place order</button>
                </div>
            </form>
        </div>
        <br><br>
        <hr>
        <div class="has-text-centered">
            <h4 class="title is-6 is-size-6-mobile">Secured online payment powered by <a href="https://paystack.com" target="_blank"><strong>PayStack</strong></a></h4>
            <figure class="image" style="max-width: 256px; margin: 1em auto;">
                <a href="https://paystack.com" target="_blank">
                    <img src="/images/paystack.png" alt="PayStack">
                </a>
            </figure>
        </div>
    </div>
</div>
@endsection

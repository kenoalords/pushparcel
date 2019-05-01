@extends('layouts.app')
@section( 'title', 'Thank You' )
@section('content')

<div class="section is-medium">
    <div class="container is-740">
        <h1 class="title is-2 is-size-4-mobile">Pickup request successful</h1>
        <p>Your parcel pickup was requested successfully. Our dispatch rider will get to you within the next 24 hours. If you have any question or want to make changes, please call <a href="tel:{{ config('app.contact_number') }}" class="has-text-weight-bold">{{ config('app.contact_number') }}</a> or send us a mail <a href="mailto:{{ config('app.contact_email') }}" class="has-text-weight-bold">{{ config('app.contact_email') }}</a></p>
        <hr>
        <!-- <h4 class="title is-4 is-size-5-mobile">Details</h4> -->
        <div class="columns parcel-details">
            <div class="column is-6">
                <h4 class="title is-6">Sender</h4>
                <p>{{ $parcel->sender_name }}</p>
                <p>{{ $parcel->sender_address }}</p>
                <p>{{ $parcel->sender_phone }}</p>
                <p>{{ $parcel->sender_email }}</p>
            </div>
            <div class="column is-6">
                <h4 class="title is-6">Receiver</h4>
                <p>{{ $parcel->receiver_name }}</p>
                <p>{{ $parcel->receiver_address }}</p>
                <p>{{ $parcel->receiver_phone }}</p>
            </div>
        </div>
        <table class="table is-fullwidth is-bordered">
            <tr>
                <th>Item</th>
                <th>Weight</th>
                <th>Quantity</th>
            </tr>
            @foreach( $parcel->items->all() as $item )
            <tr>
                <td>{{ $item->description }}</td>
                <td>{{ $item->weight }}</td>
                <td>{{ $item->quantity }}</td>
            </tr>
            @endforeach
        </table>
        <div>
            <h4 class="title is-4 bold">Delivery Cost: <span class="has-text-danger">₦{{ number_format(floor($parcel->price)) }}</span></h4>
            @if( $parcel->payment_type === 'online' )
                <h4 class="title is-6">Payment Method: <span class="has-text-danger">Online Payment</span></h4>
                <h4 class="title is-6">Payment Status: <span class="has-text-danger">{{ $parcel->payment->status }}</span></h4>
            @elseif( $parcel->payment_type === 'pop' )
                <h4 class="title is-6">Payment Method: <span class="has-text-danger">Pay on Pickup</span></h4>
            @endif
        </div>
        <hr>
        <p><a href="{{ route('index') }}" class="button is-primary">Done</a> <a href="{{ route('request_pickup') }}" class="button is-highlight">Make another request</a></p>
    </div>
</div>

@endsection

@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="section is-medium">
    <div class="container">

        <div class="tabs is-toggle">
            <ul>
                <li><a href="#">Latest Requests</a></li>
                <li><a href="#">Pending Requests</a></li>
                <li><a href="#">Paid Requests</a></li>
            </ul>
        </div>
        <!-- <add-biker></add-biker> -->
        @if($parcels->count() > 0)
            <br>
            <div class="parcels">
                <div class="grid">
                    <div class="grid-header">
                        <!-- <div class="col is-05">#</div> -->
                        <div class="col is-1">Date</div>
                        <div class="col is-3">Sender</div>
                        <div class="col is-3">Receiver</div>
                        <div class="col is-1">Amount</div>
                        <div class="col is-1">Payment Type</div>
                        <div class="col is-1">Payment Status</div>
                    </div>
                    <div class="grid-content">
                        @foreach( $parcels as $parcel )

                            <div class="grid-list">
                                <!-- <div class="col is-05">{{ $loop->iteration }}</div> -->
                                <div class="col is-1">{{ $parcel->created_at->format('d M, y') }}</div>
                                <div class="col is-3">
                                    <h4 class="title is-6">
                                        <a href="{{ route('parcel_details', ['parcel'=>$parcel]) }}">{{ $parcel->sender_name }}</a>
                                    </h4>
                                    <span class="address">{{ $parcel->sender_address }}</span>
                                </div>
                                <div class="col is-3">
                                    <h4 class="title is-6">{{ $parcel->receiver_name }}</h4>
                                    <span class="address">{{ $parcel->receiver_address }}</span>
                                </div>
                                <div class="col is-1 has-text-weight-bold">N{{ number_format($parcel->price) }}</div>
                                <div class="col is-1">{{ ($parcel->payment_type == 'online') ? 'Online' : 'Pickup' }}</div>
                                <div class="col is-1">
                                    @if ( $parcel->is_paid )
                                        <span class="button is-small">
                                            <span class="icon"><i class="fas fa-check"></i></span>
                                            <span>Paid</span>
                                        </span>
                                    @else
                                        <paid id="{{ $parcel->uuid }}" name="{{ $parcel->id }}"></paid>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <hr>
            {{ $parcels->links() }}
        @else
            <div class="box is-raised">
                <h4 class="title has-text-danger is-5">You have no delivery request yet</h4>
            </div>
        @endif
    </div>
</div>
@endsection

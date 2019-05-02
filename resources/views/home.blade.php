@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="section is-medium">
    <div class="container">
        <div class="level is-mobile">
            <div class="level-left">
                <div class="level-item">
                    <h2 class="title is-5">Hello {{ auth()->user()->profile->fullname() }}</h2>
                </div>
            </div>
            <div class="level-left">
                <div class="level-item">
                    <a href="{{ route('parcel') }}" class="button is-action">Request new pickup</a>
                </div>
            </div>
        </div>
        <!-- <add-biker></add-biker> -->
        @if($parcels->count() > 0)
            <br>
            <div class="parcels">
                <div class="grid">
                    <div class="grid-header">
                        <div class="col is-05">#</div>
                        <div class="col is-1">Date</div>
                        <div class="col is-3">Sender</div>
                        <div class="col is-3">Receiver</div>
                        <div class="col is-2">Payment Type</div>
                        <div class="col is-1">Status</div>
                    </div>
                    <div class="grid-content">
                        @foreach( $parcels as $parcel )
                            <div class="grid-list">
                                <div class="col is-05">{{ $loop->iteration }}</div>
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
                                <div class="col is-2">{{ ($parcel->payment_type == 'online') ? 'Online' : 'Pickup' }}</div>
                                <div class="col is-1">{{ $parcel->status }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @else
            <div class="box is-raised">
                <h4 class="title has-text-danger is-5">You have no delivery request yet</h4>
            </div>
        @endif
    </div>
</div>
@endsection

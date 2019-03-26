@extends('layouts.dashboard')

@section('content')

<div class="section is-medium">
    <div class="container">
        <div class="level">
            <div class="level-left">
                <div class="level-item"><h2 class="title is-3">Parcel delivery details</h2></div>
            </div>
            <div class="level-right">
                <div class="level-item"><a href="{{ route('home') }}" class="has-text-weight-bold">Back</a></div>
            </div>
        </div>
        <hr>
        <div class="columns parcel-details">
            <div class="column">
                <h4 class="title is-5">Sender details</h4>
                <p class="has-text-weight-bold">{{ $parcel->sender_name }}</p>
                <p>{{ $parcel->senderAddress() }}</p>
                <p>{{ $parcel->sender_phone }}</p>
                <p><a href="mailto:{{ $parcel->sender_email }}">{{ $parcel->sender_email }}</a></p>
            </div>
            <div class="column">
                <h4 class="title is-5">Receiver details</h4>
                <p class="has-text-weight-bold">{{ $parcel->receiver_name }}</p>
                <p>{{ $parcel->receiverAddress() }}</p>
                <p>{{ $parcel->receiver_phone }}</p>
                <p><a href="mailto:{{ $parcel->receiver_email }}">{{ $parcel->receiver_email }}</a></p>
            </div>
        </div>
        <div class="box">
            <div class="parcel-meta-details level">
                <div class="level-left">
                    <div class="level-item">
                        <div>
                            <span class="spaced-text">Price</span>
                            <h2 class="title is-5 has-text-danger">N{{ number_format(round($parcel->price)) }}</h2>
                        </div>
                    </div>
                    <div class="level-item">
                        <div>
                            <span class="spaced-text">Distance</span>
                            <h2 class="title is-5 has-text-danger">{{ round($parcel->distance/1000) }}km</h2>
                        </div>
                    </div>
                    <div class="level-item">
                        <div>
                            <span class="spaced-text">Dispatcher</span>
                            <h2 class="title is-5 has-text-danger">{{ ($parcel->biker_id) ? $parcel->biker_id : 'Not assigned' }}</h2>
                        </div>
                    </div>
                    <div class="level-item">
                        <div>
                            <span class="spaced-text">Status</span>
                            <h2 class="title is-5 has-text-danger">{{ ucfirst($parcel->status) }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <p><a href="{{ route('home') }}" class="has-text-weight-bold">Back</a></p>
    </div>
</div>
@endsection

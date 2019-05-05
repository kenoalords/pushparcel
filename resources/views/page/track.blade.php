@extends('layouts.app')

@section('content')

<div class="section is-medium">
    <div class="container is-740 has-text-centered">
        <h1 class="title is-2 is-size-4-mobile">Track Parcel</h1>
        <p>This feature is coming soon. To know the current status on your parcel delivery request, please send a mail to <a href="mailto:{{ config('app.contact_email') }}"><strong>{{ config('app.contact_email') }}</strong></a> or call us on <a href="tel:{{ config('app.contact_number') }}"><strong>{{ config('app.contact_number') }}</strong></a></p>
    </div>
</div>

@endsection

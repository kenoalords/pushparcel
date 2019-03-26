@extends('layouts.dashboard')

@section('content')

<div class="section">
    <div class="container is-740">
        <h2 class="title is-3">New pickup &amp; delivery request</h2>
        <parcel user="{{ auth()->user() }}"></parcel>
    </div>
</div>

@endsection

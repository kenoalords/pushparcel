@extends('layouts.app')
@section('title', 'Request Pickup')
@section('description', 'Our dispatch riders are ready to pickup and deliver your packages within Lagos. Fill the form below to get started')
@section('content')

<div class="section is-medium">
    <div class="container is-740">
        <h2 class="title is-2 is-size-4-mobile">New pickup &amp; delivery request</h2>
        <parcel :user="null"></parcel>
    </div>
</div>

@endsection

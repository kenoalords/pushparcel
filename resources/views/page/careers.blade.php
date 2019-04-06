@extends('layouts.app')

@section('title', 'Careers')
@section('description', 'Looking for career opportunities in our company?')

@section('content')

<div class="section is-medium">
    <div class="container is-740 has-text-centered">
        <h1 class="title is-2 is-size-5-mobile">Careers</h1>
        <p>Looking for career opportunities in our company? Send your CV to <a href="mailto:{{ config('app.contact_email') }}">{{ config('app.contact_email') }}</a></p>
    </div>
</div>

@endsection

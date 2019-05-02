@extends('layouts.app')

@section('title', 'Careers')
@section('description', 'Looking for career opportunities in our company?')

@section('content')

<div class="section is-medium">
    <div class="container is-740">
        <h1 class="title is-2 is-size-5-mobile">Careers</h1>
        <p>Looking for career opportunities with PushParcel? Send your CV to <a href="mailto:{{ config('app.contact_email') }}">{{ config('app.contact_email') }}</a></p>

        @if($careers->count() > 0 )
            <hr>
            <span class="title is-6 tag is-danger">Current Opening(s)</span>
            @foreach( $careers as $career )
                <div class="career">
                    <h3 class="title is-5">
                        <a href="{{ route( 'view_career', ['career'=>$career] ) }}">{{ $career->title }}</a>
                    </h3>
                    <p>{{ $career->metadescription }}</p>
                    <p class="expires has-text-danger has-text-weight-bold"><span class="icon"><i class="fas fa-calendar"></i></span> Application closes {{ $career->expires->diffForHumans() }}</p>
                    <a href="{{ route( 'view_career', ['career'=>$career] ) }}" class="button is-info is-small">View opening</a>
                </div>
            @endforeach
        @else
            <div class="notification is-danger">Sorry! we don't have any opening at the moment. Please check back later.</div>
        @endif
    </div>
</div>

@endsection

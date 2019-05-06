@extends('layouts.app')

@section('title', 'Get Estimate')
@section('description', 'Want to send a parcel within Lagos? Use our online calculator to get an estimated now.')

@section('content')

<div class="section">
    @include('partials.calculator')
</div>

@endsection

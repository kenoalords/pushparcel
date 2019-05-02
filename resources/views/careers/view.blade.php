@extends('layouts.app')

@section('title', $career->title)
@section('description', $career->metadescription)

@section('content')

<div class="section is-medium">
    <div class="container is-740">
        <a href="{{ route('careers') }}" class="tag is-info">Careers</a>
        <hr>
        <h1 class="title is-2 is-size-4-mobile">{{ $career->title }}</h1>
        @if ( $career->status === 'publish' )
            @if ($career->expires)
                <p class="has-text-danger has-text-weight-bold">Application closes {{ $career->expires->diffForHumans() }}</p>
            @endif
            <div class="content">
                {{ $career->description }}
                <hr style="visibility: hidden">
                <h4 class="title is-5">How to apply?</h4>
                <p>Send your cv to <strong>{{ config('app.contact_email') }}</strong> with the job title <strong>*{{ $career->title }}*</strong> as the subject.</p>
                <p class="has-text-danger">Only shortlisted candidates will be contacted</p>
                <hr>
                <p>
                    <a href="{{ route('careers') }}" class="button is-white">
                        <span class="icon"><i class="fas fa-arrow-left"></i></span>
                        <span>Back to careers</span>
                    </a>
                </p>
            </div>
        @else
            <div class="content">
                This job is no longer active, please check back later.
            </div>
        @endif
    </div>
</div>

@endsection

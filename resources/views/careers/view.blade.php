@extends('layouts.app')

@section('title', $career->title)
@section('description', $career->metadescription)

@section('content')

<div class="section is-medium">
    <div class="container is-740">
        <div class="level is-mobile">
            <div class="level-left">
                <div class="level-item">
                    <a href="{{ route('careers') }}" class="tag is-info">Careers</a>
                </div>
            </div>
            <div class="level-right">
                <div class="level-item">
                    <a href="{{ route('careers') }}" class="button is-white">
                        <span class="icon"><i class="fas fa-arrow-left"></i></span>
                        <span>Back to careers</span>
                    </a>
                </div>
            </div>
        </div>
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
                <div class="social-shares">
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ Request::url() }}" class="button is-primary">
                        <span class="icon"><i class="fab fa-facebook-f"></i></span>
                        <span>Share to Facebook</span>
                    </a>
                    <a href="https://twitter.com/intent/tweet?url={{ Request::url() }}&via=pushparcel&text={{ $career->metadescription }}&hashtags=%23jobsinlagos=" class="button is-info">
                        <span class="icon"><i class="fab fa-twitter"></i></span>
                        <span>Tweet this job</span>
                    </a>
                </div>
            </div>

        @else
            <div class="content">
                This job is no longer active, please check back later.
            </div>
        @endif
    </div>
</div>

@endsection

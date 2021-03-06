@extends('layouts.account')

@section('content')
<div class="box is-raised">
    <div class="title is-5">{{ __('Verify Your Email Address') }}</div>

    <div class="card-body">
        @if (session('resent'))
            <div class="notification is-success" role="alert">
                {{ __('A fresh verification link has been sent to your email address.') }}
            </div>
        @endif

        {{ __('Before proceeding, please check your email for a verification link.') }}
        {{ __('If you did not receive the email') }}, <a href="{{ route('verification.resend') }}">{{ __('click here to request another') }}</a>.
    </div>
</div>
@endsection

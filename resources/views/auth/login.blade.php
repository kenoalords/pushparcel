@extends('layouts.account')

@section('content')

<div class="box is-raised">
    <div class="title is-5">{{ __('Login') }}</div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="field">
            <input id="email" type="email" class="input {{ $errors->has('email') ? ' is-danger' : '' }}" name="email" value="{{ old('email') }}" required autofocus placeholder="Email address">

            @if ($errors->has('email'))
                <span class="help is-danger" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>

        <div class="field">
            <input id="password" type="password" class="input {{ $errors->has('password') ? ' is-danger' : '' }}" name="password" required placeholder="Password">

            @if ($errors->has('password'))
                <span class="help is-danger" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>

        <div class="field">
            <label class="form-check-label" for="remember">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('Remember Me') }}
            </label>
        </div>

        <div class="field">
            <button type="submit" class="button is-primary is-fullwidth">
                {{ __('Login') }}
            </button>
        </div>
        @if (Route::has('password.request'))
            <a class="btn btn-link" href="{{ route('password.request') }}">
                {{ __('Forgot Your Password?') }}
            </a>
        @endif
        <hr>
        <div class="field">
            @if (Route::has('register'))
                <p>Don't have an account? <a href="{{ route('register') }}">
                    {{ __('Click here to sign up') }}
                </a></p>
            @endif
        </div>
    </form>
</div>

@endsection

@extends('layouts.account')

@section('content')
<div class="box is-raised">
    <div class="title is-5">{{ __('Register') }}</div>

    <div class="">
        <form method="POST" action="{{ route('register') }}">
            @csrf



            <div class="field">
                <input id="first_name" type="text" class="input{{ $errors->has('first_name') ? ' is-invalid' : '' }}" name="first_name" value="{{ old('first_name') }}" required placeholder="{{ __('First name') }}">

                @if ($errors->has('first_name'))
                    <span class="help is-danger" role="alert">
                        <strong>{{ $errors->first('first_name') }}</strong>
                    </span>
                @endif
            </div>

            <div class="field">
                <input id="last_name" type="text" class="input{{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" value="{{ old('last_name') }}" required placeholder="{{ __('Last name') }}">

                @if ($errors->has('last_name'))
                    <span class="help is-danger" role="alert">
                        <strong>{{ $errors->first('last_name') }}</strong>
                    </span>
                @endif
            </div>

            <div class="field">
                <input id="phone_number" type="text" class="input{{ $errors->has('phone_number') ? ' is-invalid' : '' }}" name="phone_number" value="{{ old('phone_number') }}" required placeholder="{{ __('Phone number') }}">

                @if ($errors->has('phone_number'))
                    <span class="help is-danger" role="alert">
                        <strong>{{ $errors->first('phone_number') }}</strong>
                    </span>
                @endif
            </div>

            <hr>

            <div class="field">
                <input id="email" type="email" class="input{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required placeholder="{{ __('E-Mail Address') }}">

                @if ($errors->has('email'))
                    <span class="help is-danger" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>

            <div class="field">
                <input id="password" type="password" class="input{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required placeholder="{{ __('Password') }}">

                @if ($errors->has('password'))
                    <span class="help is-danger" role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>

            <div class="field">
                <input id="password-confirm" type="password" class="input" name="password_confirmation" required placeholder="{{ __('Confirm Password') }}">
            </div>

            <div class="field mb-0">
                <button type="submit" class="button is-primary is-fullwidth">
                    {{ __('Register') }}
                </button>
            </div>
            <hr>
            <div class="field">
                @if (Route::has('register'))
                    <p>Already have an account? <a href="{{ route('register') }}">
                        {{ __('Click here to login') }}
                    </a></p>
                @endif
            </div>
        </form>
    </div>
</div>

@endsection

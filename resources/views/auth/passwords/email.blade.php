@extends('layouts.app')
@section('title', 'Reset Password')
@section('content')
<div>
    <div class="section is-medium">
        <div class="container">
            <div class="columns">


                <div class="column is-6 is-offset-3">
                    <div class="title is-4">{{ __('Reset Password') }}</div>
                    @if (session('status'))
                        <div class="notification is-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="field">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="input {{ $errors->has('email') ? ' is-danger' : '' }}" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <hr>
                        <div class="field">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="button is-primary">
                                    {{ __('Send Password Reset Link') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

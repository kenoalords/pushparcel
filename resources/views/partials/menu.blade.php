<div class="navbar is-transparent" id="navbar">
    <div class="container">
        <div class="navbar-brand">
            <a href="{{ url('/') }}">
                <img src="{{ asset('svg/logo-full-blue.svg') }}" alt="{{ config('app.name') }}">
            </a>
            <a class="navbar-burger" href="#" data-target="navBarMenu">
                <span></span>
                <span></span>
                <span></span>
            </a>
        </div>
        <div class="navbar-menu" id="navBarMenu">
            <div class="navbar-end">
                @if(Auth::user())
                <div class="navbar-item has-dropdown is-hoverable">
                    <a href="{{ route('home') }}" class="navbar-link">Dashboard</a>
                    <div class="navbar-dropdown">
                        @if( auth()->user()->is_admin === 1 )
                            <a href="{{ route('bikes') }}" class="navbar-item">Bikes</a>
                            <a href="{{ route('bikers') }}" class="navbar-item">Riders</a>
                        @endif
                        <hr class="navbar-divider">
                        <a href="{{ route('logout') }}" class="navbar-item">Logout</a>
                    </div>
                </div>

                @else
                <a href="{{ url('/') }}" class="navbar-item {{ (Request::path() === '/') ? 'is-active' : '' }}">Home</a>
                <a href="{{ route('about') }}" class="navbar-item {{ (Request::path() === 'about-us') ? 'is-active' : '' }}">About</a>
                <a href="{{ route('get_estimate') }}" class="navbar-item bold {{ (Request::path() === 'get-estimate') ? 'is-active' : '' }}">Get Estimate</a>
                <a href="{{ route('contact') }}" class="navbar-item bold {{ (Request::path() === 'contact-us') ? 'is-active' : '' }}">Contact Us</a>

                @endif
                <div class="navbar-item">
                    <a href="{{ route('request_pickup') }}" class="button is-highlight">Request pickup</a>
                </div>
            </div>
        </div>
    </div>
</div>

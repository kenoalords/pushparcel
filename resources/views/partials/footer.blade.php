<footer class="footer" id="site-footer">
    <div class="container">
        <div class="columns">
            <div class="column is-3">
                <figure class="image">
                    <img src="{{ asset('/svg/logo-icon.svg') }}" alt="{{ config('app.name') }}" class="footer-logo">
                </figure>
                <h4 class="title is-6">Ikeja . Lagos</h4>
                <p>Tel: <a href="tel:{{ config('app.contact_number') }}">{{ config('app.contact_number') }}</a></p>
                <p>Email: <a href="mailto:{{ config('app.contact_email') }}">{{ config('app.contact_email') }}</a></p>
            </div>
            <div class="column is-3">
                <h4 class="title is-5">Us</h4>
                <ul class="menu">
                    <li><a href="{{ route('about') }}">About Us</a></li>
                    <li><a href="{{ route('careers') }}">Careers</a></li>
                    <li><a href="{{ route('privacy') }}">Privacy</a></li>
                    <li><a href="#">Terms of Use</a></li>
                </ul>
            </div>
            <div class="column is-3">
                <h4 class="title is-5">Help</h4>
                <ul class="menu">
                    <li><a href="{{ route('get_estimate') }}">Get Estimate</a></li>
                    <li><a href="{{ route('request_pickup') }}">Request Pickup</a></li>
                    <li><a href="{{ route('track_parcel') }}">Track Parcel</a></li>
                    <li><a href="{{ route('service_areas') }}">Service Areas</a></li>
                    <li><a href="{{ route('contact') }}">Contact Us</a></li>
                    <!-- <li><a href="{{ route('login') }}">Login</a></li> -->
                </ul>
            </div>
            <div class="column is-3">
                <h4 class="title is-5">Connect</h4>
                <ul class="menu">
                    <li><a href="{{ config('app.social.facebook') }}">Facebook</a></li>
                    <li><a href="{{ config('app.social.twitter') }}">Twitter</a></li>
                    <li><a href="{{ config('app.social.instagram') }}">Instagram</a></li>
                </ul>
            </div>
        </div>
        <div id="credits">
            <div class="level">
                <div class="level-left">
                    <div class="level-item">
                        <div class="credits">{{ config('app.name') }} - All Rights Reserved 2019</div>
                    </div>
                </div>
                <div class="level-right">
                    <div class="level-item">
                        <div class="credits">Designed and maintained by <a href="https://clickmedia.com.ng" target="_blank">Clickmedia</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

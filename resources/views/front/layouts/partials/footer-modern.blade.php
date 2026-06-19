@php
$isPreview = request()->is('preview*');
$footerKey = $isPreview ? 'preview.footer' : 'front.footer';
$t = function (string $suffix) use ($footerKey) {
$primaryKey = $footerKey . '.' . $suffix;
$primary = __($primaryKey);
if ($primary === $primaryKey) {
$fallbackKey = 'front.footer.' . $suffix;
$fallback = __($fallbackKey);
return $fallback === $fallbackKey ? $primary : $fallback;
}
return $primary;
};
@endphp
<footer class="footer-area footer-modern">
    <div class="container">

        <div class="footer-main footer-split crease-safe dual-pane stats-two-col">
            <div class="footer-left" data-sal="slide-right" data-sal-duration="800" data-sal-delay="100">
                <div class="footer-newsletter">
                    <h2 class="title">{{ $t('get_in_touch') }}</h2>
                    <p>{{ $t('get_in_touch_desc') }}</p>
                    <form method="POST" action="{{ route('subscribe') }}">
                        @csrf
                        <div class="input-group">
                            <input type="email" class="form-control" name="mail" placeholder="{{ $t('subscribe_placeholder') }}" required>
                            <button class="subscribe-btn" type="submit">{{ $t('subscribe_button') }}</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="footer-divider" aria-hidden="true"></div>
            <div class="footer-right" data-sal="slide-left" data-sal-duration="800" data-sal-delay="100">
                <div class="footer-columns">
                    <div class="footer-widget">
                        <h6 class="widget-title">{{ __('services') }}</h6>
                        <div class="footer-menu-link">
                            <ul class="list-unstyled">
                                @if(isset($main_services))
                                @foreach ($main_services as $service)
                                @php
                                $serviceAnchor = \Illuminate\Support\Str::slug($service->name, '-') . '-' . $service->id;
                                @endphp
                                <li>
                                    <a href="{{ route($isPreview ? 'preview.services' : 'services') }}#{{ $serviceAnchor }}">{{ $service?->name }}</a>
                                </li>
                                @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                    <div class="footer-widget">
                        <h6 class="widget-title">{{ $t('resources') }}</h6>
                        <div class="footer-menu-link">
                            <ul class="list-unstyled">
                                <li><a href="{{ route($isPreview ? 'preview.blogs' : 'blogs') }}">{{ __('blog') }}</a></li>
                                <li><a href="{{ route($isPreview ? 'preview.portfolio' : 'portfolio') }}">{{ __('portfolio') }}</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="footer-widget">
                        <h6 class="widget-title">{{ $t('support') }}</h6>
                        <div class="footer-menu-link">
                            <ul class="list-unstyled">
                                <li><a href="{{ route($isPreview ? 'preview.contact' : 'contact') }}">{{ __('contact') }}</a></li>
                                <li><a href="privacy-policy.html">{{ $t('privacy') }}</a></li>
                                <li><a href="terms-of-use.html">{{ $t('terms') }}</a></li>
                                <li><a href="{{ route($isPreview ? 'preview.cookie-policy' : 'cookie-policy') }}">{{ $t('cookie_policy') }}</a></li>
                                <li><a href="#" data-cookie-settings>{{ $t('cookie_settings') }}</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom" data-sal="slide-up" data-sal-duration="500" data-sal-delay="100">
            <div class="footer-social-link" style="margin-bottom: 20px; text-align: center;">
                <ul class="list-unstyled" style="justify-content: center;">
                    @if(isset($socialmedia))
                    @foreach ($socialmedia as $media)
                    <li>
                        <a href="{{ $media->link }}" target="_blank" rel="noopener" data-sal="slide-up" data-sal-duration="500"
                            data-sal-delay="100">
                            <i class="{{ $media->icon }}"></i>
                        </a>
                    </li>
                    @endforeach
                    @endif
                </ul>
            </div>
            <div class="footer-copyright">
                <div class="live-status">
                    <span class="live-dot" aria-hidden="true"></span>
                    <span>{{ $t('live_status') }}</span>
                </div>
                <span class="copyright-text">&copy; <?= date('Y') ?>. {{ $t('all_rights_reserved') }}.</span>
            </div>
        </div>
    </div>
</footer>
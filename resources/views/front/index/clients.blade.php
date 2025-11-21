<section class="section section-padding bg-color-dark">
    <div class="container">
        <div class="section-heading heading-light-left">
            <span class="subtitle">{{ __('front.clients.subtitle') }}</span>
            <h2 class="title">{{ __('front.clients.title') }}</h2>
            <p>{{ __('front.clients.description') }}</p>
        </div>
        <div class="row">
            @foreach ($companies ?? [] as $company)
                <div class="col-lg-3 col-6" data-sal="slide-up" data-sal-duration="500">
                    <div class="brand-grid active">
                        @php
                            $logo = $company?->image;
                            $logoUrl = null;
                            if ($logo) {
                                if (\Illuminate\Support\Str::startsWith($logo, ['http://', 'https://'])) {
                                    $logoUrl = $logo;
                                } elseif (\Illuminate\Support\Facades\Storage::disk('public')->exists($logo)) {
                                    $logoUrl = \Illuminate\Support\Facades\Storage::url($logo);
                                } elseif (file_exists(public_path($logo))) {
                                    $logoUrl = asset($logo);
                                }
                            }
                            $logoUrl = $logoUrl ?? asset('assets/media/brand/brand-1.png');
                        @endphp
                        <img src="{{ $logoUrl }}" alt="{{ $company?->name ?? '' }}">
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <ul class="shape-group-2 list-unstyled">
        <li class="shape shape-1"><img src="{{ asset('assets/media/others/circle-1.png') }}" alt="circle"></li>
        <li class="shape shape-2"><img src="{{ asset('assets/media/others/line-3.png') }}" alt="circle"></li>
        <li class="shape shape-3"><img src="{{ asset('assets/media/others/bubble-3.png') }}" alt="circle"></li>
    </ul>
</section>

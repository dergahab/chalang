<section class="section section-padding-equal bg-color-dark">
    <div class="container">
<section class="section section-padding-equal bg-color-dark">
    <div class="container">
        <div class="section-heading heading-light-left">
            <span class="subtitle">{{ __('front.services.subtitle') }}</span>
            <h2 class="title">{{ __('front.services.title') }}</h2>
            <p class="opacity-50">{{ __('front.services.description') }}</p>
        </div>
        <div class="row">
            @foreach ($main_services ?? [] as $service)
                <div class="col-lg-4 col-md-6 sal-animate" data-sal="slide-up" data-sal-duration="800"
                    data-sal-delay="{{ $loop->iteration * 100 }}">
                    <div class="services-grid">
                        <div class="thumbnail">
                            {{-- <img src="assets/media/icon/icon-1.png" alt="icon"> --}}
                            @php
                                $iconPath = $service?->icon;
                                $iconUrl = null;

                                if ($iconPath) {
                                    if (\Illuminate\Support\Str::startsWith($iconPath, ['http://', 'https://'])) {
                                        $iconUrl = $iconPath;
                                    } elseif (\Illuminate\Support\Facades\Storage::disk('public')->exists($iconPath)) {
                                        $iconUrl = \Illuminate\Support\Facades\Storage::url($iconPath);
                                    } elseif (file_exists(public_path($iconPath))) {
                                        $iconUrl = asset($iconPath);
                                    }
                                }

                                $iconUrl = $iconUrl ?? asset('assets/media/icon/icon-1.png');
                            @endphp
                            <img src="{{ $iconUrl }}" alt="icon">
                        </div>
                        <div class="content">
                            <h5 class="title"> <a
                                    href="{{ route('services') }}#{{ $service?->name ?? '' }}">{{ $service?->name ?? '' }}</a></h5>
                            <p>{{ $service?->description ?? '' }}</p>
                            {{-- <a href="service-design.html" class="more-btn">Find out more</a> --}}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <ul class="list-unstyled shape-group-10">
        <li class="shape shape-1"><img src="{{ asset('assets/media/others/circle-1.png') }}" alt="Circle"></li>
        <li class="shape shape-2"><img src="{{ asset('assets/media/others/line-3.png') }}" alt="Circle"></li>
        <li class="shape shape-3"><img src="{{ asset('assets/media/others/bubble-5.png') }}" alt="Circle"></li>
    </ul>
</section>

@extends('front.layouts.main_new')
@section('content')
    @php
        $serviceRouteName = request()->is('preview*') ? 'preview.service.single' : 'service.single';
    @endphp
    <!-- Service Hero -->
    <style>
    <!-- Service Hero -->
    <style>
        [data-sal] {
            opacity: 1 !important;
            transform: none !important;
            visibility: visible !important;
        }
    </style>
    @php
        // Define route for breadcrumb
        $homeRoute = request()->is('preview*') ? route('preview') : route('/');
    @endphp

    @include('front.layouts.partials.breadcrumb', [
        'title' => __('front.services.title'),
        'items' => [
            __('front.services.title') => ''
        ]
    ])

    <!-- Custom Style override for this page if needed, but breadcrumb partial handles banner -->


    <!-- Sticky Sub-navigation -->
    <div class="sticky-subnav-container">
        <nav class="subnav-inner">
            @foreach ($items as $item)
                @php $sectionId = \Illuminate\Support\Str::slug($item->name, '-') . '-' . $item->id; @endphp
                <a class="subnav-link" href="#{{ $sectionId }}">{{ $item->name }}</a>
            @endforeach
        </nav>
    </div>

    <!-- Service Sections -->
    <div class="scroll-nav-wrapper">
        @foreach ($items as $item)
            @php $sectionId = \Illuminate\Support\Str::slug($item->name, '-') . '-' . $item->id; @endphp
            <div id="{{ $sectionId }}" class="service-section">
                <div class="container">
                    <p class="section-subtitle" data-sal="slide-up">{{ __('front.services.subtitle') }}</p>
                    <h2 class="service-section-title" data-sal="slide-up">{{ $item->name }}</h2>
                    <div class="grid services-grid-2" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(420px, 1fr)); gap: 30px;">
                        @foreach ($item->childs as $child)
                            <div class="service-card glass-card" data-sal="slide-up" data-sal-duration="800" data-sal-delay="100">
                                @php
                                    $iconPath = $child->icon;
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
                                    $serviceSummary = $child->description ?: $child->content;
                                @endphp
                                <div class="thumbnail" style="margin-bottom: 20px;">
                                    <img src="{{ $iconUrl }}" alt="icon" style="width: 60px; height: 60px; object-fit: contain;">
                                </div>
                                <div class="content">
                                    <h5 class="title" style="font-family: var(--font-heading); color: var(--color-text-main); margin-bottom: 12px; font-size: 1.25rem;"> 
                                        <a href="{{ route($serviceRouteName, $child->slug) }}" style="color: inherit; text-decoration: none;">{{ $child->name }}</a>
                                    </h5>
                                    <p style="color: var(--color-text-main); line-height: 1.7; margin-bottom: 20px; opacity: 0.8;">{{ $serviceSummary }}</p>
                                    <a href="{{ route($serviceRouteName, $child->slug) }}" class="more-btn" style="color: var(--brand-primary); font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 5px;">
                                        {{ __('front.services.find_out_more') }} <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @if(isset($testimonials) && $testimonials->count() > 0)
    <section class="section">
        <div class="container">
            <h2 class="section-title" data-sal="slide-up">Bizi Seçənlər Nə Deyir?</h2>
            <p class="section-subtitle" data-sal="slide-up" data-sal-delay="100">Müştəri Rəyləri</p>
            
            <div class="grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px;">
                @foreach($testimonials as $testimonial)
                    <div class="glass-card" style="padding: 30px;" data-sal="slide-up" data-sal-delay="100">
                        <div class="rating" style="color: var(--brand-primary); font-size: 1.2rem; margin-bottom: 15px;">
                            @for($i = 0; $i < $testimonial->rating; $i++) ★ @endfor
                        </div>
                        <p style="color: var(--color-text-main); line-height: 1.7; margin-bottom: 20px; font-style: italic;">"{{ $testimonial->content }}"</p>
                        <div class="testimonial-author" style="display: flex; align-items: center; gap: 15px;">
                            @if($testimonial->image)
                                <img src="{{ asset('storage/' . $testimonial->image) }}" alt="{{ $testimonial->name }}" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
                            @endif
                            <div>
                                <strong style="color: var(--color-text-main); font-family: var(--font-heading); display: block;">{{ $testimonial->name }}</strong>
                                <small style="color: var(--color-text-sub);">{{ $testimonial->position }}</small>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    @if(isset($pricingPlans) && $pricingPlans->count() > 0)
    <section class="section">
        <div class="container">
            <h2 class="section-title" data-sal="slide-up">Sizə Uyğun Paketi Seçin</h2>
            <p class="section-subtitle" data-sal="slide-up" data-sal-delay="100">Qiymət Planları</p>
            
            <div class="pricing-toggle" style="display: flex; justify-content: center; align-items: center; gap: 15px; margin-bottom: 50px;">
                <span style="font-weight: 600;">Aylıq</span>
                <label class="switch" style="position: relative; display: inline-block; width: 60px; height: 34px;">
                    <input type="checkbox" id="pricing-switch" style="opacity: 0; width: 0; height: 0;">
                    <span class="slider round" style="position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #ccc; transition: .4s; border-radius: 34px;"></span>
                    <span class="slider-knob" style="position: absolute; content: ''; height: 26px; width: 26px; left: 4px; bottom: 4px; background-color: white; transition: .4s; border-radius: 50%;"></span>
                </label>
                <span style="font-weight: 600;">İllik <span class="badge" style="background: var(--brand-secondary); color: white; padding: 2px 8px; border-radius: 10px; font-size: 0.7rem; margin-left: 5px;">-20%</span></span>
            </div>

            <style>
                .switch input:checked + .slider { background-color: var(--brand-primary); }
                .switch input:checked + .slider .slider-knob { transform: translateX(26px); }
            </style>

            <div class="grid">
                @foreach($pricingPlans as $plan)
                    <div class="glass-card {{ $plan->is_popular ? 'popular' : '' }}" style="padding: 40px; position: relative; {{ $plan->is_popular ? 'border: 2px solid var(--brand-primary);' : '' }}">
                        @if($plan->is_popular)
                            <div class="popular-badge" style="position: absolute; top: -15px; left: 50%; transform: translateX(-50%); background: var(--brand-primary); color: white; padding: 5px 20px; border-radius: 20px; font-size: 0.85rem; font-weight: 600;">Populyar</div>
                        @endif
                        <h3 style="font-family: var(--font-heading); color: var(--color-text-main); margin-bottom: 15px; text-align: center;">{{ $plan->name }}</h3>
                        <div class="price" style="margin-bottom: 25px; text-align: center;">
                            <span class="currency" style="font-size: 1.5rem; color: var(--brand-primary); vertical-align: top;">$</span>
                            <span class="amount-monthly" style="font-size: 3rem; font-weight: 800; color: var(--color-text-main);">{{ $plan->price_monthly }}</span>
                            <span class="amount-yearly" style="display:none; font-size: 3rem; font-weight: 800; color: var(--color-text-main);">{{ $plan->price_yearly }}</span>
                            <span class="period" style="color: var(--color-text-sub); font-weight: 600;">/ay</span>
                        </div>
                        <p class="description" style="color: var(--color-text-main); line-height: 1.6; margin-bottom: 30px; text-align: center; opacity: 0.8;">{{ $plan->description }}</p>
                        <ul class="features-list" style="list-style: none; padding: 0; margin-bottom: 30px;">
                            @if($plan->features)
                                @foreach($plan->features as $feature)
                                    <li style="color: var(--color-text-main); padding: 10px 0; border-bottom: 1px solid rgba(0,0,0,0.05); display: flex; align-items: center; gap: 10px;">
                                        <span class="check-icon" style="color: var(--brand-primary); background: rgba(var(--brand-primary-rgb), 0.1); width: 20px; height: 20px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.7rem;">✔</span> {{ $feature }}
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                        <a href="{{ $plan->cta_link ?? route('contact') }}" class="btn-primary" style="width:100%; text-align: center; justify-content: center;">{{ $plan->cta_text ?? 'Seçin' }}</a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

@endsection

@push('js_script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleSwitch = document.getElementById('pricing-switch');
        const monthlyPrices = document.querySelectorAll('.amount-monthly');
        const yearlyPrices = document.querySelectorAll('.amount-yearly');
        const periods = document.querySelectorAll('.period');

        if(toggleSwitch) {
            toggleSwitch.addEventListener('change', function() {
                if(this.checked) {
                    monthlyPrices.forEach(el => el.style.display = 'none');
                    yearlyPrices.forEach(el => el.style.display = 'inline');
                    periods.forEach(el => el.textContent = '/il');
                } else {
                    monthlyPrices.forEach(el => el.style.display = 'inline');
                    yearlyPrices.forEach(el => el.style.display = 'none');
                    periods.forEach(el => el.textContent = '/ay');
                }
            });
        }
    });
</script>
@endpush

@extends('front.layouts.main_new')

@section('title', 'Chalang - Digital Agency')

@section('content')

@php
$isPreview = request()->is('preview*');
@endphp

<section class="hero">

    <div class="hero-content">
        <div style="margin-bottom: 15px; font-weight: 700; color: var(--brand-secondary); text-transform: uppercase; letter-spacing: 1px;">AI-Driven Creative Partner</div>
        <h1 data-sal="slide-up" data-sal-duration="800">Qlobal İnnovasiya <br> Və Süni Zəka</h1>
        @php $heroDesc = __('front.banner.text'); @endphp
        <p data-sal="slide-up" data-sal-duration="800" data-sal-delay="100">{{ $heroDesc !== 'front.banner.text' ? $heroDesc : 'Biznesinizi gələcəyə daşımaq üçün strategiya, dizayn və texnologiyanı birləşdiririk.' }}</p>
        <div class="btn-group" data-sal="slide-up" data-sal-duration="800" data-sal-delay="200">
            <a href="{{ route($isPreview ? 'preview.contact' : 'contact') }}" class="btn-primary">Layihəyə başla</a>
            <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ" class="btn-secondary popup-video" style="display: inline-flex; align-items: center; gap: 10px;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M8 5v14l11-7z" />
                </svg> Showreel
            </a>
        </div>
    </div>
    <div class="hero-visual">
        <canvas id="hero-canvas"></canvas>
    </div>
</section>

<!-- About / Join the Force Section -->
<section class="section">
    <div class="container">
        <div class="grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 50px; align-items: center;">
            <div data-sal="slide-right">
                <h2 class="section-title" style="text-align: left;">Biz Kimik?</h2>
                <p style="margin-bottom: 20px;">Chalang — rəqəmsal dünyada iz qoymaq istəyən brendlər üçün yaradılmış innovativ agentlikdir.</p>
                <p>Biz sadəcə kod yazmırıq, biz bizneslərin gələcəyini kodlaşdırırıq.</p>
            </div>
            <div class="glass-card" style="padding: 40px; text-align: center; border: 1px solid var(--brand-secondary);" data-sal="slide-left">
                <h3 style="color: var(--brand-primary);">Join the Force 🚀</h3>
                <p>Sərhədləri aşmağa hazırsan? Komandamıza qoşul.</p>
                <a href="{{ route($isPreview ? 'preview.contact' : 'contact') }}" class="btn-primary" style="margin-top: 20px;">CV Göndər</a>
            </div>
        </div>
    </div>
</section>

@if(isset($partners) && $partners->count() > 0)
<div class="section">
    <div class="partner-slider" data-sal="slide-up">
        @foreach($partners as $partner)
        <div class="partner-slide-item">
            <a href="{{ $partner->link ?? '#' }}" target="_blank" rel="noopener noreferrer">
                <img src="{{ asset('storage/' . $partner->logo) }}" alt="{{ $partner->name }}" class="partner-logo" title="{{ $partner->name }}">
            </a>
        </div>
        @endforeach
    </div>
</div>
@endif

<div class="infinite-text-container">
    <div class="infinite-text">
        <h2>INTELLIGENCE. WOVEN. • WEAVING COMPLEXITY INTO CLARITY • </h2>
        <h2>INTELLIGENCE. WOVEN. • WEAVING COMPLEXITY INTO CLARITY • </h2>
    </div>
</div>

@php
$serviceRouteName = request()->is('preview*') ? 'preview.service.single' : 'service.single';
@endphp

<!-- Services Section -->
<section class="section">
    <h2 class="section-title" data-sal="slide-up">Biz nə edirik?</h2>
    <p class="section-subtitle" data-sal="slide-up" data-sal-delay="100">Mürəkkəb problemlər üçün innovativ həllər</p>
    <div class="grid services-grid-2" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(420px, 1fr)); gap: 30px;">
        @foreach ($main_services ?? [] as $service)
        <div class="card service-card" data-tilt data-sal="slide-up" data-sal-delay="{{ $loop->iteration * 100 }}">
            <div class="card-icon accent">
                <img src="{{ $service->icon ? asset('storage/' . $service->icon) : asset('assets/media/icon/icon-1.png') }}" alt="{{ $service->name }}">
            </div>
            <div class="service-head">
                <h3>{{ $service->name }}</h3>
            </div>
            <p>{{ \Illuminate\Support\Str::limit($service->description, 110) }}</p>
            <a href="{{ route($serviceRouteName, $service->slug) }}" class="card-link">Ətraflı <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 4 10.59 5.41 16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z" />
                </svg></a>
        </div>
        @endforeach
    </div>
</section>

<!-- Statistics Section (Counter Up) -->
<section class="section">
    <div class="grid counter-grid">
        <div class="card counter-card" data-sal="slide-up" data-sal-delay="100">
            <h3 class="count-number"><span class="counter">10</span>+</h3>
            <p>İllik Təcrübə</p>
        </div>
        <div class="card counter-card" data-sal="slide-up" data-sal-delay="200">
            <h3 class="count-number"><span class="counter">{{ $portfolios->count() ?? 50 }}</span>+</h3>
            <p>Uğurlu Layihə</p>
        </div>
        <div class="card counter-card" data-sal="slide-up" data-sal-delay="300">
            <h3 class="count-number"><span class="counter">100</span>%</h3>
            <p>Müştəri Məmnuniyyəti</p>
        </div>
        <div class="card counter-card" data-sal="slide-up" data-sal-delay="400">
            <h3 class="count-number"><span class="counter">5</span>+</h3>
            <p>Beynəlxalq Mükafat</p>
        </div>
    </div>
</section>

<!-- Portfolio Section with Isotope Hooks -->
<section class="section">
    <h2 class="section-title" data-sal="slide-up">Seçilmiş işlər</h2>
    <p class="section-subtitle" data-sal="slide-up" data-sal-delay="100">Uğur hekayələrimiz</p>

    <div class="grid axil-isotope-wrapper">
        <!-- Isotope Filters -->
        <div class="isotope-button mb--50 text-center" data-sal="slide-up" data-sal-delay="200">
            <button data-filter="*" class="is-checked filter-btn"><span>Hamsı</span></button>
            @foreach ($portfolio_categories ?? [] as $cat)
            <button data-filter=".{{ Str::slug($cat->name, '') }}" class="filter-btn"><span>{{ $cat->name }}</span></button>
            @endforeach
        </div>

        <div class="row isotope-list">
            @foreach ($portfolios ?? [] as $portfolio)
            @php
            $classes = "col-xl-4 col-sm-6 project";
            foreach($portfolio->pcategories as $cat) {
            $classes .= " " . Str::slug($cat->name, '');
            }
            @endphp
            <div class="{{ $classes }}" data-sal="slide-up" data-sal-delay="{{ $loop->iteration * 100 }}">
                <article class="card portfolio-card mx-2 my-2" data-tilt>
                    <div class="portfolio-img">
                        <a href="{{ asset('storage/' . $portfolio->image) }}" class="popup-zoom">
                            <img src="{{ asset('storage/' . $portfolio->image) }}" alt="{{ $portfolio->title }}" loading="lazy" style="width:100%;height:220px;object-fit:cover;">
                        </a>
                    </div>
                    <div class="portfolio-content">
                        <span class="tag">{{ $portfolio->pcategories->first()->name ?? 'Project' }}</span>
                        <h3>{{ $portfolio->title }}</h3>
                        <p>{{ \Illuminate\Support\Str::limit($portfolio->short_description ?? $portfolio->title, 120) }}</p>
                    </div>
                </article>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Pricing Section -->
@if(isset($pricing_plans) && $pricing_plans->count() > 0)
<section class="section">
    <h2 class="section-title" data-sal="slide-up">Qiymət Planları</h2>
    <p class="section-subtitle" data-sal="slide-up" data-sal-delay="100">Sizə uyğun paketi seçin</p>
    <div class="grid">
        @foreach($pricing_plans as $plan)
        <div class="pricing-card {{ $plan->is_popular ? 'popular' : '' }}" data-sal="slide-up" data-sal-delay="{{ $loop->iteration * 100 }}">
            @if($plan->is_popular)
            <div class="popular-badge">Populyar</div>
            @endif
            <h3>{{ $plan->name }}</h3>
            <div class="price">
                <span class="currency">$</span>
                <span class="amount-monthly">{{ $plan->price_monthly }}</span>
                <span class="period">/ay</span>
            </div>
            <ul class="features-list">
                @if($plan->features)
                @foreach($plan->features as $feature)
                <li><span class="check-icon">✔</span> {{ $feature }}</li>
                @endforeach
                @endif
            </ul>
            <a href="{{ $plan->cta_link ?? route($isPreview ? 'preview.contact' : 'contact') }}" class="btn-primary" style="width:100%">{{ $plan->cta_text ?? 'Seçin' }}</a>
        </div>
        @endforeach
    </div>
</section>
@endif

<!-- Team Section -->
@if(isset($team_members) && $team_members->count() > 0)
<section class="section">
    <h2 class="section-title" data-sal="slide-up">Komandamız</h2>
    <p class="section-subtitle" data-sal="slide-up" data-sal-delay="100">Yaradıcı beyinlər</p>
    <div class="grid">
        @foreach($team_members as $member)
        <div class="team-card" data-sal="slide-up" data-sal-delay="{{ $loop->iteration * 100 }}">
            @if($member->image)
            <img src="{{ asset('storage/' . $member->image) }}" alt="{{ $member->name }}" class="team-img">
            @endif
            <div class="team-info">
                <h3>{{ $member->name }}</h3>
                <p style="color:var(--brand-primary); font-weight:600">{{ $member->position }}</p>
            </div>
        </div>
        @endforeach
    </div>
</section>
@endif

<!-- FAQ Section -->
@if(isset($faqs) && $faqs->count() > 0)
<section class="section">
    <h2 class="section-title" data-sal="slide-up">Tez-tez verilən suallar</h2>
    <p class="section-subtitle" data-sal="slide-up" data-sal-delay="100">Bizi daha yaxından tanıyın</p>

    <div class="faq-container" style="max-width: 800px; margin: 0 auto;">
        @foreach($faqs as $faq)
        <div class="faq-item card" data-sal="slide-up" data-sal-delay="{{ $loop->iteration * 80 }}">
            <div class="faq-question">
                <h3>{{ $faq->title }}</h3>
                <span class="faq-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M6 9l6 6 6-6" />
                    </svg></span>
            </div>
            <div class="faq-answer">
                <div class="faq-answer-inner">
                    {!! $faq->description !!}
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>
@endif

@endsection

@push('js_script')
<script>
    // Parallax logic for hero visual if needed, or other JS initialization
</script>
@endpush
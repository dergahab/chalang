@extends('front.layouts.main')
@section('content')
    @include('front.index.banner')
    @include('front.index.services')
    @include('front.index.about')

    <section class="section section-padding-equal counterup-area bg-color-dark">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6" data-sal="slide-up" data-sal-duration="800" data-sal-delay="100">
                    <div class="single-counterup">
                        <h2 class="count-number">
                            <span class="number count">5</span>
                            <span class="symbol">+</span>
                        </h2>
                        <span class="counter-title">İllik Təcrübə</span>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6" data-sal="slide-up" data-sal-duration="800" data-sal-delay="200">
                    <div class="single-counterup">
                        <h2 class="count-number">
                            <span class="number count">150</span>
                            <span class="symbol">+</span>
                        </h2>
                        <span class="counter-title">Məmnun Müştəri</span>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6" data-sal="slide-up" data-sal-duration="800" data-sal-delay="300">
                    <div class="single-counterup">
                        <h2 class="count-number">
                            <span class="number count">300</span>
                            <span class="symbol">+</span>
                        </h2>
                        <span class="counter-title">Uğurlu Layihə</span>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6" data-sal="slide-up" data-sal-duration="800" data-sal-delay="400">
                    <div class="single-counterup">
                        <h2 class="count-number">
                            <span class="number count">25</span>
                            <span class="symbol">+</span>
                        </h2>
                        <span class="counter-title">Mütəxəssis Komanda</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section section-padding-2 bg-reb">
        <div class="container">
            <div class="section-heading heading-left mb--40">
                <span class="subtitle">{{ __('front.portfolio.portfolio_description') }}</span>
                <h2 class="title">{{ __('front.portfolio.our_projects') }}</h2>
            </div>
            @include('front.inc.portfolio')
        </div>
        <ul class="shape-group-7 list-unstyled">
            <li class="shape shape-1"><img src="{{ asset('assets/media/others/circle-2.png') }}" alt="circle"></li>
            <li class="shape shape-2"><img src="{{ asset('assets/media/others/bubble-2.png') }}" alt="Line"></li>
            <li class="shape shape-3"><img src="{{ asset('assets/media/others/bubble-1.png') }}" alt="Line"></li>
        </ul>
    </section>

    @if(isset($case_studies) && $case_studies->count() > 0)
    <section class="section section-padding bg-color-light">
        <div class="container">
            <div class="section-heading heading-left">
                <span class="subtitle">Case Studies</span>
                <h2 class="title">Uğur Hekayələrimiz</h2>
            </div>
            <div class="row">
                @foreach($case_studies as $caseStudy)
                    <div class="col-lg-4 col-md-6" data-sal="slide-up" data-sal-duration="800" data-sal-delay="{{ $loop->iteration * 100 }}">
                        <div class="project-grid">
                            <div class="thumbnail">
                                <a href="{{ route('case-study.show', $caseStudy->slug) }}">
                                    <img src="{{ asset('storage/' . $caseStudy->cover_image) }}" alt="{{ $caseStudy->title }}">
                                </a>
                            </div>
                            <div class="content">
                                <h4 class="title"><a href="{{ route('case-study.show', $caseStudy->slug) }}">{{ $caseStudy->title }}</a></h4>
                                <span class="subtitle">{{ $caseStudy->category }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    @if(isset($pricing_plans) && $pricing_plans->count() > 0)
    <section class="section section-padding">
        <div class="container">
            <div class="section-heading heading-left mb--90">
                <span class="subtitle">Qiymət Planları</span>
                <h2 class="title">Sizə Uyğun Paketi Seçin</h2>
            </div>
            <div class="grid">
                @foreach($pricing_plans as $plan)
                    <div class="pricing-card {{ $plan->is_popular ? 'popular' : '' }}" data-sal="slide-up" data-sal-duration="800" data-sal-delay="{{ $loop->iteration * 100 }}">
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
                        <a href="{{ $plan->cta_link ?? route('contact') }}" class="btn-primary" style="width:100%">{{ $plan->cta_text ?? 'Seçin' }}</a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    @if(isset($team_members) && $team_members->count() > 0)
    <section class="section section-padding bg-color-light">
        <div class="container">
            <div class="section-heading heading-left mb--90">
                <span class="subtitle">Komandamız</span>
                <h2 class="title">Yaradıcı Beyinlər</h2>
            </div>
            <div class="row">
                @foreach($team_members as $member)
                    <div class="col-lg-4 col-md-6" data-sal="slide-up" data-sal-duration="800" data-sal-delay="{{ $loop->iteration * 100 }}">
                        <div class="team-card">
                            @if($member->image)
                                <img src="{{ asset('storage/' . $member->image) }}" alt="{{ $member->name }}" class="team-img">
                            @endif
                            <div class="team-info">
                                <h3>{{ $member->name }}</h3>
                                <p style="color:var(--brand-primary); font-weight:600">{{ $member->position }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    @if(isset($testimonials) && $testimonials->count() > 0)
    <section class="section section-padding">
        <div class="container">
            <div class="section-heading heading-left mb--90">
                <span class="subtitle">Müştəri Rəyləri</span>
                <h2 class="title">Bizi Seçənlər Nə Deyir?</h2>
            </div>
            <div class="testimonial-grid">
                @foreach($testimonials as $testimonial)
                    <div class="testimonial-card" data-sal="slide-up" data-sal-duration="800" data-sal-delay="{{ $loop->iteration * 100 }}">
                        <div class="rating">
                            @for($i = 0; $i < $testimonial->rating; $i++) ★ @endfor
                        </div>
                        <p>"{{ $testimonial->content }}"</p>
                        <div class="testimonial-author">
                            @if($testimonial->image)
                                <img src="{{ asset('storage/' . $testimonial->image) }}" alt="{{ $testimonial->name }}" class="testimonial-avatar">
                            @endif
                            <div>
                                <strong>{{ $testimonial->name }}</strong><br>
                                <small>{{ $testimonial->position }}</small>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    @if(isset($partners) && $partners->count() > 0)
    <section class="section section-padding bg-color-light">
        <div class="container">
            <div class="section-heading heading-left mb--90">
                <span class="subtitle">Tərəfdaşlar</span>
                <h2 class="title">Bizə Güvənənlər</h2>
            </div>
            <div class="partner-grid">
                @foreach($partners as $partner)
                    <a href="{{ $partner->link ?? '#' }}" target="_blank" rel="noopener noreferrer">
                        <img src="{{ asset('storage/' . $partner->logo) }}" alt="{{ $partner->name }}" class="partner-logo" title="{{ $partner->name }}">
                    </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    @include('front.index.clients')
    @include('front.index.posts')
    @include('front.inc.worck_togather')
@endsection

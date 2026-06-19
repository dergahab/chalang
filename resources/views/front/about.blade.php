@extends('front.layouts.main')
@section('content')
        <!--=====================================-->
        <!--=       Breadcrumb Area Start       =-->
        <!--=====================================-->
        <div class="breadcrum-area breadcrumb-banner">
            <div class="container">
                <div class="section-heading heading-left" data-sal="slide-right" data-sal-duration="1000" data-sal-delay="300">
                    <h1 class="title h2">{{ __('front.banner.title') }}</h1>
                    <p>{{ __('front.banner.description') }}</p>
                </div>
                <div class="banner-thumbnail thumbnail-4" data-sal="slide-up" data-sal-duration="1000" data-sal-delay="400">
                    <img src="assets/media/banner/banner-thumb-3.png" alt="Illustration">
                </div>
            </div>
            <ul class="shape-group-8 list-unstyled">
                <li class="shape shape-1" data-sal="slide-right" data-sal-duration="500" data-sal-delay="100">
                    <img src="assets/media/others/bubble-9.png" alt="Bubble">
                </li>
                <li class="shape shape-2" data-sal="slide-left" data-sal-duration="500" data-sal-delay="200">
                    <img src="assets/media/others/bubble-22.png" alt="Bubble">
                </li>
                <li class="shape shape-3" data-sal="slide-up" data-sal-duration="500" data-sal-delay="300">
                    <img src="assets/media/others/line-4.png" alt="Line">
                </li>
            </ul>
        </div>
        <!--=====================================-->
        <!--=       About  Area Start        =-->
        <!--=====================================-->
        <section class="section section-padding case-study-featured-area">
            <div class="container">
                <div class="row">
                    <div class="col-xl-7 col-lg-6">
                        <div class="case-study-featured-thumb text-start">
                            <img src="{{ $item?->image ? asset('storage/' . $item->image) : '' }}" alt="travel">
                        </div>
                    </div>
                    <div class="col-xl-5 col-lg-6">
                        <div class="case-study-featured">
                            <div class="section-heading heading-left">
                                <span class="subtitle">{{ __('who_we_are') }}</span>
                                <h2 class="title">{{ $item?->title ?? '' }}</h2>
                                {!! $item?->description ?? '' !!}
                                <a href="{{ route('contact') }}" class="axil-btn btn-fill-primary btn-large">{{ __('front.contact.title') }}</a>
                            </div>
                            <div class="case-study-counterup">
                                <div class="single-counterup">
                                    <h2 class="count-number">
                                        <span class="number count">5</span>
                                        <span class="symbol">+</span>
                                    </h2>
                                    <span class="counter-title">{{ __('front.about.years_on_market') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section section-padding bg-color-light pb--70">
            <div class="container">
                <div class="section-heading mb--90">
                    <span class="subtitle">{{ __('front.about.process') }}</span>
                    <h2 class="title">{{ __('front.about.logo_design_process') }}</h2>
                    <p>{{ __('design_strategy') }}</p>
                </div>
                @foreach ($steps ?? [] as $step)
                    <div class="process-work sal-animate @if($loop->iteration % 2 != 0) content-reverse @endif" @if($loop->iteration % 2 != 0) data-sal="slide-right"@else data-sal="slide-left" @endif data-sal-duration="1000" data-sal-delay="100">
                        <div class="thumbnail paralax-image" style="will-change: transform; transform: perspective(1000px) rotateX(0deg) rotateY(0deg);">
                            <img src="{{ $step?->image ? asset('storage/' . $step->image) : '' }}" alt="Thumbnail">
                        </div>
                        <div class="content">
                            <span class="subtitle">{{ $step?->step ?? '' }}</span>
                            <h3 class="title">{{ $step?->title ?? '' }}</h3>
                            {!! $step?->description ?? '' !!}
                        </div>
                    </div>
                @endforeach
            </div>
            <ul class="shape-group-17 list-unstyled">
                <li class="shape shape-1"><img src="{{ asset('assets/media/others/bubble-24.png') }}" alt="Bubble"></li>
                <li class="shape shape-2"><img src="{{ asset('assets/media/others/bubble-23.png') }}" alt="Bubble"></li>
                <li class="shape shape-3"><img src="{{ asset('assets/media/others/line-4.png') }}" alt="Line"></li>
                <li class="shape shape-4"><img src="{{ asset('assets/media/others/line-5.png') }}" alt="Line"></li>
                <li class="shape shape-5"><img src="{{ asset('assets/media/others/line-4.png') }}" alt="Line"></li>
                <li class="shape shape-6"><img src="{{ asset('assets/media/others/line-5.png') }}" alt="Line"></li>
            </ul>
        </section>
        <div class="section section-padding-equal bg-color-light">
            <div class="container">
                <div class="about-expert">
                    <div class="thumbnail">
                        <img src="assets/media/about/about-1.png" alt="Thumbnail">
                        <div class="popup-video">
                            <a href="../../../watch.html?v=1iIZeIy7TqM" class="play-btn popup-youtube"><i class="fas fa-play"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <ul class="shape-group-16 list-unstyled">
                <li class="shape shape-1"><img src="assets/media/others/circle-2.png" alt="circle"></li>
                <li class="shape shape-2"><img src="assets/media/others/bubble-2.png" alt="Line"></li>
                <li class="shape shape-3"><img src="assets/media/others/bubble-1.png" alt="Line"></li>
            </ul>
        </div>

        @if(isset($teamMembers) && $teamMembers->count() > 0)
        <section class="section section-padding bg-color-light">
            <div class="container">
                <div class="section-heading mb--90">
                    <span class="subtitle">Komandamız</span>
                    <h2 class="title">Yaradıcı Beyinlər</h2>
                    <p>Bizim peşəkar komandamızla tanış olun.</p>
                </div>
                <div class="row">
                    @foreach($teamMembers as $member)
                        <div class="col-lg-4 col-md-6" data-sal="slide-up" data-sal-duration="800" data-sal-delay="100">
                            <div class="team-card">
                                @if($member->image)
                                    <img src="{{ asset('storage/' . $member->image) }}" alt="{{ $member->name }}" class="team-img">
                                @endif
                                <div class="team-info">
                                    <h3>{{ $member->name }}</h3>
                                    <p style="color:var(--brand-primary); font-weight:600">{{ $member->position }}</p>
                                    <p>{{ $member->bio }}</p>
                                    @if($member->social_links)
                                        <div class="social-links">
                                            @foreach($member->social_links as $platform => $link)
                                                <a href="{{ $link }}" class="social-link" target="_blank">
                                                    <i class="fab fa-{{ strtolower($platform) }}"></i>
                                                </a>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        <section class="section section-padding bg-color-light">
            <div class="container">
                <div class="section-heading heading-left">
                    <span class="subtitle">Join the Force</span>
                    <h2 class="title">Komandaya qosul</h2>
                    <p>Biz her zaman istedad axtaririq. CV gonder, tanis olaq.</p>
                    <a href="{{ route('contact') }}" class="axil-btn btn-fill-primary">CV gonder</a>
                </div>
            </div>
        </section>

        @if(isset($partners) && $partners->count() > 0)
        <section class="section section-padding">
            <div class="container">
                <div class="section-heading mb--90">
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
        <!--=====================================-->
        <!--=        Footer Area Start       	=-->
        <!--=====================================-->
@endsection

@extends('front.layouts.main_new')

@section('content')

    <!-- HERO SECTION -->
    <section class="page-banner">
        <div class="container">
            <div class="banner-content text-center">
                <h1 class="page-title">{{ __('front.banner.title') }}</h1>
                <p class="page-desc">{{ __('front.banner.description') }}</p>
            </div>
        </div>
        <div class="banner-visual">
            <div class="circle-shape shape-1"></div>
            <div class="circle-shape shape-2"></div>
        </div>
    </section>

    <!-- MAIN CONTENT (CONTAINER CONSTRAINT) -->
    <div class="container section-gap">
        
        <!-- INTRO / WHO WE ARE -->
        <div class="row align-items-center mb-5">
            <div class="col-lg-6">
                <div class="glass-card p-4" data-tilt>
                    <img src="{{ $item?->image ? asset('storage/' . $item->image) : asset('assets/media/about/about-1.png') }}" class="img-fluid rounded-3" alt="About Us">
                </div>
            </div>
            <div class="col-lg-6 mt-4 mt-lg-0">
                <div class="content-box ps-lg-4">
                    <span class="sub-title text-primary">{{ __('who_we_are') }}</span>
                    <h2 class="section-heading">{{ $item?->title ?? 'Biz Kimik?' }}</h2>
                    <div class="description text-muted">
                        {!! $item?->description ?? '<p>Chalang, brendlərin rəqəmsal dünyada parlamasına kömək edən yaradıcı agentlikdir.</p>' !!}
                    </div>
                    
                    <div class="stats-grid mt-4">
                        <div class="stat-item glass-card p-3 text-center">
                            <h3 class="stat-number count">5+</h3>
                            <p class="stat-label">{{ __('front.about.years_on_market') }}</p>
                        </div>
                        <div class="stat-item glass-card p-3 text-center">
                            <h3 class="stat-number count">50+</h3>
                            <p class="stat-label">Uğurlu Layihə</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- PROCESS STEPS -->
        <div class="process-section mt-5">
            <div class="text-center mb-5">
                <span class="sub-title text-primary">{{ __('front.about.process') }}</span>
                <h2 class="section-heading">{{ __('front.about.logo_design_process') }}</h2>
            </div>
            
            <div class="row">
                @foreach ($steps ?? [] as $step)
                    <div class="col-md-6 col-lg-3 mb-4">
                        <div class="process-card glass-card p-4 h-100 text-center" data-tilt>
                            <div class="step-num">{{ $loop->iteration }}</div>
                            <div class="step-icon mb-3">
                                <img src="{{ $step?->image ? asset('storage/' . $step->image) : asset('assets/media/icon/icon-1.png') }}" alt="Icon" width="60">
                            </div>
                            <h4 class="step-title">{{ $step?->title }}</h4>
                            <p class="step-desc text-muted small">{!! \Illuminate\Support\Str::limit(strip_tags($step?->description), 100) !!}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- TEAM SECTION -->
        @if(isset($teamMembers) && $teamMembers->count() > 0)
        <div class="team-section mt-5 pt-5">
            <div class="text-center mb-5">
                <span class="sub-title text-primary">Komandamız</span>
                <h2 class="section-heading">Yaradıcı Beyinlər</h2>
            </div>
            
            <div class="row">
                @foreach($teamMembers as $member)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="team-card glass-card p-0 overflow-hidden" data-tilt>
                            <div class="team-img-wrapper position-relative">
                                <img src="{{ $member->image ? asset('storage/' . $member->image) : asset('assets/media/team/team-1.png') }}" class="w-100" alt="{{ $member->name }}">
                                <div class="team-social-overlay">
                                    @if($member->social_links)
                                        @foreach($member->social_links as $platform => $link)
                                            <a href="{{ $link }}" target="_blank" class="social-icon"><i class="fab fa-{{ strtolower($platform) }}"></i></a>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                            <div class="team-info p-4 text-center">
                                <h4 class="team-name mb-1">{{ $member->name }}</h4>
                                <span class="team-role text-primary small">{{ $member->position }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- JOIN THE FORCE CTA -->
        <div class="join-force-section mt-5">
            <div class="join-force-card glass-card p-4" style="display: flex; align-items: center; justify-content: space-between; gap: 20px; flex-wrap: wrap;">
                <div>
                    <span class="sub-title text-primary">Join the Force</span>
                    <h3 class="section-heading h4">Komandaya qosul</h3>
                    <p class="text-muted mb-0">Biz her zaman istedad axtaririq. CV gonder, tanis olaq.</p>
                </div>
                <a href="{{ route(request()->is('preview*') ? 'preview.contact' : 'contact') }}" class="btn-primary" style="padding: 14px 28px; border-radius: 14px; background: var(--brand-primary, #4b0082); color: #fff; text-decoration: none; font-weight: 700; box-shadow: 0 10px 20px rgba(75,0,130,0.25); white-space: nowrap;">CV gonder</a>
            </div>
        </div>

        <!-- PARTNERS -->
        @if(isset($partners) && $partners->count() > 0)
        <div class="partners-section mt-5 pt-5 border-top border-light-subtle">
             <div class="text-center mb-4">
                <h4 class="section-heading h5 opacity-50">Bizə Güvənənlər</h4>
            </div>
            <div class="partner-carousel slick-initialized" id="partner-slider">
                 @foreach($partners as $partner)
                    <div class="partner-item px-3 text-center">
                        <img src="{{ asset('storage/' . $partner->logo) }}" alt="{{ $partner->name }}" class="img-fluid opacity-50 hover-opacity-100 transition" style="max-height: 50px; filter: grayscale(100%);">
                    </div>
                 @endforeach
            </div>
        </div>
        @endif

    </div>

    @push('styles')
    <style>
        /* Local Glassmorphism Overrides */
        .page-banner { padding: 120px 0 60px; position: relative; overflow: hidden; }
        .banner-visual .circle-shape { position: absolute; border-radius: 50%; filter: blur(80px); opacity: 0.4; z-index: -1; }
        .shape-1 { top: -10%; left: -10%; width: 400px; height: 400px; background: var(--brand-primary); }
        .shape-2 { bottom: 10%; right: -5%; width: 300px; height: 300px; background: var(--brand-secondary); }
        
        .glass-card { background: rgba(255, 255, 255, 0.05); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 20px; transition: transform 0.3s; }
        .glass-card:hover { transform: translateY(-5px); border-color: var(--brand-primary); }
        
        .section-gap { padding-top: 60px; padding-bottom: 60px; }
        .sub-title { font-weight: 600; letter-spacing: 1px; text-transform: uppercase; font-size: 0.85rem; display: block; margin-bottom: 10px; }
        .section-heading { font-weight: 700; margin-bottom: 20px; }
        
        .step-num { width: 40px; height: 40px; background: var(--brand-gradient); color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; margin: 0 auto 20px; }
        
        .team-social-overlay { position: absolute; bottom: -50px; left: 0; width: 100%; padding: 10px; background: rgba(0,0,0,0.6); display: flex; justify-content: center; gap: 15px; transition: bottom 0.3s; }
        .team-card:hover .team-social-overlay { bottom: 0; }
        .social-icon { color: #fff; font-size: 1.1rem; }
        
        /* Slick override */
        .partner-item img { transition: all 0.3s; }
        .partner-item img:hover { filter: grayscale(0%); opacity: 1 !important; }
    </style>
    @endpush

    @push('scripts')
    <script>
        $(document).ready(function(){
            // Init Tilt
            if($('[data-tilt]').length){
                VanillaTilt.init(document.querySelectorAll("[data-tilt]"), { max: 15, speed: 400, glare: true, "max-glare": 0.2 });
            }
            
            // Init Partner Slider
            /*
            $('#partner-slider').slick({
                slidesToShow: 5, slidesToScroll: 1, autoplay: true, autoplaySpeed: 2000, arrows: false, dots: false,
                responsive: [ { breakpoint: 992, settings: { slidesToShow: 3 } }, { breakpoint: 576, settings: { slidesToShow: 2 } } ]
            });
            */
           // Counter
           $('.count').counterUp({ delay: 10, time: 1000 });
        });
    </script>
    @endpush
@endsection

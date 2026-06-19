@extends('front.layouts.main_new')
@section('content')
    @php
        $isPreview = request()->is('preview*');
        $servicesRoute = $isPreview ? route('preview.services') : route('services');
    @endphp

    @push('schema_json')
        {!! App\Helpers\SchemaHelper::service($item) !!}
        {!! App\Helpers\SchemaHelper::breadcrumb([
            __('front.services.subtitle') => $servicesRoute,
            $item->name => ''
        ]) !!}
        @if($item->faqs->count() > 0)
            {!! App\Helpers\SchemaHelper::faq($item->faqs) !!}
        @endif
    @endpush

    @include('front.layouts.partials.breadcrumb', [
        'title' => $item->name,
        'items' => [
            __('front.services.subtitle') => $servicesRoute,
            $item->name => ''
        ]
    ])

<div class="breadcrum-area breadcrumb-banner service-detail-hero" style="display: none;">
    <div class="container">
        <div class="service-hero-grid">
            <div class="service-hero-content">
                <ul class="breadcrumb-list breadcrumb-style-1 mb--20 service-breadcrumb">
                    <li><a href="{{ request()->is('preview*') ? route('preview') : route('/') }}">{{ __('front.home') }}</a></li>
                    <li class="separator">/</li>
                    <li><a href="{{ $servicesRoute }}">{{ __('front.services.subtitle') }}</a></li>
                    <li class="separator">/</li>
                    <li class="active">{{ $item->name }}</li>
                </ul>
                <h1 class="title h2 service-hero-title">{{ $item->name }}</h1>
                <p class="service-hero-desc">{{ $item->description }}</p>
                <div class="service-hero-actions">
                    <a href="#quote-form" class="btn-primary-custom">{{ __('front.contact.get_quote') }}</a>
                    @if($item->cta_link && $item->cta_text)
                        <a href="{{ $item->cta_link }}" class="btn-secondary-custom">{{ $item->cta_text }}</a>
                    @endif
                </div>
            </div>
            <div class="service-hero-media">
                <div class="banner-thumbnail sal-animate" data-sal="slide-up" data-sal-duration="1000" data-sal-delay="400">
                    <img class="paralax-image" src="{{ asset(Storage::url($item->image)) }}" alt="Illustration" style="will-change: transform; transform: perspective(1000px) rotateX(0deg) rotateY(0deg);">
                </div>
            </div>
        </div>
    </div>
    <ul class="shape-group-8 list-unstyled">
        <li class="shape shape-1 sal-animate" data-sal="slide-right" data-sal-duration="500" data-sal-delay="100">
            <img src="{{asset('assets/media/others/bubble-9.png')}}" alt="Bubble">
        </li>
        <li class="shape shape-2 sal-animate" data-sal="slide-left" data-sal-duration="500" data-sal-delay="200">
            <img src="{{asset('assets/media/others/bubble-21.png')}}" alt="Bubble">
        </li>
        <li class="shape shape-3 sal-animate" data-sal="slide-up" data-sal-duration="500" data-sal-delay="300">
            <img src="{{asset('assets/media/others/line-4.png')}}" alt="Line">
        </li>
    </ul>
</div>
<section class="section-padding single-portfolio-area service-detail-section">
    <div class="container">
        <div class="row align-items-start service-detail-grid">
            <div class="col-lg-7">
                <div class="why-choose-us">
                    <div class="section-heading heading-left">
                        <h3 class="title">{{ $content?->title }}</h3>
                        <div class="description-content">
                            {!! $content?->content !!}
                        </div>
                        
                        <div class="accordion mt--40 service-accordion" id="choose-accordion">
                            <div class="accordion-item glass-card mb-3" style="background: var(--card-bg); border-radius: 16px; border: 1px solid var(--card-border);">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" style="background: transparent; color: var(--color-text-main); font-weight: 500;">
                                        <i class="far fa-compress" style="color: var(--brand-primary); margin-right: 10px;"></i> Strategiya
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#choose-accordion">
                                    <div class="accordion-body" style="color: var(--color-text-sub);">
                                        Biz hər bir layihəyə dərin bazar araşdırması və rəqib analizi ilə başlayırıq. Sizin hədəflərinizə uyğun unikal strategiya hazırlayırıq.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item glass-card mb-3" style="background: var(--card-bg); border-radius: 16px; border: 1px solid var(--card-border);">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" style="background: transparent; color: var(--color-text-main); font-weight: 500;">
                                        <i class="far fa-code" style="color: var(--brand-primary); margin-right: 10px;"></i> Dizayn və Həll
                                    </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#choose-accordion">
                                    <div class="accordion-body" style="color: var(--color-text-sub);">
                                        Vizual kimliyinizi qoruyaraq, müasir və istifadəçi dostu (UI/UX) dizaynlar yaradırıq. Brendinizin hekayəsini vizual olaraq danışırıq.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item glass-card" style="background: var(--card-bg); border-radius: 16px; border: 1px solid var(--card-border);">
                                <h2 class="accordion-header" id="headingThree">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree" style="background: transparent; color: var(--color-text-main); font-weight: 500;">
                                        <i class="fal fa-globe" style="color: var(--brand-primary); margin-right: 10px;"></i> İnkişaf və Dəstək
                                    </button>
                                </h2>
                                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#choose-accordion">
                                    <div class="accordion-body" style="color: var(--color-text-sub);">
                                        Ən son texnologiyalarla layihənizi həyata keçiririk və startdan sonra da texniki dəstək göstərərək yanınızda oluruq.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="contact-form-box shadow-box mb--30 glass-card service-form-card" id="quote-form">
                    <h3 class="title">{{ __('front.contact.get_quote') }}</h3>
                    <form>
                        <div class="form-group">
                            <label>{{ __('front.contact.name') }}</label>
                            <input type="text" class="form-control" name="name" placeholder="John Smith" autocomplete="name">
                        </div>
                        <div class="form-group">
                            <label>{{ __('front.contact.email') }}</label>
                            <input type="email" class="form-control" name="email" placeholder="example@mail.com" autocomplete="email">
                        </div>
                        <div class="form-group mb--40">
                            <label>{{ __('front.contact.phone') }}</label>
                            <input type="tel" class="form-control" name="Phone" placeholder="+123456789" autocomplete="tel">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn-primary-custom btn-fluid" name="submit-btn">{{ __('front.contact.get_it_now') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section section-padding bg-color-light pb--70 service-process">
    <div class="container">
        <div class="section-heading mb--90">
            <span class="subtitle">Proses</span>
            <h2 class="title">İş Prosesimiz</h2>
            <p>Layihənizi uğurla həyata keçirmək üçün sübut edilmiş addımlar.</p>
        </div>
        <div class="process-work" data-sal="slide-right" data-sal-duration="1000" data-sal-delay="100">
            <div class="thumbnail paralax-image">
                <img src="{{ asset('assets/media/others/process-1.png') }}" alt="Thumbnail">
            </div>
            <div class="content">
                <span class="subtitle">Addım 1</span>
                <h3 class="title">Kəşf</h3>
                <p>Ehtiyaclarınızı və hədəflərinizi anlamaq üçün dərin analiz.</p>
            </div>
        </div>
        <div class="process-work content-reverse" data-sal="slide-left" data-sal-duration="1000" data-sal-delay="100">
            <div class="thumbnail paralax-image">
                <img src="{{ asset('assets/media/others/process-2.png') }}" alt="Thumbnail">
            </div>
            <div class="content">
                <span class="subtitle">Addım 2</span>
                <h3 class="title">Prototip</h3>
                <p>İlkin konseptlərin və dizayn eskizlərinin hazırlanması.</p>
            </div>
        </div>
        <div class="process-work" data-sal="slide-right" data-sal-duration="1000" data-sal-delay="100">
            <div class="thumbnail paralax-image">
                <img src="{{ asset('assets/media/others/process-3.png') }}" alt="Thumbnail">
            </div>
            <div class="content">
                <span class="subtitle">Addım 3</span>
                <h3 class="title">Test</h3>
                <p>Hər şeyin mükəmməl işlədiyinə əmin olmaq üçün yoxlama.</p>
            </div>
        </div>
        <div class="process-work content-reverse" data-sal="slide-left" data-sal-duration="1000" data-sal-delay="100">
            <div class="thumbnail paralax-image">
                <img src="{{ asset('assets/media/others/process-4.png') }}" alt="Thumbnail">
            </div>
            <div class="content">
                <span class="subtitle">Addım 4</span>
                <h3 class="title">Təhvil</h3>
                <p>Hazır layihənin təqdim edilməsi və dəstəyin başlanması.</p>
            </div>
        </div>
    </div>
</section>


@if($item->caseStudies->count() > 0)
<section class="section section-padding bg-color-light">
    <div class="container">
        <div class="section-heading heading-left">
            <h2 class="title">Əlaqəli Layihələr</h2>
        </div>
        <div class="row">
            @foreach($item->caseStudies as $caseStudy)
                <div class="col-lg-4 col-md-6" data-sal="slide-up" data-sal-duration="800">
                    <div class="project-grid glass-card" style="background: var(--card-bg); border: 1px solid var(--card-border); border-radius: 24px; overflow: hidden; transition: transform 0.3s ease, box-shadow 0.3s ease;">
                        <div class="thumbnail">
                            <a href="{{ route('case-study.show', $caseStudy->slug ?? '404') }}">
                                <img src="{{ asset('storage/' . $caseStudy->cover_image) }}" alt="{{ $caseStudy->title }}" style="width: 100%; height: 250px; object-fit: cover;">
                            </a>
                        </div>
                        <div class="content" style="padding: 25px;">
                            <h4 class="title" style="font-family: var(--font-heading); color: var(--color-text-main); margin-bottom: 8px;"><a href="{{ route('case-study.show', $caseStudy->slug ?? '404') }}">{{ $caseStudy->title }}</a></h4>
                            <span class="subtitle" style="color: var(--color-text-sub); font-size: 0.9rem;">{{ $caseStudy->category }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@if($item->testimonials->count() > 0)
<section class="section section-padding">
    <div class="container">
        <div class="section-heading heading-left">
            <h2 class="title">Müştəri Rəyləri</h2>
        </div>
        <div class="row">
            @foreach($item->testimonials as $testimonial)
                <div class="col-lg-4 col-md-6" data-sal="slide-up" data-sal-duration="800">
                    <div class="testimonial-grid glass-card" style="background: var(--card-bg); border: 1px solid var(--card-border); border-radius: 24px; padding: 35px; box-shadow: var(--card-shadow);">
                        <div class="author-info">
                            <div class="thumb">
                                <img src="{{ asset('storage/' . $testimonial->image) }}" alt="{{ $testimonial->name }}" style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover; border: 2px solid var(--brand-primary);">
                            </div>
                            <div class="content">
                                <h4 class="title" style="font-family: var(--font-heading); color: var(--color-text-main); margin-bottom: 4px;">{{ $testimonial->name }}</h4>
                                <span class="designation" style="color: var(--color-text-sub); font-size: 0.9rem;">{{ $testimonial->position }}</span>
                            </div>
                        </div>
                        <p style="margin-top: 20px; color: var(--color-text-main); line-height: 1.7;">{{ $testimonial->content }}</p>
                    </div>
                </div>
                    @endforeach
                </div>
            </div>
        </section>
@endif

@if($item->faqs->count() > 0)
<section class="section section-padding bg-color-light">
    <div class="container">
        <div class="section-heading heading-left mb--40">
            <span class="subtitle">Suallar</span>
            <h2 class="title">Tez-tez verilən suallar</h2>
        </div>
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="faq-accordion">
                    <div class="accordion" id="faqAccordion">
                        @foreach($item->faqs as $index => $faq)
                            <div class="accordion-item glass-card mb-4" style="background: var(--card-bg); border: 1px solid var(--card-border); border-radius: 16px; overflow: hidden;">
                                <h2 class="accordion-header" id="heading{{ $index }}">
                                    <button class="accordion-button {{ $index != 0 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}" aria-expanded="{{ $index == 0 ? 'true' : 'false' }}" aria-controls="collapse{{ $index }}" style="background: transparent; color: var(--color-text-main); font-family: var(--font-heading); font-weight: 500; font-size: 1.1rem; padding: 20px; width: 100%; text-align: left; border: none; display: flex; justify-content: space-between; align-items: center;">
                                        {{ $faq->question }}
                                    </button>
                                </h2>
                                <div id="collapse{{ $index }}" class="accordion-collapse collapse {{ $index == 0 ? 'show' : '' }}" aria-labelledby="heading{{ $index }}" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body" style="padding: 0 20px 20px; color: var(--color-text-sub); line-height: 1.7;">
                                        {{ $faq->answer }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif



@php
    $relatedServices = \App\Models\Service::where('id', '!=', $item->id)->inRandomOrder()->limit(3)->get();
@endphp

@if($relatedServices->count() > 0)
<section class="section section-padding">
    <div class="container">
        <div class="section-heading heading-left mb--40">
            <span class="subtitle">Digər xidmətlər</span>
            <h2 class="title">Sizi maraqlandıra bilər</h2>
        </div>
        <div class="row">
            @foreach($relatedServices as $rService)
                <div class="col-lg-4 col-md-6" data-sal="slide-up" data-sal-duration="800">
                    <div class="service-grid glass-card" style="background: var(--card-bg); border: 1px solid var(--card-border); border-radius: 20px; padding: 30px; height: 100%; transition: transform 0.3s;">
                        <div class="thumbnail" style="margin-bottom: 20px;">
                            @php
                                // Inline fix for icon path in related services too
                                $rIconUrl = asset('assets/media/icon/icon-1.png');
                                if ($rService->icon && file_exists(public_path($rService->icon))) {
                                    $rIconUrl = asset($rService->icon);
                                }
                            @endphp
                            <img src="{{ $rIconUrl }}" alt="icon" style="width: 50px; height: 50px; object-fit: contain;">
                        </div>
                        <div class="content">
                            <h5 class="title" style="font-family: var(--font-heading); margin-bottom: 10px;">
                                <a href="{{ route($serviceRouteName, $rService->slug ?? '404') }}" style="color: var(--color-text-main); text-decoration: none;">{{ $rService->name }}</a>
                            </h5>
                            <p style="color: var(--color-text-sub); font-size: 0.95rem; line-height: 1.6; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                                {{ $rService->description }}
                            </p>
                            <a href="{{ route($serviceRouteName, $rService->slug ?? '404') }}" class="more-btn" style="color: var(--brand-primary); font-weight: 600; font-size: 0.9rem; margin-top: 15px; display: inline-block;">
                                Ətraflı <span style="font-size: 1.2em;">&rarr;</span>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@include('front.inc.worck_togather')
@endsection

@extends('front.layouts.main')
@section('content')
<div class="breadcrum-area breadcrumb-banner">
    <div class="container">
        <div class="section-heading heading-left sal-animate" data-sal="slide-right" data-sal-duration="1000" data-sal-delay="300">
            <h1 class="title h2">{{$item->name}}</h1>
            <p>{{$item->description}}</p>
        </div>
        <div class="banner-thumbnail sal-animate" data-sal="slide-up" data-sal-duration="1000" data-sal-delay="400">
            <img class="paralax-image" src="{{asset(Storage::url($item->image))}}" alt="Illustration" style="will-change: transform; transform: perspective(1000px) rotateX(0deg) rotateY(0deg);">
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
<section class="section-padding single-portfolio-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-5">
                <div class="contact-form-box shadow-box mb--30 glass-card" style="background: rgba(255, 255, 255, 0.05); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 24px; padding: 35px; box-shadow: var(--card-shadow);">
                    <h3 class="title" style="color: var(--color-text-main); font-family: var(--font-heading); margin-bottom: 25px;">Get a free Keystroke quote now</h3>
                    <form>
                        <div class="form-group">
                            <label style="color: var(--color-text-sub); font-weight: 500; margin-bottom: 8px;">Name</label>
                            <input type="text" class="form-control" name="name" placeholder="John Smith" style="background: rgba(255, 255, 255, 0.08); border: 1px solid var(--card-border); color: var(--color-text-main); border-radius: 12px; padding: 12px 16px;">
                        </div>
                        <div class="form-group">
                            <label style="color: var(--color-text-sub); font-weight: 500; margin-bottom: 8px;">Email</label>
                            <input type="email" class="form-control" name="email" placeholder="example@mail.com" style="background: rgba(255, 255, 255, 0.08); border: 1px solid var(--card-border); color: var(--color-text-main); border-radius: 12px; padding: 12px 16px;">
                        </div>
                        <div class="form-group mb--40">
                            <label style="color: var(--color-text-sub); font-weight: 500; margin-bottom: 8px;">Phone</label>
                            <input type="tel" class="form-control" name="Phone" placeholder="+123456789" style="background: rgba(255, 255, 255, 0.08); border: 1px solid var(--card-border); color: var(--color-text-main); border-radius: 12px; padding: 12px 16px;">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn-primary-custom btn-fluid" name="submit-btn">Get Pricing Now</button>
                        </div>
                    </form>
                    @if($item->cta_link && $item->cta_text)
                        <div class="mt-4 text-center">
                            <a href="{{ $item->cta_link }}" class="btn-primary-custom btn-fluid">{{ $item->cta_text }}</a>
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-lg-6 offset-xl-1">
                <div class="why-choose-us">
                    <div class="section-heading heading-left">
                        <h3 class="title">{{ $content?->title }}</h3>
                        <div class="description-content">
                            {!! $content?->content !!}
                        </div>
                    </div>
                  
                   
                </div>
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
                            <a href="{{ route('case-study.show', $caseStudy->slug) }}">
                                <img src="{{ asset('storage/' . $caseStudy->cover_image) }}" alt="{{ $caseStudy->title }}" style="width: 100%; height: 250px; object-fit: cover;">
                            </a>
                        </div>
                        <div class="content" style="padding: 25px;">
                            <h4 class="title" style="font-family: var(--font-heading); color: var(--color-text-main); margin-bottom: 8px;"><a href="{{ route('case-study.show', $caseStudy->slug) }}">{{ $caseStudy->title }}</a></h4>
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

@include('front.inc.worck_togather')
@endsection
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
                <div class="section-heading heading-left mb-0">
                    <span class="subtitle">Branding, Creative</span>
                    <h3 class="title">{{$item->name}}</h3>
                </div>
                <p>{{$item->description}}</p>
                <a href="contact.html" class="axil-btn btn-fill-primary">Get it Now</a>
            </div>
            <div class="col-lg-6 offset-xl-1">
                <div class="why-choose-us">
                    <div class="section-heading heading-left">
                        <h3 class="title">We delivered</h3>
                        <p>Digital technology has made our world more transparent and interconnected, posing new challenges and opportunities for every business.</p>
                    </div>
                    <div class="accordion" id="choose-accordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                    <i class="far fa-compress"></i> Strategy
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#choose-accordion" style="">
                                <div class="accordion-body">
                                    Aenean hendrerit laoreet vehicula. Nullam convallis augue at enim gravida pellentesque.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    <i class="far fa-code"></i>Design
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#choose-accordion">
                                <div class="accordion-body">
                                    Aenean hendrerit laoreet vehicula. Nullam convallis augue at enim gravida pellentesque.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    <i class="fal fa-globe"></i>Development
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#choose-accordion">
                                <div class="accordion-body">
                                    Aenean hendrerit laoreet vehicula. Nullam convallis augue at enim gravida pellentesque.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@include('front.inc.worck_togather')
@endsection
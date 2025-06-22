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
                <div class="contact-form-box shadow-box mb--30">
                    <h3 class="title">Get a free Keystroke quote now</h3>
                    <form>
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name" placeholder="John Smith">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" name="name" placeholder="example@mail.com">
                        </div>
                        <div class="form-group mb--40">
                            <label>Phone</label>
                            <input type="tel" class="form-control" name="Phone" placeholder="+123456789">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="axil-btn btn-fill-primary btn-fluid" name="submit-btn">Get Pricing Now</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-6 offset-xl-1">
                <div class="why-choose-us">
                    <div class="section-heading heading-left">
                        <h3 class="title">{{$content?->title ?? ''}}</h3>
                        <p>{!!$content?->content!!}</p>
                    </div>
                  
                   
                </div>
            </div>
        </div>
    </div>
</section>
@include('front.inc.worck_togather')
@endsection

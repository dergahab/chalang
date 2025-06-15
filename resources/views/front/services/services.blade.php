@extends('front.layouts.main')
@section('content')
 <!--=====================================-->
        <!--=       Breadcrumb Area Start       =-->
        <!--=====================================-->
        <div class="breadcrum-area breadcrumb-banner">
            <div class="container">
                <div class="section-heading heading-left" data-sal="slide-right" data-sal-duration="1000" data-sal-delay="300">
                    <h1 class="title h2">{{ __('front.services.best_solutions') }}</h1>
                    <p>{{ __('front.services.logo_description') }}</p>
                </div>
                <div class="banner-thumbnail" data-sal="slide-up" data-sal-duration="1000" data-sal-delay="400">
                    <img class="paralax-image" src="assets/media/banner/banner-thumb-4.png" alt="Illustration">
                </div>
            </div>
            <ul class="shape-group-8 list-unstyled">
                <li class="shape shape-1" data-sal="slide-right" data-sal-duration="500" data-sal-delay="100">
                    <img src="assets/media/others/bubble-9.png" alt="Bubble">
                </li>
                <li class="shape shape-2" data-sal="slide-left" data-sal-duration="500" data-sal-delay="200">
                    <img src="assets/media/others/bubble-21.png" alt="Bubble">
                </li>
                <li class="shape shape-3" data-sal="slide-up" data-sal-duration="500" data-sal-delay="300">
                    <img src="assets/media/others/line-4.png" alt="Line">
                </li>
            </ul>
        </div>

        <div class="service-scroll-navigation-area">
            <nav id="onepagenav" class="service-scroll-nav navbar onepagefixed">
                <div class="container">
                    <ul class="nav nav-pills">
                        @foreach ($items as $item)
                        <li class="nav-item">
                            <a class="nav-link" href="#{{$item->name}}">{{$item->name}}</a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </nav>
          @foreach ($items as $item)
          <div class="section section-padding" id="{{$item->name}}">
            <div class="container">
                <div class="section-heading heading-left">
                    <span class="subtitle">{{ __('front.services.service_subtitle') }}</span>
                    <h2 class="title">{{$item->name}}</h2>
                </div>
                <div class="row">
                    @foreach ($item->childs as $child)
                    <div class="col-lg-4 col-md-6" data-sal="slide-up" data-sal-duration="800" data-sal-delay="100">
                        <div class="services-grid service-style-2">
                            <div class="thumbnail">
                                <img src="{{asset(Storage::url($child->icon))}}" alt="icon">
                            </div>
                            <div class="content">
                                <h5 class="title"> <a href="{{route('service.single',$child->slug)}}">{{$child->name}}</a></h5>
                                <p>{{$child->content}}</p>
                                <a href="{{route('service.single',$child->slug)}}" class="more-btn">Find out more</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
           </div>
          @endforeach
        </div>

        <!--=====================================-->
        <!--=     Call To Action Area Start     =-->
        <!--=====================================-->
        <section class="section call-to-action-area">
            <div class="container">
                <div class="call-to-action">
                    <div class="section-heading heading-light">
                        <span class="subtitle">{{ __('front.work_together.subtitle') }}</span>
                        <h2 class="title">{{ __('front.work_together.title') }}</h2>
                        <a href="contact.html" class="axil-btn btn-large btn-fill-white">Estimate Project</a>
                    </div>
                    <div class="thumbnail">
                        <div class="larg-thumb" data-sal="zoom-in" data-sal-duration="600" data-sal-delay="100">
                            <img src="assets/media/others/pc.png" alt="Computer">
                        </div>
                        <ul class="list-unstyled small-thumb">
                            <li class="shape shape-1" data-sal="slide-right" data-sal-duration="800" data-sal-delay="400">
                                <img src="assets/media/others/comment.png" alt="Comments">
                            </li>
                            <li class="shape shape-2" data-sal="slide-up" data-sal-duration="800" data-sal-delay="300">
                                <img src="assets/media/others/keyboard.png" alt="Comments">
                            </li>
                            <li class="shape shape-3" data-sal="slide-right" data-sal-duration="800" data-sal-delay="300">
                                <img src="assets/media/others/mouse.png" alt="Comments">
                            </li>
                            <li class="shape shape-4" data-sal="slide-left" data-sal-duration="800" data-sal-delay="300">
                                <img src="assets/media/others/bell-icon.png" alt="Comments">
                            </li>
                            <li class="shape shape-5" data-sal="zoom-in" data-sal-duration="800" data-sal-delay="200">
                                <img src="assets/media/others/chat-bot.png" alt="Comments">
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <ul class="list-unstyled shape-group-9">
                <li class="shape shape-1"><img src="assets/media/others/bubble-12.png" alt="Comments"></li>
                <li class="shape shape-2"><img src="assets/media/others/bubble-16.png" alt="Comments"></li>
                <li class="shape shape-3"><img src="assets/media/others/bubble-13.png" alt="Comments"></li>
                <li class="shape shape-4"><img src="assets/media/others/bubble-14.png" alt="Comments"></li>
                <li class="shape shape-5"><img src="assets/media/others/bubble-16.png" alt="Comments"></li>
                <li class="shape shape-6"><img src="assets/media/others/bubble-15.png" alt="Comments"></li>
                <li class="shape shape-7"><img src="assets/media/others/bubble-16.png" alt="Comments"></li>
            </ul>
        </section>
        <!--=====================================-->
        <!--=        Footer Area Start       	=-->
        <!--=====================================-->
@endsection
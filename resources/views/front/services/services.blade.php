@extends('front.layouts.main')
@section('content')
 <!--=====================================-->
        <!--=       Breadcrumb Area Start       =-->
        <!--=====================================-->
        <div class="breadcrum-area breadcrumb-banner">
            <div class="container">
                <div class="section-heading heading-left" data-sal="slide-right" data-sal-duration="1000" data-sal-delay="300">
                    <h1 class="title h2">{{ __("ServiceTitle") }}</h1>
                    <p>{{ __("ServiceDesctioption") }}</p>
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
                                <img src="{{asset(Storage::url( '/public/'.$child->icon))}}" alt="icon">
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
@include('front.inc.worck_togather')
@endsection

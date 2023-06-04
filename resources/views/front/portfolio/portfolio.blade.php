@extends('front.layouts.main')
@section('content') 
<div class="breadcrum-area breadcrumb-banner">
    <div class="container">
        <div class="section-heading heading-left" data-sal="slide-right" data-sal-duration="1000" data-sal-delay="300">
            <h1 class="title h2">Our projects</h1>
            <p>A quick view of industry specific problems solved with design by the awesome team at Abstrak.</p>
        </div>
        <div class="banner-thumbnail" data-sal="slide-up" data-sal-duration="1000" data-sal-delay="400">
            <img class="paralax-image" src="assets/media/banner/banner-thumb-1.png" alt="Illustration">
        </div>
    </div>
    <ul class="shape-group-8 list-unstyled">
        <li class="shape shape-1" data-sal="slide-right" data-sal-duration="500" data-sal-delay="100">
            <img src="assets/media/others/bubble-9.png" alt="Bubble">
        </li>
        <li class="shape shape-2" data-sal="slide-left" data-sal-duration="500" data-sal-delay="200">
            <img src="assets/media/others/bubble-20.png" alt="Bubble">
        </li>
        <li class="shape shape-3" data-sal="slide-up" data-sal-duration="500" data-sal-delay="300">
            <img src="assets/media/others/line-4.png" alt="Line">
        </li>
    </ul>
</div>     
    <section class="section section-padding-equal project-column-4 pt--200 pt_md--80 pt_sm--60">    
    <div class="container">
                <div class="section-heading heading-left">
                    <span class="subtitle">Our Project</span>
                    <h2 class="title">Some of our finest <br> work.</h2>
                </div>
                <div class="axil-isotope-wrapper">
                    <div class="isotope-button isotope-project-btn">
                        <button data-filter="all" class="is-checked filter-button" class="filter-button"><span class="filter-text">All Works</span></button>
                       
                        @foreach ($portfolio_categories as $pcategory)
                            <button data-filter="{{$pcategory->name}}" class="filter-button"><span class="filter-text">{{$pcategory->name}}</span></button>
                        @endforeach
                    </div>
                    <div class="row isotope-list">
                        @foreach ($portfolios as $portfolio)
                        <div class="col-xl-3 col-lg-4 col-md-6 filter @foreach ($portfolio->pcategories as $subtitle) {{$subtitle->name}}   @endforeach">
                            <div class="project-grid">
                                <div class="thumbnail">
                                    <a href="{{route('portfolio.single',$portfolio->slug)}}">
                                        <img src="{{asset(Storage::url($portfolio->image))}}" alt="project">
                                    </a>
                                </div>
                                <div class="content">
                                    <h5 class="title"><a href="{{route('portfolio.single',$portfolio->slug)}}">{{$portfolio->title}}</a></h5>
                                    <span class="subtitle">
                                        @foreach ($portfolio->pcategories as $subtitle)
                                        {{$subtitle->name}} 
                                         @if (! $loop->last)
                                        ,
                                    @endif
                                    @endforeach
                                    </span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="more-project-btn">
                        <a href="#" class="axil-btn btn-fill-primary">Discover More Projects</a>
                    </div>
                </div>
            </div>
            <ul class="shape-group-7 list-unstyled">
                <li class="shape shape-1"><img src="assets/media/others/circle-2.png" alt="circle"></li>
                <li class="shape shape-2"><img src="assets/media/others/bubble-2.png" alt="Line"></li>
                <li class="shape shape-3"><img src="assets/media/others/bubble-1.png" alt="Line"></li>
            </ul>
        </section>
        @include('front.inc.worck_togather')
@endsection
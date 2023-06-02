@extends('front.layouts.main')
@section('content')
      <!--=====================================-->
        <!--=        Banner Area Start         =-->
        <!--=====================================-->
        <section class="banner banner-style-4">
            <div class="container">
                <div class="banner-content">
                    <h1 class="title" data-sal="slide-up" data-sal-duration="1000" data-sal-delay="100">Think the design, design the thinking.</h1>
                    <p data-sal="slide-up" data-sal-duration="1000">Create live segments and target the right people
                        for messages based on their behaviors.</p>
                    <div data-sal="slide-up" data-sal-duration="1000" data-sal-delay="200">
                        <a href="portfolio.html" class="axil-btn btn-fill-primary btn-large">View Showcase</a>
                    </div>
                </div>
                <div class="banner-thumbnail">
                    <div class="large-thumb" data-sal="slide-left" data-sal-duration="800" data-sal-delay="400">
                        <img class="paralax-image" src="assets/media/banner/banner-thumb-7.png" alt="Shape">
                    </div>
                </div>
                <div class="banner-social" data-sal="slide-up" data-sal-duration="800">
                    <div class="border-line"></div>
                    <ul class="list-unstyled social-icon">
                        @foreach ($socialmedia as $media) 
                            <li><a href="{{$media->link}}"><i class="{{$media->icon}}"></i> {{$media->name}}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <ul class="list-unstyled shape-group-19">
                <li class="shape shape-1" data-sal="slide-down" data-sal-duration="500" data-sal-delay="100">
                    <img src="assets/media/others/bubble-29.png" alt="Bubble">
                </li>
                <li class="shape shape-2" data-sal="slide-left" data-sal-duration="500" data-sal-delay="200">
                    <img src="assets/media/others/line-7.png" alt="Bubble">
                </li>
            </ul>
        </section>
        <!--=====================================-->
        <!--=        Service Area Start         =-->
        <!--=====================================-->
        <section class="section section-padding-equal bg-color-dark">
            <div class="container">
                <div class="section-heading heading-light-left">
                    <span class="subtitle">What We Can Do For You</span>
                    <h2 class="title">Services we can help you with</h2>
                    <p class="opacity-50">Nulla facilisi. Nullam in magna id dolor
                        blandit rutrum eget vulputate augue sed eu imperdiet.</p>
                </div>
                <div class="row">
                    @foreach ($main_services as $service)
                    <div class="col-lg-4 col-md-6 sal-animate" data-sal="slide-up" data-sal-duration="800" data-sal-delay="100">
                        <div class="services-grid ">
                            <div class="thumbnail">
                                {{-- <img src="assets/media/icon/icon-1.png" alt="icon"> --}}
                                <img src="{{asset(Storage::url($service->icon))}}" alt="icon">
                            </div>
                            <div class="content">
                                <h5 class="title"> <a href="service-design.html">{{$service->name}}</a></h5>
                                <p>{{$service->content}}</p>
                                <a href="service-design.html" class="more-btn">Find out more</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <ul class="list-unstyled shape-group-10">
                <li class="shape shape-1"><img src="assets/media/others/circle-1.png" alt="Circle"></li>
                <li class="shape shape-2"><img src="assets/media/others/line-3.png" alt="Circle"></li>
                <li class="shape shape-3"><img src="assets/media/others/bubble-5.png" alt="Circle"></li>
            </ul>
        </section>
        <!--=====================================-->
        <!--=       Case Study Area Start       =-->
        <!--=====================================-->
    
        <!--=====================================-->
        <!--=        About Area Start         =-->
        <!--=====================================-->
        <section class="section section-padding-equal bg-color-light">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6" data-sal="slide-up" data-sal-duration="800">
                        <div class="about-us">
                            <div class="section-heading heading-left mb-0">
                                <span class="subtitle">About Us</span>
                                <h2 class="title mb--40">We do design, code & develop.</h2>
                                <p>Nulla et velit gravida, facilisis quam a, molestie ante. Mauris placerat suscipit dui, eget maximus tellus blandit a. Praesent non tellus sed ligula commodo blandit in et mauris. Quisque efficitur ipsum ut dolor molestie pellentesque. </p>
                                <p>Nulla pharetra hendrerit mi quis dapibus. Quisque luctus, tortor a venenatis fermentum, est lacus feugiat nisl, id pharetra odio enim eget libero. </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-5 col-lg-6 offset-xl-1" data-sal="slide-up" data-sal-duration="800" data-sal-delay="100">
                        <div class="contact-form-box">
                            <h3 class="title">Get a free Keystroke quote now</h3>
                            <form method="POST" action="mail.php" class="axil-contact-form">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" class="form-control" name="contact-name" placeholder="John Smith">
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" class="form-control" name="contact-email" placeholder="example@mail.com">
                                </div>
                                <div class="form-group mb--40">
                                    <label>Phone</label>
                                    <input type="tel" class="form-control" name="contact-company" placeholder="+123456789">
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="axil-btn btn-fill-primary btn-fluid btn-primary" name="submit-btn">Get Free Quote</button>
                                </div>
                                <input type="hidden" class="form-control" name="contact-message" value="Null">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <ul class="shape-group-6 list-unstyled">
                <li class="shape shape-1"><img src="{{asset('assets/media/others/bubble-7.png')}}" alt="Bubble"></li>
                <li class="shape shape-2"><img src="{{asset('assets/media/others/line-4.png')}}" alt="line"></li>
                <li class="shape shape-3"><img src="{{asset('assets/media/others/line-5.png')}}" alt="line"></li>
            </ul>
        </section>
        <!--=====================================-->
        <!--=        Project Area Start         =-->
        <!--=====================================-->
        <section class="section section-padding-2 bg-reb">
            <div class="container">
                <div class="section-heading heading-left mb--40">
                    <span class="subtitle">Our Project</span>
                    <h2 class="title">Our Project</h2>
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
                                    <a href="single-portfolio.html">
                                        <img src="{{asset(Storage::url($portfolio->image))}}" alt="project">
                                    </a>
                                </div>
                                <div class="content">
                                    <h5 class="title"><a href="single-portfolio.html">{{$portfolio->title}}</a></h5>
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
                        <a href="{{route('portfolio')}}" class="axil-btn btn-fill-primary">Discover More Projects</a>
                    </div>
                </div>
            </div>
            <ul class="shape-group-7 list-unstyled">
                <li class="shape shape-1"><img src="{{asset('assets/media/others/circle-2.png')}}" alt="circle"></li>
                <li class="shape shape-2"><img src="{{asset('assets/media/others/bubble-2.png')}}" alt="Line"></li>
                <li class="shape shape-3"><img src="{{asset('assets/media/others/bubble-1.png')}}" alt="Line"></li>
            </ul>
        </section>
    
        <!--=====================================-->
        <!--=        Brand Area Start       	=-->
        <!--=====================================-->
        <section class="section section-padding bg-color-dark">
            <div class="container">
                <div class="section-heading heading-light-left">
                    <span class="subtitle">Top Clients</span>
                    <h2 class="title"> Clients</h2>
                    <p>Design anything from simple icons to fully featured websites and applications.</p>
                </div>
                <div class="row">
                    @foreach ($companies as $company)
                    <div class="col-lg-3 col-6" data-sal="slide-up" data-sal-duration="500">
                        <div class="brand-grid active">
                            <img src="{{$company->image}}" alt="{{$company->name}}">
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <ul class="shape-group-2 list-unstyled">
                <li class="shape shape-1"><img src="assets/media/others/circle-1.png" alt="circle"></li>
                <li class="shape shape-2"><img src="assets/media/others/line-3.png" alt="circle"></li>
                <li class="shape shape-3"><img src="assets/media/others/bubble-3.png" alt="circle"></li>
            </ul>
        </section>
 
        <section class="section section-padding-equal pt-0 related-blog-area">
            <div class="container">
                <div class="section-heading heading-left">
                    <h3 class="title">Related Post</h3>
                </div>
                <div class="swiper mySwiper">
                    <div class="swiper-wrapper">
                        @foreach ($blogs as $blog)
                        <div class="swiper-slide">
                            <div class="blog-list blog-bg">
                                <div class="post-thumbnail">
                                    <a href="single-blog.html" tabindex="-1"><img src="{{asset(Storage::url($blog->image))}}" alt="{{$blog->title}}"></a>
                                </div>
                                <div class="post-content">
                                    <h5 class="title"><a href="single-blog-3.html" tabindex="-1">{{$blog->title}}</a></h5>
                                    {!! Illuminate\Support\Str::limit($blog->content, $limit = 100, $end = '...')!!}</>
                                    <a href="single-blog-3.html" class="more-btn" tabindex="-1">Learn more<i class="far fa-angle-right"></i></a>
                                </div>
                            </div>
                          </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination"></div>
                  </div>
            </div>
        </section>
        <section class="section call-to-action-area">
            <div class="container">
                <div class="call-to-action">
                    <div class="section-heading heading-light">
                        <span class="subtitle">Let's Work Together</span>
                        <h2 class="title">Need a successful project?</h2>
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
@endsection
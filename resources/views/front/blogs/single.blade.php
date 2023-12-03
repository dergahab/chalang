@extends('front.layouts.main')
@section('content')
    <div class="breadcrum-area">
        <div class="container">
            <div class="breadcrumb">
                <ul class="list-unstyled">
                    <li><a href="{{ route('/') }}">Home</a></li>
                    <li class="active">Blog</li>
                </ul>
                <h1 class="title h2">{{ $item->title }}</h1>
            </div>
        </div>
        <ul class="shape-group-8 list-unstyled">
            <li class="shape shape-1" data-sal="slide-right" data-sal-duration="500" data-sal-delay="100"><img
                    src="{{ asset('assets/media/others/bubble-9.png') }}" alt="Bubble"></li>
            <li class="shape shape-2" data-sal="slide-left" data-sal-duration="500" data-sal-delay="200"><img
                    src="{{ asset('assets/media/others/bubble-11.png') }}" alt="Bubble"></li>
            <li class="shape shape-3" data-sal="slide-up" data-sal-duration="500" data-sal-delay="300"><img
                    src="{{ asset('assets/media/others/line-4.png') }}" alt="Line"></li>
        </ul>
    </div>
    <section class="section-padding-equal">
        <div class="container">
            <div class="row row-40">
                <div class="col-lg-8">
                    <div class="single-blog">
                        <div class="single-blog-content blog-grid">
                            <div class="post-thumbnail">
                                <img src="{{ asset(Storage::url($item->big_image)) }}" alt="Blog">
                            </div>
                            {{-- <div class="author">
                                <div class="author-thumb">
                                    <img src="{{ asset('assets/media/blog/author-1.png') }}" alt="Blog Author">
                                </div>
                                <div class="info">
                                    <h6 class="author-name">Theresa Underwood</h6>
                                    <ul class="blog-meta list-unstyled">
                                        <li>{{ $item->created_at }}</li>
                                        <li>{{ $item->viewed }} min to read</li>
                                    </ul>
                                </div>
                            </div> --}}
                            {{ $item->content }}

                        </div>

                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="axil-sidebar">
                        <div class="widget widget-search">
                            <h4 class="widget-title">Search</h4>
                            <form action="#" class="blog-search">
                                <input type="text" placeholder="Search…">
                                <button class="search-button"><i class="fal fa-search"></i></button>
                            </form>
                        </div>
                        @include('front.blogs.category')
                        @include('front.blogs.follow')
                        @include('front.blogs.resently')
                        <div class="widget widget-banner-ad">
                            <a href="#">
                                <img src="assets/media/banner/widget-banner.png" alt="banner">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--=====================================-->
    <!--=       Recent Post Area Start      =-->
    <!--=====================================-->
    <section class="section section-padding-equal pt-0 related-blog-area">
        <div class="container">
            <div class="section-heading heading-left">
                <h3 class="title">Related Post</h3>
            </div>
            <div class="slick-slider recent-post-slide"
                data-slick='{"infinite": true, "autoplay": true, "arrows": false, "dots": false, "slidesToShow": 2,
"responsive": [
    {
        "breakpoint": 1199,
        "settings": {
            "slidesToShow": 1
        }
    }
]
}'>
                <div class="slick-slide">
                    <div class="blog-list">
                        <div class="post-thumbnail">
                            <a href="single-blog.html"><img src="assets/media/blog/blog-1.png" alt="Blog Post"></a>
                        </div>
                        <div class="post-content">
                            <h5 class="title"><a href="single-blog-2.html">How To Use a Remarketing Strategy To Get
                                    More</a></h5>
                            <p>Demand generation is a constant struggle for any business. Each marketing strategy you employ
                                has...</p>
                            <a href="single-blog-2.html" class="more-btn">Learn more<i class="far fa-angle-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="slick-slide">
                    <div class="blog-list">
                        <div class="post-thumbnail">
                            <a href="single-blog.html"><img src="assets/media/blog/blog-2.png" alt="Blog Post"></a>
                        </div>
                        <div class="post-content">
                            <h5 class="title"><a href="single-blog-3.html">SEO Statistics You Should Know in 2021</a></h5>
                            <p>Organic search has the potential to capture more than 40 percent of your gross revenue...</p>
                            <a href="single-blog-3.html" class="more-btn">Learn more<i class="far fa-angle-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="slick-slide">
                    <div class="blog-list">
                        <div class="post-thumbnail">
                            <a href="single-blog.html"><img src="assets/media/blog/blog-1.png" alt="Blog Post"></a>
                        </div>
                        <div class="post-content">
                            <h5 class="title"><a href="single-blog-2.html">How To Use a Remarketing Strategy To Get
                                    More</a></h5>
                            <p>Demand generation is a constant struggle for any business. Each marketing strategy you employ
                                has...</p>
                            <a href="single-blog-2.html" class="more-btn">Learn more<i class="far fa-angle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--=====================================-->
    <!--=     Call To Action Area Start     =-->
    <!--=====================================-->
    @include('front.inc.worck_togather')
@endsection

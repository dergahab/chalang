@extends('front.layouts.main')
@section('content')
        <!--=====================================-->
        <!--=       Breadcrumb Area Start       =-->
        <!--=====================================-->
        <div class="breadcrum-area">
            <div class="container">
                <div class="breadcrumb">
                    <ul class="list-unstyled">
                        <li><a href="index-1.html">Home</a></li>
                        <li class="active">Blog</li>
                    </ul>
                    <h1 class="title h2">Blog</h1>
                </div>
            </div>
            <ul class="shape-group-8 list-unstyled">
                <li class="shape shape-1" data-sal="slide-right" data-sal-duration="500" data-sal-delay="100"><img src="assets/media/others/bubble-9.png" alt="Bubble"></li>
                <li class="shape shape-2" data-sal="slide-left" data-sal-duration="500" data-sal-delay="200"><img src="assets/media/others/bubble-10.png" alt="Bubble"></li>
                <li class="shape shape-3" data-sal="slide-up" data-sal-duration="500" data-sal-delay="300"><img src="assets/media/others/line-4.png" alt="Line"></li>
            </ul>
        </div>
        <!--=====================================-->
        <!--=        Blog Area Start       	    =-->
        <!--=====================================-->
        <section class="section-padding-equal">
            <div class="container">
                <div class="row row-40">
                    <div class="col-lg-8">
                       @foreach ($blogs as $blog)
                       <div class="blog-grid">
                        <h3 class="title"><a href="single-blog.html">{{$blog->title}}</a></h3>
                        <div class="author">
                            <div class="author-thumb">
                                <img src="{{asset('assets/media/blog/author-1.png')}}" alt="Blog Author">
                            </div>
                            <div class="info">
                                <h6 class="author-name">Theresa Underwood</h6>
                                <ul class="blog-meta list-unstyled">
                                    
                                    <li>{{ $blog->created_at}}</li>
                                    <li>{{$blog->viewed}} min to read</li>
                                </ul>
                            </div>
                        </div>
                        <div class="post-thumbnail">
                            <a href="{{route('blog.single',$blog->slug)}}"><img src="{{asset(Storage::url($blog->big_image))}}" alt="Blog"></a>
                        </div>
                        <p>Want to know the one thing that every successful digital marketer does first to ensure they get the biggest return on their marketing budget? It’s simple: goal-setting. This is an absolutely essential practice for any digital marketer who knows how to execute their campaigns</p>
                        <a href="{{route('blog.single',$blog->slug)}}" class="axil-btn btn-borderd btn-large">Read More</a>
                    </div>
                       @endforeach                    
                        <div class="pagination">
                            <ul>
                                <li><a class="prev page-numbers" href="#"><i class="fal fa-arrow-left"></i></a></li>
                                <li><a href="#" class="page-numbers current">1</a></li>
                                <li><a class="page-numbers" href="#">2</a></li>
                                <li><a class="page-numbers" href="#">3</a></li>
                                <li><a class="page-numbers" href="#">4</a></li>
                                <li><a class="page-numbers" href="#">5</a></li>
                                <li><a class="next page-numbers" href="#"><i class="fal fa-arrow-right"></i></a></li>
                            </ul>
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
                                    <img src="{{asset('assets/media/banner/widget-banner.png')}}" alt="banner">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @include('front.inc.worck_togather')
@endsection
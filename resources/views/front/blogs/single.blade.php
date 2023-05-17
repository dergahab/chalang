@extends('front.layouts.main')
@section('content')
<div class="breadcrum-area">
    <div class="container">
        <div class="breadcrumb">
            <ul class="list-unstyled">
                <li><a href="{{route('/')}}">Home</a></li>
                <li class="active">Blog</li>
            </ul>
            <h1 class="title h2">{{$item->title}}</h1>
        </div>
    </div>
    <ul class="shape-group-8 list-unstyled">
        <li class="shape shape-1" data-sal="slide-right" data-sal-duration="500" data-sal-delay="100"><img src="{{asset('assets/media/others/bubble-9.png')}}" alt="Bubble"></li>
        <li class="shape shape-2" data-sal="slide-left" data-sal-duration="500" data-sal-delay="200"><img src="{{asset('assets/media/others/bubble-11.png')}}" alt="Bubble"></li>
        <li class="shape shape-3" data-sal="slide-up" data-sal-duration="500" data-sal-delay="300"><img src="{{asset('assets/media/others/line-4.png')}}" alt="Line"></li>
    </ul>
</div>
<section class="section-padding-equal">
    <div class="container">
        <div class="row row-40">
            <div class="col-lg-8">
                <div class="single-blog">
                    <div class="single-blog-content blog-grid">
                        <div class="post-thumbnail">
                            <img src="{{asset(Storage::url($item->big_image))}}" alt="Blog">
                        </div>
                        <div class="author">
                            <div class="author-thumb">
                                <img src="{{asset('assets/media/blog/author-1.png')}}" alt="Blog Author">
                            </div>
                            <div class="info">
                                <h6 class="author-name">Theresa Underwood</h6>
                                <ul class="blog-meta list-unstyled">
                                    <li>{{$item->created_at}}</li>
                                    <li>{{$item->viewed }} min to read</li>
                                </ul>
                            </div>
                        </div>
                        {!!$item->content!!}
                        {{-- <div class="blog-grid blog-without-thumb mt--80">
                            <blockquote>
                                <h5 class="title"><a href="single-blog.html">“ Donec metus lorem, vulputate at sapien sit amet, auctor iaculis lorem. In vel hendrerit nisi. Vestibulum eget risus velit. ”</a></h5>
                            </blockquote>
                            <div class="author">
                                <div class="info">
                                    <h6 class="author-name">Theresa Underwood</h6>
                                    <ul class="blog-meta list-unstyled">
                                        <li>Sep 5, 2021</li>
                                        <li>15 min to read</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <h3 class="title mb--30">Habitasse per feugiat aliquam luctus accumsan curae</h3>
                        <p class="mb--40">Email is a crucial channel in any marketing mix, and never has this been truer than for today’s entrepreneur. Curious what to say? How to say it? How often to hit “send”? Each bite-sized lesson delivers core concepts, guiding questions, and tactical how-to resources.</p>
                        <div class="row">
                            <div class="col-6">
                                <div class="featured-img">
                                    <img src="assets/media/blog/blog-8.png" alt="Blog">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="featured-img">
                                    <img src="assets/media/blog/blog-9.png" alt="Blog">
                                </div>
                            </div>
                        </div> --}}
                    </div>
                    {{-- <div class="blog-author">
                        <div class="author">
                            <div class="author-thumb">
                                <img src="assets/media/blog/author-3.png" alt="Blog Author">
                            </div>
                            <div class="info">
                                <h5 class="title"><a href="#">Theresa Underwood</a></h5>
                                <p>Email is a crucial channel in any marketing mix,
                                    and never has this been truer than for today’s entrepreneur. Curious
                                    what to say.</p>
                                <ul class="social-share list-unstyled">
                                    <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                    <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                    <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                                    <li><a href="#"><i class="fab fa-pinterest-p"></i></a></li>
                                    <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                                    <li><a href="#"><i class="fab fa-vimeo-v"></i></a></li>
                                    <li><a href="#"><i class="fab fa-dribbble"></i></a></li>
                                    <li><a href="#"><i class="fab fa-behance"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="blog-comment">
                        <h3 class="section-title">Comments:</h3>
                        <div class="comment-list">
                            <!-- Start Single Comment  -->
                            <div class="comment">
                                <div class="thumbnail">
                                    <img src="assets/media/blog/author-1.png" alt="Blog Comment">
                                </div>
                                <div class="content">
                                    <div class="heading">
                                        <h5 class="title">Sophie Asveld</h5>
                                        <div class="comment-date">
                                            <p>February 14, 2021</p>
                                            <a class="reply-btn" href="#"><i class="fas fa-reply"></i></a>
                                        </div>
                                    </div>
                                    <p>Email is a crucial channel in any marketing mix,
                                        and never has this been truer than for today’s entrepreneur. Curious
                                        what to say.</p>
                                </div>
                            </div>
                            <!-- End Single Comment  -->
                            <!-- Start Single Comment  -->
                            <div class="comment comment-reply">
                                <div class="thumbnail">
                                    <img src="assets/media/blog/author-2.png" alt="Blog Comment">
                                </div>
                                <div class="content">
                                    <div class="heading">
                                        <h5 class="title">Ariana Gerad</h5>
                                        <div class="comment-date">
                                            <p>February 14, 2021</p>
                                            <a class="reply-btn" href="#"><i class="fas fa-reply"></i></a>
                                        </div>
                                    </div>
                                    <p>Email is a crucial channel in any marketing mix,
                                        and never has this been truer than for today’s entrepreneur. Curious
                                        what to say.</p>
                                </div>
                            </div>
                            <!-- End Single Comment  -->
                            <!-- Start Single Comment  -->
                            <div class="comment">
                                <div class="thumbnail">
                                    <img src="assets/media/blog/author-3.png" alt="Blog Comment">
                                </div>
                                <div class="content">
                                    <div class="heading">
                                        <h5 class="title">Sophie Asveld</h5>
                                        <div class="comment-date">
                                            <p>February 14, 2021</p>
                                            <a class="reply-btn" href="#"><i class="fas fa-reply"></i></a>
                                        </div>
                                    </div>
                                    <p>Email is a crucial channel in any marketing mix,
                                        and never has this been truer than for today’s entrepreneur. Curious
                                        what to say.</p>
                                </div>
                            </div>
                            <!-- End Single Comment  -->
                        </div>
                    </div>
                    <div class="blog-comment-form">
                        <h3 class="title">Leave a comment:</h3>
                        <form>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" class="form-control" name="name" placeholder="John Smith">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" class="form-control" name="name" placeholder="example@mail.com">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Phone</label>
                                        <input type="tel" class="form-control" name="Phone" placeholder="+123456789">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Website</label>
                                        <input type="text" class="form-control" name="website" placeholder="www.example.com">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group mb--30">
                                        <label>How can we help you?</label>
                                        <textarea name="message" id="message" class="form-control textarea" cols="30" rows="4"></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-5">
                                    <div class="form-group">
                                        <button type="submit" class="axil-btn btn-fill-primary btn-fluid" name="submit-btn">Submit Now</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div> --}}
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
        <div class="slick-slider recent-post-slide" data-slick='{"infinite": true, "autoplay": true, "arrows": false, "dots": false, "slidesToShow": 2,
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
                        <h5 class="title"><a href="single-blog-2.html">How To Use a Remarketing Strategy To Get More</a></h5>
                        <p>Demand generation is a constant struggle for any business. Each marketing strategy you employ has...</p>
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
                        <h5 class="title"><a href="single-blog-2.html">How To Use a Remarketing Strategy To Get More</a></h5>
                        <p>Demand generation is a constant struggle for any business. Each marketing strategy you employ has...</p>
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
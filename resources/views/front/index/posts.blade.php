<section class="section section-padding related-blog-area">
    <div class="container">
        <div class="section-heading heading-left">
            <h3 class="title">Bloqlar</h3>
        </div>
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                @foreach ($blogs as $blog)
                    <div class="swiper-slide">
                        <div class="blog-list blog-bg">
                            <div class="post-thumbnail">
                                <a href="single-blog.html" tabindex="-1"><img
                                        src="{{ asset(Storage::url($blog->image)) }}" alt="{{ $blog->title }}"></a>
                            </div>
                            <div class="post-content">
                                <h5 class="title"><a href="single-blog-3.html" tabindex="-1">{{ $blog->title }}</a>
                                </h5>
                                {!! Illuminate\Support\Str::limit($blog->content, $limit = 100, $end = '...') !!}
                                <a href="single-blog-3.html" class="more-btn" tabindex="-1">Ətraflı<i
                                        class="far fa-angle-right"></i></a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</section>

@extends('front.layouts.main')
@section('content')
    <!--=====================================-->
    <!--=       Breadcrumb Area Start       =-->
    <!--=====================================-->
    <div class="breadcrum-area">
        <div class="container">
            <div class="breadcrumb">
                <ul class="list-unstyled">
                    <li><a href="{{ route('/') }}">{{ __('front.home') }}</a></li>
                    <li class="active">{{ __('front.blog.title') }}</li>
                </ul>
                <h1 class="title h2">{{ __('front.blog.title') }}</h1>
            </div>
        </div>
        <ul class="shape-group-8 list-unstyled">
            <li class="shape shape-1" data-sal="slide-right" data-sal-duration="500" data-sal-delay="100"><img
                    src="assets/media/others/bubble-9.png" alt="Bubble"></li>
            <li class="shape shape-2" data-sal="slide-left" data-sal-duration="500" data-sal-delay="200"><img
                    src="assets/media/others/bubble-10.png" alt="Bubble"></li>
            <li class="shape shape-3" data-sal="slide-up" data-sal-duration="500" data-sal-delay="300"><img
                    src="assets/media/others/line-4.png" alt="Line"></li>
        </ul>
    </div>
    <!--=====================================-->
    <!--=        Blog Area Start            =-->
    <!--=====================================-->
    <section class="section-padding-equal">
        <div class="container">
            <div class="row row-40">
                <div class="col-lg-8">
                    @forelse ($data as $blog)
                        <div class="blog-grid">
                            <h3 class="title"><a href="{{ route('blog', $blog->slug) }}">{{ $blog->title }}</a></h3>
                            {{-- <div class="author">
                                <div class="author-thumb">
                                    <img src="{{ asset('assets/media/blog/author-1.png') }}" alt="Blog Author">
                                </div>
                                <div class="info">
                                    <h6 class="author-name">Theresa Underwood</h6>
                                    <ul class="blog-meta list-unstyled">

                                        <li>{{ $blog->created_at }}</li>
                                        <li>{{ $blog->viewed }} min to read</li>
                                    </ul>
                                </div>
                            </div> --}}
                            <div class="post-thumbnail">
                                <a href="{{ route('blog', $blog->slug) }}"><img
                                        src="{{ $blog->big_image ? asset(Storage::url($blog->big_image)) : '' }}"
                                        alt="{{ $blog->title }}"></a>
                            </div>
                            <p>{!! Illuminate\Support\Str::limit($blog->content, 200) !!}</p>
                            <a href="{{ route('blog', $blog->slug) }}" class="axil-btn btn-borderd btn-large">
                                {{ __('front.blog.read_more') }}
                            </a>
                        </div>
                    @empty
                        <p class="text-center">{{ __('front.blog.empty_state') }}</p>
                    @endforelse

                    @if ($data->hasPages())
                        <div class="pagination">
                            <ul>
                                @if ($data->onFirstPage())
                                    <li><span class="prev page-numbers disabled"><i class="fal fa-arrow-left"></i></span>
                                    </li>
                                @else
                                    <li><a class="prev page-numbers" href="{{ $data->previousPageUrl() }}"><i
                                                class="fal fa-arrow-left"></i></a></li>
                                @endif

                                @for ($page = 1; $page <= $data->lastPage(); $page++)
                                    <li>
                                        <a href="{{ $data->url($page) }}"
                                            class="page-numbers {{ $data->currentPage() === $page ? 'current' : '' }}">{{ $page }}</a>
                                    </li>
                                @endfor

                                @if ($data->hasMorePages())
                                    <li><a class="next page-numbers" href="{{ $data->nextPageUrl() }}"><i
                                                class="fal fa-arrow-right"></i></a></li>
                                @else
                                    <li><span class="next page-numbers disabled"><i
                                                class="fal fa-arrow-right"></i></span></li>
                                @endif
                            </ul>
                        </div>
                    @endif

                </div>
                <div class="col-lg-4">
                    <div class="axil-sidebar">
                        <div class="widget widget-search">
                            <h4 class="widget-title">{{ __('front.blog.search') }}</h4>
                            <form action="#" class="blog-search">
                                <input type="text" placeholder="{{ __('front.blog.search_placeholder') }}">
                                <button class="search-button"><i class="fal fa-search"></i></button>
                            </form>
                        </div>
                        @include('front.blogs.category')
                        @include('front.blogs.follow')
                        @include('front.blogs.resently')
                        <div class="widget widget-banner-ad">
                            <a href="#">
                                <img src="{{ asset('assets/media/banner/widget-banner.png') }}" alt="banner">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('front.inc.worck_togather')
@endsection

@extends('front.layouts.main_new')
@section('content')
    <div class="breadcrum-area">
        <div class="container">
            <div class="breadcrumb">
                <ul class="list-unstyled">
                    <li><a href="{{ request()->is('preview*') ? route('preview') : route('/') }}">{{ __('front.home') }}</a></li>
                    <li class="active">{{ __('blog') }}</li>
                </ul>
                <h1 class="title h2">{{ __('blog') }}</h1>
            </div>
        </div>
        <ul class="shape-group-8 list-unstyled">
            <li class="shape shape-1 sal-animate" data-sal="slide-right" data-sal-duration="500" data-sal-delay="100">
                <img src="{{ asset('assets/media/others/bubble-9.png') }}" alt="Bubble">
            </li>
            <li class="shape shape-2 sal-animate" data-sal="slide-left" data-sal-duration="500" data-sal-delay="200">
                <img src="{{ asset('assets/media/others/bubble-21.png') }}" alt="Bubble">
            </li>
            <li class="shape shape-3 sal-animate" data-sal="slide-up" data-sal-duration="500" data-sal-delay="300">
                <img src="{{ asset('assets/media/others/line-4.png') }}" alt="Line">
            </li>
        </ul>
    </div>
    <section class="section-wrapper section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="blog-grid-area">
                        @foreach ($data as $item)
                            @php
                                $blogSlug = is_string($item->slug) ? $item->slug : null;
                                $blogUrl = $blogSlug ? route(request()->is('preview*') ? 'preview.blog' : 'blog', $blogSlug) : '#';
                                $blogDateRaw = $item->getRawOriginal('created_at');
                                $blogDate = $blogDateRaw ? \Carbon\Carbon::parse($blogDateRaw)->format('d M Y') : $item->created_at;
                            @endphp
                            <div class="blog-grid blog-style-2 glass-card" data-sal="slide-up" data-sal-duration="800"
                                data-sal-delay="100" style="background: var(--card-bg); border: 1px solid var(--card-border); border-radius: 24px; overflow: hidden; box-shadow: var(--card-shadow); margin-bottom: 30px; transition: transform 0.3s ease, box-shadow 0.3s ease;">
                                <div class="blog-featured-thumb">
                                    <a href="{{ $blogUrl }}">
                                        <img src="{{ asset(Storage::url($item->image)) }}" alt="Blog Thumb" style="width: 100%; height: 280px; object-fit: cover;">
                                    </a>
                                </div>
                                <div class="blog-content" style="padding: 30px;">
                                    <div class="blog-meta" style="margin-bottom: 15px;">
                                        <span class="date" style="color: var(--color-text-sub); font-size: 0.9rem; margin-right: 15px;">{{ $blogDate }}</span>
                                        <span class="author" style="color: var(--color-text-sub); font-size: 0.9rem; margin-right: 15px;">Admin</span>
                                        <span class="comments" style="color: var(--color-text-sub); font-size: 0.9rem;">0 Comments</span>
                                    </div>
                                    <h3 class="title" style="font-family: var(--font-heading); color: var(--color-text-main); margin-bottom: 15px;"><a href="{{ $blogUrl }}" style="color: inherit;">{{ $item->title }}</a>
                                    </h3>
                                    <p style="color: var(--color-text-main); line-height: 1.7; margin-bottom: 20px;">{{ $item->short_description }}</p>
                                    <a href="{{ $blogUrl }}" class="btn-primary-custom">Read More</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="axil-sidebar">
                        <div class="widget widget-search glass-card" style="background: var(--card-bg); border: 1px solid var(--card-border); border-radius: 20px; padding: 25px; margin-bottom: 30px; box-shadow: var(--card-shadow);">
                            <h4 class="widget-title" style="font-family: var(--font-heading); color: var(--color-text-main); margin-bottom: 20px;">Search</h4>
                            <form action="#" class="blog-search">
                                <input type="text" placeholder="Search…" style="background: rgba(255, 255, 255, 0.08); border: 1px solid var(--card-border); color: var(--color-text-main); border-radius: 12px; padding: 12px 16px; width: 100%;">
                                <button class="search-button" style="background: var(--brand-primary); color: white; border: none; padding: 10px 20px; border-radius: 12px; margin-top: 10px; cursor: pointer;"><i class="fal fa-search"></i></button>
                            </form>
                        </div>
                        <div class="widget widget-categories glass-card" style="background: var(--card-bg); border: 1px solid var(--card-border); border-radius: 20px; padding: 25px; box-shadow: var(--card-shadow);">
                            <h4 class="widget-title" style="font-family: var(--font-heading); color: var(--color-text-main); margin-bottom: 20px;">Categories</h4>
                            <ul class="category-list list-unstyled">
                                @foreach ($categories as $category)
                                    <li style="margin-bottom: 10px;"><a href="#" style="color: var(--color-text-sub); transition: color 0.3s;">{{ $category->name }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('front.inc.worck_togather')
@endsection

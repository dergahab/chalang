@extends('front.layouts.main_new')
@section('content')
    @php
        $isPreview = request()->is('preview*');
        $blogRoute = $isPreview ? route('preview.blogs') : route('blogs');
    @endphp

    @push('schema_json')
        {!! App\Helpers\SchemaHelper::article($item) !!}
        {!! App\Helpers\SchemaHelper::breadcrumb([
            __('blog') => $blogRoute,
            $item->title => ''
        ]) !!}
    @endpush

    @include('front.layouts.partials.breadcrumb', [
        'title' => $item->title,
        'items' => [
            __('blog') => $blogRoute,
            $item->title => ''
        ]
    ])
    <section class="section-wrapper section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="blog-details glass-card" style="background: var(--card-bg); border: 1px solid var(--card-border); border-radius: 24px; overflow: hidden; box-shadow: var(--card-shadow);">
                        <div class="post-thumbnail">
                            <img src="{{ asset(Storage::url($item->image)) }}" alt="Blog Thumb" style="width: 100%; height: 400px; object-fit: cover;">
                        </div>
                        <div class="post-content" style="padding: 40px; color: var(--color-text-main); line-height: 1.8;">
                            {!! $item->body !!}
                        </div>
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

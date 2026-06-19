@extends('front.layouts.main_new')
@section('title', 'Case Studies - Chalang')

@section('content')
<section class="section" style="padding-top: 120px;">
    <h1 class="section-title">Case Studies</h1>
    <p class="section-subtitle">Real problemlər, real həllər</p>
    <div class="grid">
        @foreach($case_studies as $case)
            @php
                $caseSlug = is_string($case->slug) ? $case->slug : null;
                $caseUrl = $caseSlug ? route(request()->is('preview*') ? 'preview.case-study.show' : 'case-study.show', $caseSlug) : '#';
            @endphp
            <article class="card portfolio-card glass-card" data-tilt style="background: var(--card-bg); border: 1px solid var(--card-border); border-radius: 24px; overflow: hidden; box-shadow: var(--card-shadow); transition: transform 0.3s ease, box-shadow 0.3s ease;">
                <div class="portfolio-img">
                    @if($case->cover_image)
                        <img src="{{ asset('storage/' . $case->cover_image) }}" alt="{{ $case->title }}" loading="lazy" style="width:100%;height:280px;object-fit:cover;">
                    @endif
                </div>
                <div class="portfolio-content" style="padding: 30px;">
                    <span class="tag" style="background: var(--brand-primary); color: white; padding: 6px 14px; border-radius: 20px; font-size: 0.85rem; font-weight: 600;">{{ $case->category }}</span>
                    <h3 style="font-family: var(--font-heading); color: var(--color-text-main); margin: 15px 0;">{{ $case->title }}</h3>
                    <p style="color: var(--color-text-main); line-height: 1.7;">{{ \Illuminate\Support\Str::limit($case->problem, 100) }}</p>
                    <a href="{{ $caseUrl }}" class="btn-primary-custom" style="margin-top:20px;">Ətraflı</a>
                </div>
            </article>
        @endforeach
    </div>
    <div style="margin-top: 40px; display: flex; justify-content: center;">
        {{ $case_studies->links() }}
    </div>
</section>
@endsection

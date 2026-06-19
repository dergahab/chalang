@extends('front.layouts.main_new')
@section('title', $case_study->title . ' - Case Study')

@section('content')
<section class="section" style="padding-top: 120px;">
    <div style="max-width: 900px; margin: 0 auto;">
        <span class="service-pill" style="background: var(--brand-primary); color: white; padding: 8px 18px; border-radius: 25px; font-size: 0.9rem; font-weight: 600; display: inline-block;">{{ $case_study->category }}</span>
        <h1 style="font-size: 3rem; margin: 20px 0; font-family: var(--font-heading); color: var(--color-text-main);">{{ $case_study->title }}</h1>
        
        @if($case_study->cover_image)
            <img src="{{ asset('storage/' . $case_study->cover_image) }}" alt="{{ $case_study->title }}" style="width: 100%; height: 500px; object-fit: cover; border-radius: 24px; margin-bottom: 40px; box-shadow: var(--card-shadow);">
        @endif

        <div class="card glass-card" style="background: var(--card-bg); border: 1px solid var(--card-border); border-radius: 24px; padding: 40px; margin-bottom: 30px; box-shadow: var(--card-shadow);">
            <h3 style="font-family: var(--font-heading); color: var(--color-text-main); margin-bottom: 15px;">Problem</h3>
            <p style="color: var(--color-text-main); line-height: 1.8;">{{ $case_study->problem }}</p>
        </div>

        <div class="card glass-card" style="background: var(--card-bg); border: 1px solid var(--card-border); border-radius: 24px; padding: 40px; margin-bottom: 30px; box-shadow: var(--card-shadow);">
            <h3 style="font-family: var(--font-heading); color: var(--color-text-main); margin-bottom: 15px;">Həll</h3>
            <p style="color: var(--color-text-main); line-height: 1.8;">{{ $case_study->solution }}</p>
        </div>

        <div class="card glass-card" style="background: var(--card-bg); border: 1px solid var(--card-border); border-left: 4px solid var(--brand-primary); border-radius: 24px; padding: 40px; margin-bottom: 30px; box-shadow: var(--card-shadow);">
            <h3 style="font-family: var(--font-heading); color: var(--brand-primary); margin-bottom: 15px;">Nəticə</h3>
            <p style="color: var(--color-text-main); line-height: 1.8; font-weight: 500;">{{ $case_study->result }}</p>
        </div>

        @if($case_study->services->count() > 0)
            <div class="card" style="padding: 40px; margin-bottom: 30px; background: rgba(var(--brand-primary-rgb), 0.05);">
                <h3>İstifadə olunan xidmətlər</h3>
                <div class="sub-buttons" style="margin-top: 15px;">
                    @foreach($case_study->services as $service)
                        <a href="{{ route(request()->is('preview*') ? 'preview.service.single' : 'service.single', $service->slug) }}" class="service-pill" style="text-decoration: none; display: inline-block; margin-right: 10px; margin-bottom: 10px;">
                            {{ $service->name }}
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        @if($case_study->services->count() > 0)
            <div class="card" style="padding: 40px; margin-bottom: 30px; background: rgba(var(--brand-primary-rgb), 0.05);">
                <h3>İstifadə olunan xidmətlər</h3>
                <div class="sub-buttons" style="margin-top: 15px;">
                    @foreach($case_study->services as $service)
                        <a href="{{ route(request()->is('preview*') ? 'preview.service.single' : 'service.single', $service->slug) }}" class="service-pill" style="text-decoration: none; display: inline-block; margin-right: 10px; margin-bottom: 10px;">
                            {{ $service->name }}
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        @if($case_study->gallery_images)
            <div class="grid" style="margin-top: 40px;">
                @foreach($case_study->gallery_images as $img)
                    <img src="{{ asset('storage/' . $img) }}" style="width: 100%; border-radius: 12px;">
                @endforeach
            </div>
        @endif

        <div style="margin-top: 50px; text-align: center;">
            <a href="{{ route(request()->is('preview*') ? 'preview.case-study.index' : 'case-study.index') }}" class="btn-secondary-custom">← Geri Qayıt</a>
        </div>
    </div>
</section>
@endsection

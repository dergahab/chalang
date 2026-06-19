@php
    $isPreview = request()->is('preview*');
    $pageKey = $isPreview ? 'preview.cookie_page' : 'front.cookie_page';
@endphp

@extends('front.layouts.main_new')

@section('content')
    <section class="page-banner">
        <div class="container">
            <div class="banner-content text-center">
                <h1 class="page-title">{{ __($pageKey . '.title') }}</h1>
                <p class="page-desc">{{ __($pageKey . '.intro') }}</p>
            </div>
        </div>
        <div class="banner-visual">
            <div class="circle-shape shape-1"></div>
            <div class="circle-shape shape-2"></div>
        </div>
    </section>

    <div class="container section-gap">
        <div class="cookie-policy-grid">
            <div class="glass-card cookie-policy-card">
                <h3 class="cookie-policy-title">{{ __($pageKey . '.essential_title') }}</h3>
                <p class="cookie-policy-desc">{{ __($pageKey . '.essential_desc') }}</p>
            </div>
            <div class="glass-card cookie-policy-card">
                <h3 class="cookie-policy-title">{{ __($pageKey . '.analytics_title') }}</h3>
                <p class="cookie-policy-desc">{{ __($pageKey . '.analytics_desc') }}</p>
            </div>
            <div class="glass-card cookie-policy-card">
                <h3 class="cookie-policy-title">{{ __($pageKey . '.marketing_title') }}</h3>
                <p class="cookie-policy-desc">{{ __($pageKey . '.marketing_desc') }}</p>
            </div>
            <div class="glass-card cookie-policy-card">
                <h3 class="cookie-policy-title">{{ __($pageKey . '.preference_title') }}</h3>
                <p class="cookie-policy-desc">{{ __($pageKey . '.preference_desc') }}</p>
            </div>
        </div>

        <div class="glass-card cookie-policy-manage">
            <div>
                <h3 class="cookie-policy-title">{{ __($pageKey . '.manage_title') }}</h3>
                <p class="cookie-policy-desc">{{ __($pageKey . '.manage_desc') }}</p>
            </div>
            <button type="button" class="btn-primary" data-cookie-settings>{{ __($pageKey . '.manage_cta') }}</button>
        </div>
    </div>

    @push('styles')
    <style>
        .page-banner { padding: 120px 0 60px; position: relative; overflow: hidden; }
        .banner-visual .circle-shape { position: absolute; border-radius: 50%; filter: blur(80px); opacity: 0.4; z-index: -1; }
        .shape-1 { top: -10%; left: -10%; width: 380px; height: 380px; background: var(--brand-primary); }
        .shape-2 { bottom: 10%; right: -5%; width: 280px; height: 280px; background: var(--brand-secondary); }

        .cookie-policy-grid {
            display: grid;
            gap: 20px;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            margin-bottom: 28px;
        }

        .cookie-policy-card {
            padding: 22px;
            border-radius: 18px;
        }

        .cookie-policy-title {
            margin-bottom: 6px;
            font-weight: 700;
        }

        .cookie-policy-desc {
            margin: 0;
            color: var(--text-sub, #94a3b8);
        }

        .cookie-policy-manage {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            padding: 24px;
            border-radius: 18px;
            flex-wrap: wrap;
        }
    </style>
    @endpush
@endsection

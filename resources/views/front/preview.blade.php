<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" data-theme="{{ request()->cookie('styleCookieName', 'light') }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('preview.meta_title') }}</title>
    <meta name="description" content="{{ __('preview.meta_description') }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ __('preview.meta_title') }}">
    <meta property="og:description" content="{{ __('preview.meta_description') }}">
    <meta property="og:image" content="{{ asset('assets/img/og-preview.jpg') }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="{{ __('preview.meta_title') }}">
    <meta property="twitter:description" content="{{ __('preview.meta_description') }}">
    <meta property="twitter:image" content="{{ asset('assets/img/og-preview.jpg') }}">

    <!-- Hreflang -->
    <link rel="alternate" hreflang="az" href="{{ url('lang/az') }}" />
    <link rel="alternate" hreflang="en" href="{{ url('lang/en') }}" />
    <link rel="alternate" hreflang="ru" href="{{ url('lang/ru') }}" />
    <link rel="alternate" hreflang="x-default" href="{{ url('lang/az') }}" />

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- VENDOR CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- CUSTOM CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/chalang-core.css?v=' . time()) }}">
    <link rel="stylesheet" href="{{ asset('assets/css/chalang-preview.css?v=' . time()) }}">
    <!-- Dynamic Styles & Global Customization -->
    @include('front.layouts.partials.dynamic-styles')




</head>

<body>
    @php
    $ct = function ($key, $default = '') use ($contentTextMap) {
    return $contentTextMap[$key] ?? $default;
    };

    $toText = function ($value) {
    if ($value instanceof \Illuminate\Support\Collection) {
    $value = $value->all();
    }

    if (is_array($value)) {
    $locale = app()->getLocale();
    if (array_key_exists($locale, $value) && is_string($value[$locale])) {
    $value = $value[$locale];
    } else {
    $value = collect($value)->flatten()->first(function ($item) {
    return is_string($item) && trim($item) !== '';
    }) ?? '';
    }
    }

    if (is_object($value) && method_exists($value, '__toString')) {
    $value = (string) $value;
    }

    if (!is_scalar($value)) {
    return '';
    }

    return trim((string) $value);
    };

    $contentTextMap = is_array($contentTextMap ?? null) ? $contentTextMap : [];
    $ct = function ($key, $fallback = '') use ($contentTextMap) {
    $value = $contentTextMap[$key] ?? null;
    if (is_scalar($value)) {
    $value = trim((string) $value);
    if ($value !== '' && $value !== $key) {
    return $value;
    }
    }
    return $fallback;
    };

    $looksLikeUrl = function ($value) {
    $value = is_string($value) ? trim($value) : '';
    if ($value === '') {
    return false;
    }
    if (filter_var($value, FILTER_VALIDATE_URL)) {
    return true;
    }
    return \Illuminate\Support\Str::startsWith($value, ['/', 'storage/', 'assets/']);
    };

    $normalizeAssetUrl = function ($value) {
    $value = is_string($value) ? trim($value) : '';
    if ($value === '') {
    return '';
    }
    if (filter_var($value, FILTER_VALIDATE_URL)) {
    return $value;
    }
    if (\Illuminate\Support\Str::startsWith($value, '/')) {
    return $value;
    }
    return '/' . ltrim($value, '/');
    };

    $sectionEnabled = function ($sectionId, $default = true) use ($ct) {
    $raw = $ct('preview.sections.' . $sectionId . '.enabled', $default ? '1' : '0');
    $value = is_scalar($raw) ? strtolower(trim((string) $raw)) : '';
    if ($value === '') {
    return $default;
    }
    return !in_array($value, ['0', 'false', 'off', 'no'], true);
    };
    @endphp

    <div id="scroll-progress"></div>

    <div id="preloader-wrapper">
        <div class="curtain-layer"></div>
        <div class="loader-content">
            <svg class="loader-logo" viewBox="0 0 81.87 15.74">
                <path fill="currentColor" d="M25.7,5.95c-.49-.62-1.3-1.22-2.46-1.22-1.96,0-3.33,1.59-3.33,3.31,0,1.84,1.46,3.38,3.34,3.38.87,0,1.75-.34,2.36-1.14h2.11c-.81,1.72-2.38,2.9-4.52,2.9-3.43,0-5.1-2.89-5.1-5.14s1.66-5.07,5.13-5.07c2.03,0,3.72,1.1,4.54,2.98h-2.07Z" />
                <path fill="currentColor" d="M8.88.03C3.91-.37-.27,3.73.01,8.7c.18,3.15,2.14,5.82,4.88,7.04.02,0,.04-.02.03-.03-.22-.3-.35-.68-.35-1.08,0-.87.6-1.6,1.41-1.8.02,0,.02-.03,0-.04-1.88-.92-3.1-2.96-2.8-5.26.27-2.08,2.21-4.04,4.29-4.34,3.14-.44,5.82,1.98,5.82,5.03,0,2-1.16,3.74-2.85,4.56-.02,0-.02.04,0,.04.81.2,1.41.93,1.41,1.8,0,.4-.13.77-.34, 1.08-.01.02,0,.04.03.03,2.88-1.28,4.89-4.16,4.89-7.52C16.44,3.9,13.11.36,8.88.03Z" />
            </svg>
            <div class="loader-progress">0%</div>
        </div>
    </div>

    <div class="project-modal-overlay" id="project-modal-overlay">
        <div class="project-modal">
            <div class="modal-close">✕</div>
            <img src="" class="modal-img" id="modal-img">
            <div class="modal-content">
                <div class="modal-tags" id="modal-tags"></div>
                <h2 class="modal-title" id="modal-title"></h2>
                <p class="modal-desc" id="modal-desc"></p>
                <a href="#" class="kinetic-btn modal-project-link" style="margin-top: 20px; display: inline-flex;">{{ __('preview.modal.view_project') }} <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z" />
                    </svg></a>
            </div>
        </div>
    </div>

    <div class="bg-shape shape-1" data-speed="2"></div>
    <div class="bg-shape shape-2" data-speed="4"></div>
    <div class="bg-shape shape-3" data-speed="1.5"></div>
    <div class="noise-overlay"></div>

    <!-- CUSTOM CURSOR -->
    <div class="cursor-dot"></div>
    <div class="cursor-outline"></div>

    @include('front.layouts.partials.header-preview')

    <div class="search-overlay" id="search-overlay">
        <div class="search-container">
            <div class="search-header">
                <svg class="search-icon" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z" />
                    <path d="M19 1l-1.25 2.75L15 5l2.75 1.25L19 9l1.25-2.75L23 5l-2.75-1.25L19 1z" />
                </svg>
                <input type="text" class="search-input" id="search-input" placeholder="{{ __('preview.search.placeholder') }}" data-lang-placeholder="search_placeholder">
                <button class="search-close" id="search-close">{{ __('preview.search.close') }}</button>
            </div>
            <div class="search-results" id="search-results"></div>
        </div>
    </div>

    <section class="hero">
        @php
        $bannerTitle = $toText($banner?->title ?? '');
        $bannerDesc = $toText($banner?->content ?? '');
        $showreelUrl = __('preview.hero.showreel_url');
        if ($showreelUrl === 'preview.hero.showreel_url') {
        $showreelUrl = '#portfolio';
        }
        @endphp
        <div class="hero-content">
            <div style="margin-bottom: 15px; font-weight: 700; color: var(--brand-secondary); text-transform: uppercase; letter-spacing: 1px;" data-aos="fade-down" data-aos-delay="100">{{ __('preview.hero.kicker') }}</div>
            <h1 data-lang="hero_title" data-aos="fade-right" data-aos-delay="200">{!! $bannerTitle !== '' ? $bannerTitle : __('preview.hero.title') !!}</h1>
            <p data-lang="hero_desc" data-aos="fade-right" data-aos-delay="300">{!! $bannerDesc !== '' ? $bannerDesc : __('preview.hero.desc') !!}</p>
            <div class="btn-group" data-aos="fade-up" data-aos-delay="400">
                <a href="{{ route('preview.contact') }}" class="btn-primary" data-lang="btn_start">{{ __('preview.btn_start') }}</a>
                <a href="{{ route('preview.portfolio') }}" class="btn-secondary" data-lang="btn_works">{{ __('preview.btn_works') }}</a>
                <a href="{{ $showreelUrl }}" class="btn-secondary" style="display: inline-flex; align-items: center; gap: 10px;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M8 5v14l11-7z" />
                    </svg> {{ __('preview.btn_showreel') }}
                </a>
            </div>
        </div>
        <div class="hero-visual">
            <canvas id="hero-canvas"></canvas>
        </div>
    </section>

    <div class="infinite-text-container">
        <div class="infinite-text">
            <h2>{{ $ct('preview.marquee', __('preview.marquee')) }}</h2>
            <h2>{{ $ct('preview.marquee', __('preview.marquee')) }}</h2>
        </div>
    </div>

    <!-- SERVICES -->
    <section class="services-section" id="services">
        <h2 class="section-title" data-lang="sec_services_title">{{ __('preview.sec_services_title') }}</h2>
        <p class="section-subtitle" data-lang="sec_services_sub">{{ __('preview.sec_services_sub') }}</p>
        <style>
            .ticker-horizontal-wrapper {
                overflow: hidden;
                width: 100%;
                mask-image: linear-gradient(90deg, transparent 0%, #000 10%, #000 90%, transparent 100%);
                -webkit-mask-image: linear-gradient(90deg, transparent 0%, #000 10%, #000 90%, transparent 100%);
            }

            .ticker-horizontal-track {
                display: flex;
                gap: 10px;
                width: max-content;
                animation: serviceTicker 60s linear infinite !important;
            }

            .ticker-pill {
                white-space: nowrap;
            }

            @keyframes serviceTicker {
                0% {
                    transform: translateX(0);
                }

                100% {
                    transform: translateX(-50%);
                }
            }
        </style>
        <div class="grid services-grid-2 crease-safe" style="max-width: 1300px; margin: 0 auto;">
            @foreach ($main_services ?? [] as $index => $service)
            @php
            $serviceName = $toText($service->name ?? '');
            if ($serviceName === '') {
            $serviceName = __('preview.fallback.service_title');
            }
            $serviceDesc = $toText($service->description ?? '');
            $serviceSlug = is_string($service->slug ?? null) ? $service->slug : null;
            $childNames = collect($service->childs ?? [])->pluck('name');
            $defaultTickerItems = trans('preview.ticker_default');
            $defaultTickerItems = is_array($defaultTickerItems)
            ? collect($defaultTickerItems)
            : collect([$defaultTickerItems]);
            $tickerItems = $childNames->count()
            ? $childNames->map(fn ($item) => $toText($item))->filter()->values()
            : $defaultTickerItems;
            if (!$tickerItems->count()) {
            $tickerItems = $defaultTickerItems;
            }
            @endphp
            <div class="kinetic-card" style="height: 100%; display: flex; flex-direction: column;" data-tilt data-tilt-max="1" data-tilt-speed="1000" data-tilt-scale="1" data-tilt-perspective="2000" data-aos="fade-up" data-aos-delay="{{ 100 * ($index + 1) }}">
                <div style="flex-grow: 1;">
                    <div class="kinetic-icon">
                        <img src="{{ $service->icon ? asset('storage/' . $service->icon) : asset('assets/media/icon/icon-1.png') }}" alt="{{ $serviceName }}" style="width: 30px; height: 30px; filter: brightness(0) invert(1);">
                    </div>
                    <h3 class="kinetic-title">{{ $serviceName }}</h3>
                    <p class="kinetic-desc">{{ \Illuminate\Support\Str::limit($serviceDesc, 110) }}</p>

                    <!-- Decorative Ticker -->
                    <div class="ticker-horizontal-wrapper" style="margin-top: auto;">
                        <div class="ticker-horizontal-track">
                            @foreach($tickerItems as $item)
                            <span class="ticker-pill">{{ $item }}</span>
                            @endforeach
                            <!-- Duplicates for seamless loop -->
                            @foreach($tickerItems as $item)
                            <span class="ticker-pill">{{ $item }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="kinetic-footer">
                    <a href="{{ $serviceSlug ? route('preview.service.single', $serviceSlug) : '#' }}" class="kinetic-btn">
                        {{ __('preview.btn_detail') }} <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 4 10.59 5.41 16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z" />
                        </svg>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </section>



    <!-- TECH STACK -->
    @if($sectionEnabled('tech_stack'))
    <section class="tech-stack-section" data-aos="fade-up">
        @php
        $techStackSource = $contentTextMap['preview.tech_stack.items'] ?? trans('preview.tech_stack.items');
        $techStackItems = is_array($techStackSource) ? $techStackSource : [];
        $normalizeTech = function ($item) {
        if (is_array($item)) {
        $icon = $item['icon'] ?? $item['emoji'] ?? '';
        $label = $item['label'] ?? $item['name'] ?? '';
        } else {
        $icon = '';
        $label = (string) $item;
        }
        return [
        'icon' => trim((string) $icon),
        'label' => trim((string) $label),
        ];
        };
        @endphp
        <div class="tech-marquee">
            <div class="tech-track">
                @foreach($techStackItems as $item)
                @php
                $tech = $normalizeTech($item);
                $techIcon = $tech['icon'];
                $techIconIsUrl = $looksLikeUrl($techIcon);
                @endphp
                @if($tech['label'] !== '')
                <div class="tech-item">
                    <span class="tech-icon">
                        @if($techIcon !== '')
                        @if($techIconIsUrl)
                        <img src="{{ $normalizeAssetUrl($techIcon) }}" alt="{{ $tech['label'] }}" loading="lazy" onerror="this.style.display='none'">
                        @else
                        {{ $techIcon }}
                        @endif
                        @else
                        *
                        @endif
                    </span>
                    {{ $tech['label'] }}
                </div>
                @endif
                @endforeach
                @foreach($techStackItems as $item)
                @php
                $tech = $normalizeTech($item);
                $techIcon = $tech['icon'];
                $techIconIsUrl = $looksLikeUrl($techIcon);
                @endphp
                @if($tech['label'] !== '')
                <div class="tech-item">
                    <span class="tech-icon">
                        @if($techIcon !== '')
                        @if($techIconIsUrl)
                        <img src="{{ $normalizeAssetUrl($techIcon) }}" alt="{{ $tech['label'] }}" loading="lazy" onerror="this.style.display='none'">
                        @else
                        {{ $techIcon }}
                        @endif
                        @else
                        *
                        @endif
                    </span>
                    {{ $tech['label'] }}
                </div>
                @endif
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- METRICS -->
    @if($sectionEnabled('metrics'))
    <style>
        /* Force section to center its content */
        .metrics-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
            margin: 0 auto;
        }

        .metrics-inner {
            width: min(1200px, 100%);
            margin: 0 auto;
            padding: 0 20px;
            box-sizing: border-box;
        }

        .counter-grid {
            display: flex !important;
            flex-wrap: wrap !important;
            justify-content: center !important;
            align-items: center;
            gap: 24px;
            width: 100%;
            margin: 0 auto !important;
        }

        .counter-card {
            flex: 1 1 260px;
            min-width: 230px;
            max-width: 300px;
            width: 100%;
            box-sizing: border-box;
        }
    </style>
    <section class="metrics-section">
        @php
        $metricYears = $ct('preview.metrics.years_value', __('preview.metrics.years_value'));
        $metricYears = is_numeric($metricYears) ? $metricYears : '10';

        $metricProjects = $ct('preview.metrics.projects_value', __('preview.metrics.projects_value'));
        if (!is_numeric($metricProjects)) {
        $metricProjects = ($portfolios->count() ?? 50);
        }

        $metricSatisfaction = $ct('preview.metrics.satisfaction_value', __('preview.metrics.satisfaction_value'));
        $metricSatisfaction = is_numeric($metricSatisfaction) ? $metricSatisfaction : '100';

        $metricAwards = $ct('preview.metrics.awards_value', __('preview.metrics.awards_value'));
        $metricAwards = is_numeric($metricAwards) ? $metricAwards : '5';
        @endphp
        <div class="metrics-inner crease-safe">
            <div class="counter-grid dual-pane stats-two-col">
                <div class="card counter-card" style="background: var(--card-bg); border: 1px solid var(--card-border); padding: 30px; border-radius: 20px; text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,0.05);" data-aos="zoom-in" data-aos-delay="100">
                    <h3 class="count-number" style="font-size: 3rem; font-weight: 800; color: var(--brand-primary); margin-bottom: 5px;"><span class="counter">{{ $metricYears }}</span>+</h3>
                    <p style="color: var(--text-sub); font-weight: 600;">{{ $ct('preview.metrics.years', __('preview.metrics.years')) }}</p>
                </div>
                <div class="card counter-card" style="background: var(--card-bg); border: 1px solid var(--card-border); padding: 30px; border-radius: 20px; text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
                    <h3 class="count-number" style="font-size: 3rem; font-weight: 800; color: var(--brand-primary); margin-bottom: 5px;"><span class="counter">{{ $metricProjects }}</span>+</h3>
                    <p style="color: var(--text-sub); font-weight: 600;">{{ $ct('preview.metrics.projects', __('preview.metrics.projects')) }}</p>
                </div>
                <div class="card counter-card" style="background: var(--card-bg); border: 1px solid var(--card-border); padding: 30px; border-radius: 20px; text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
                    <h3 class="count-number" style="font-size: 3rem; font-weight: 800; color: var(--brand-primary); margin-bottom: 5px;"><span class="counter">{{ $metricSatisfaction }}</span>%</h3>
                    <p style="color: var(--text-sub); font-weight: 600;">{{ $ct('preview.metrics.satisfaction', __('preview.metrics.satisfaction')) }}</p>
                </div>
                <div class="card counter-card" style="background: var(--card-bg); border: 1px solid var(--card-border); padding: 30px; border-radius: 20px; text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
                    <h3 class="count-number" style="font-size: 3rem; font-weight: 800; color: var(--brand-primary); margin-bottom: 5px;"><span class="counter">{{ $metricAwards }}</span>+</h3>
                    <p style="color: var(--text-sub); font-weight: 600;">{{ $ct('preview.metrics.awards', __('preview.metrics.awards')) }}</p>
                </div>
            </div>
        </div>
    </section>
    @endif

    @if($sectionEnabled('process'))
    <section class="process-section" id="about">
        <!-- New Styles for Process Section -->


        @php
        $processMapUrl = $normalizeAssetUrl($ct(
        'preview.process.map_url',
        'https://upload.wikimedia.org/wikipedia/commons/e/ec/World_map_blank_without_borders.svg'
        ));
        @endphp

        @php
        $mapPointsRaw = $contentTextMap['preview.process.map_points'] ?? '';
        $mapPoints = [];
        $clamp = function ($val) {
        if (!is_numeric($val)) return 0;
        $num = (float) $val;
        if ($num < 0) return 0;
            if ($num> 100) return 100;
            return $num;
            };
            $normalizePoint = function ($item) use ($clamp) {
            $label = '';
            $top = 0;
            $left = 0;
            if (is_array($item)) {
            $label = (string) ($item['label'] ?? '');
            $top = $item['top'] ?? ($item['y'] ?? 0);
            $left = $item['left'] ?? ($item['x'] ?? 0);
            }
            return [
            'label' => $label,
            'top' => $clamp($top),
            'left' => $clamp($left),
            ];
            };

            if (is_array($mapPointsRaw)) {
            foreach ($mapPointsRaw as $item) {
            $mapPoints[] = $normalizePoint($item);
            }
            } elseif (is_string($mapPointsRaw) && trim($mapPointsRaw) !== '') {
            $decoded = json_decode($mapPointsRaw, true);
            if (is_array($decoded)) {
            foreach ($decoded as $item) {
            $mapPoints[] = $normalizePoint($item);
            }
            } elseif (str_contains($mapPointsRaw, '|')) {
            $lines = preg_split('/\r?\n/', $mapPointsRaw);
            foreach ($lines as $line) {
            $parts = array_map('trim', explode('|', $line));
            if (count($parts) >= 3) {
            $mapPoints[] = $normalizePoint([
            'label' => $parts[0],
            'top' => $parts[1],
            'left' => $parts[2],
            ]);
            }
            }
            }
            }

            if (empty($mapPoints)) {
            $mapPoints = [
            ['label' => 'New York', 'top' => 27.4, 'left' => 29.4],
            ['label' => 'Switzerland', 'top' => 24.0, 'left' => 52.3],
            ['label' => 'Baku', 'top' => 27.6, 'left' => 63.9],
            ['label' => 'Dubai', 'top' => 36.0, 'left' => 65.4],
            ];
            }

            $mapStylesRaw = $contentTextMap['preview.process.map_styles'] ?? '';
            $mapStyles = json_decode($mapStylesRaw, true) ?: [];
            $ocean = $mapStyles['ocean'] ?? 'transparent';
            $oceanStyle = $ocean !== 'transparent' ? 'background-color: ' . $ocean . ';' : '';
            $land = $mapStyles['land'] ?? '#111625';
            $stroke = $mapStyles['stroke'] ?? 'rgba(124, 58, 237, 0.16)';
            $strokeWidth = $mapStyles['strokeWidth'] ?? 0.6;
            $opacity = ($mapStyles['opacity'] ?? 75) / 100;
            $glow = !isset($mapStyles['glow']) || $mapStyles['glow'];
            @endphp

            <!-- NEW STRUCTURE: World Map with Hotspots in Background -->
            <style>
            .map-hotspot-updated {
                position: absolute; z-index: 10; display: flex; align-items: center; justify-content: center; transform: translate(-50%, -50%);
            }
            .map-hotspot-updated .hotspot-ping {
                position: absolute; display: inline-flex; height: 16px; width: 16px; border-radius: 50%; opacity: 0.6;
                animation: map-ping 1.5s cubic-bezier(0, 0, 0.2, 1) infinite;
            }
            .map-hotspot-updated .hotspot-core {
                position: relative; display: inline-flex; height: 8px; width: 8px; border-radius: 50%; border: 1px solid rgba(255,255,255,0.4);
            }
            .map-hotspot-updated .hotspot-label {
                position: absolute; left: 16px; font-size: 11px; font-weight: 600; color: rgba(255,255,255,0.85); white-space: nowrap; letter-spacing: 0.05em; text-shadow: 0 2px 5px rgba(0,0,0,0.95); pointer-events: none; user-select: none;
            }
            @keyframes map-ping { 75%, 100% { transform: scale(2); opacity: 0; } }
            </style>
            <div class="process-map-wrapper" style="position: absolute; inset: 0; z-index: 0; pointer-events: none; overflow: hidden; display: flex; align-items: center; justify-content: center;">
                <div class="process-map-container" id="processMapContainer" style="{{ $oceanStyle }} --map-land: {{ $land }}; --map-stroke: {{ $stroke }}; --map-stroke-width: {{ $strokeWidth }}px;">
                    <div id="processMapSvgWrapper" style="width: 100%; height: auto; transition: all 0.5s ease; opacity: {{ $opacity }}; {{ $glow ? 'filter: drop-shadow(0 0 8px '.$stroke.');' : '' }}">
                        <!-- SVG will be injected here -->
                    </div>

                    <!-- Hotspots (Calibration: World Mercator Projection) -->
                    @foreach($mapPoints as $point)
                    @php $hotspotStyle = "top: {$point['top']}%; left: {$point['left']}%;"; @endphp
                    <div class="map-hotspot-updated" style="<?php echo $hotspotStyle; ?>" title="{{ e($point['label']) }}">
                        <span class="hotspot-ping" style="background-color: var(--brand-secondary)"></span>
                        <span class="hotspot-core" style="background-color: var(--brand-secondary); box-shadow: 0 0 8px var(--brand-secondary);"></span>
                        <span class="hotspot-label">{{ e($point['label']) }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <script>
                // Fetch and inject SVG
                fetch('{{ $processMapUrl }}')
                    .then(res => res.text())
                    .then(svg => {
                        document.getElementById('processMapSvgWrapper').innerHTML = svg;
                    });

                // JS Logic: Strict Aspect Ratio Preservation
                function fitMap() {
                    const wrapper = document.querySelector('.process-map-wrapper');
                    const container = document.getElementById('processMapContainer');

                    if (!wrapper || !container) return;

                    const wrapW = wrapper.clientWidth;
                    const wrapH = wrapper.clientHeight;
                    const wrapRatio = wrapW / wrapH;

                    const natW = 1600;
                    const natH = 800;
                    const imgRatio = natW / natH;

                    if (wrapRatio > imgRatio) {
                        container.style.width = wrapW + 'px';
                        container.style.height = (wrapW / imgRatio) + 'px';
                    } else {
                        container.style.width = (wrapH * imgRatio) + 'px';
                        container.style.height = wrapH + 'px';
                    }
                }

                window.addEventListener('resize', fitMap);
                fitMap();
                if(window.ResizeObserver) {
                    new ResizeObserver(fitMap).observe(document.querySelector('.process-map-wrapper'));
                }
                window.addEventListener('load', fitMap);
                // Run on init
                document.addEventListener('DOMContentLoaded', () => {
                    const img = document.getElementById('processMapImg');
                    if (img) {
                        if (img.complete) fitMap();
                        else img.onload = fitMap;
                    }
                });
            </script>

            <h2 class="section-title reveal-text" data-lang="sec_process_title"><span>{{ __('preview.sec_process_title') }}</span></h2>
            <p class="section-subtitle" data-lang="sec_process_sub" data-aos="fade-up">{{ __('preview.sec_process_sub') }}</p>

            @php
            $stepItems = ($steps ?? collect())->values();
            $maxSteps = 4;
            @endphp

            <!-- Navigation Steps -->
            <div class="process-container crease-safe dual-pane stats-two-col" data-aos="fade-up" data-aos-delay="200">
                @for ($index = 0; $index < $maxSteps; $index++)
                    @php
                    $stepIndex=$index + 1;
                    $step=$stepItems->get($index);
                    $stepTitle = $step ? $toText($step->title ?? '') : '';
                    $stepDesc = $step ? $toText($step->step ?? '') : '';
                    $fallbackTitle = __('preview.process.steps.step_' . $stepIndex . '.title');
                    $fallbackDesc = __('preview.process.steps.step_' . $stepIndex . '.desc');
                    @endphp
                    <div class="process-step {{ $index === 0 ? 'active' : '' }}" onclick="switchProcessStep(<?php echo $stepIndex; ?>)" id="p-step-{{ $stepIndex }}">
                        <div class="step-circle">{{ str_pad((string) $stepIndex, 2, '0', STR_PAD_LEFT) }}</div>
                        <div class="step-title">{{ $stepTitle !== '' ? $stepTitle : $fallbackTitle }}</div>
                        <div class="step-desc">{{ $stepDesc !== '' ? $stepDesc : $fallbackDesc }}</div>
                    </div>
                    @endfor
            </div>

            <!-- Details Cards -->
            <div class="process-details-container crease-safe dual-pane stats-two-col">
                @for ($index = 0; $index < $maxSteps; $index++)
                    @php
                    $stepIndex=$index + 1;
                    $step=$stepItems->get($index);
                    $detailTitleOverride = $ct('preview.process.details.step_' . $stepIndex . '.title', '');
                    $detailTextOverride = $ct('preview.process.details.step_' . $stepIndex . '.text', '');
                    $detailTitleFallback = __('preview.process.details.step_' . $stepIndex . '.title');
                    $detailTextFallback = __('preview.process.details.step_' . $stepIndex . '.text');
                    $detailTitle = $detailTitleOverride !== '' ? $detailTitleOverride : ($step ? $toText($step->title ?? '') : '');
                    if ($detailTitle === '') $detailTitle = $detailTitleFallback;

                    $detailText = $detailTextOverride !== '' ? $detailTextOverride : ($step ? $toText($step->description ?? '') : '');
                    if ($detailText === '') $detailText = $detailTextFallback;

                    $detailItems = trans('preview.process.details.step_' . $stepIndex . '.items');
                    $detailItems = is_array($detailItems) ? $detailItems : [];
                    @endphp
                    <div class="process-detail-item {{ $index === 0 ? 'active' : '' }}" id="p-detail-{{ $stepIndex }}">
                        <h4>{{ $detailTitle }}</h4>
                        <p>{!! $detailText !!}</p>
                        @if(count($detailItems))
                        <ul class="process-list">
                            @foreach($detailItems as $k => $item)
                            @if($stepIndex === 4 && $loop->last)
                            {{-- Skip the last item for Step 4 (it will be a button) --}}
                            @else
                            <li>
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                </svg>
                                {{ $item }}
                            </li>
                            @endif
                            @endforeach
                        </ul>
                        @endif

                        @if($stepIndex === 4)
                        <a href="#contact" class="process-cta-btn">
                            {{ __('preview.btn_start') }} <svg width="20" height="20" viewBox="0 0 24 24" fill="none" class="ms-1">
                                <path d="M5 12h14M12 5l7 7-7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </a>
                        @endif
                    </div>
                    @endfor
                    <script>
                        const processMaxSteps = <?php echo $maxSteps; ?>;








                        let currentStep = 1;

                        function switchProcessStep(id) {
                            // Reset Timer on manual click
                            if (processInterval) {
                                clearInterval(processInterval);
                                startProcessRotation(); // Restart with full delay
                            }

                            currentStep = id;
                            updateProcessUI(id);
                        }

                        function updateProcessUI(id) {
                            // Remove Active from all
                            document.querySelectorAll('.process-step').forEach(el => el.classList.remove('active'));
                            document.querySelectorAll('.process-detail-item').forEach(el => el.classList.remove('active'));

                            // Add Active to target
                            const step = document.querySelector('#p-step-' + id);
                            const detail = document.querySelector('#p-detail-' + id);

                            if (step) step.classList.add('active');
                            if (detail) detail.classList.add('active');
                        }

                        function startProcessRotation() {
                            processInterval = setInterval(() => {
                                currentStep++;
                                if (currentStep > processMaxSteps) currentStep = 1;
                                updateProcessUI(currentStep);
                            }, 8000); // 8 Seconds per step (Slower)
                        }

                        // Start on Load
                        document.addEventListener('DOMContentLoaded', () => {
                            startProcessRotation();

                            // Pause on hover
                            const container = document.querySelector('.process-section');
                            if (container) {
                                container.addEventListener('mouseenter', () => clearInterval(processInterval));
                                container.addEventListener('mouseleave', () => startProcessRotation());
                            }
                        });
                    </script>
    </section>
    @endif

    <!-- PARTNERS -->
    @if(($partners ?? collect())->count())
    <section class="partners-section">
        <div class="partners-marquee">
            <div class="partners-track">
                @foreach($partners as $partner)
                <span class="partner-logo">{{ $toText($partner->name ?? '') }}</span>
                @endforeach
                @foreach($partners as $partner)
                <span class="partner-logo">{{ $toText($partner->name ?? '') }}</span>
                @endforeach
            </div>
        </div>
    </section>
    @else
    <section class="partners-section">
        <div class="partners-marquee">
            <div class="partners-track">
                <span class="partner-logo">GOOGLE</span><span class="partner-logo">SPOTIFY</span><span class="partner-logo">AIRBNB</span><span class="partner-logo">UBER</span><span class="partner-logo">NETFLIX</span><span class="partner-logo">AMAZON</span><span class="partner-logo">ADOBE</span><span class="partner-logo">SLACK</span>
                <span class="partner-logo">GOOGLE</span><span class="partner-logo">SPOTIFY</span><span class="partner-logo">AIRBNB</span><span class="partner-logo">UBER</span><span class="partner-logo">NETFLIX</span><span class="partner-logo">AMAZON</span><span class="partner-logo">ADOBE</span><span class="partner-logo">SLACK</span>
            </div>
        </div>
    </section>
    @endif

    <!-- NEW: DIGITAL ARCHITECTS -->
    <!-- NEW: HALL OF FAME (FIXED STYLE) -->
    <section class="team-section">
        <h2 class="section-title reveal-text" data-lang="sec_team_title"><span>{{ __('preview.sec_team_title') }}</span></h2>
        <p class="section-subtitle" data-lang="sec_team_sub" data-aos="fade-right" data-aos-delay="100">{{ __('preview.sec_team_sub') }}</p>
        <div class="team-grid">
            @if(($team_members ?? collect())->count())
            @foreach(($team_members ?? collect())->take(4) as $index => $member)
            @php
            $memberImage = $member->image ? asset('storage/' . $member->image) : null;
            $memberName = $toText($member->name ?? '');
            if ($memberName === '') {
            $memberName = __('preview.team.fallback.member');
            }
            $memberPosition = $toText($member->position ?? '');
            $specialtySource = $member->specialties ?? '';
            $specialties = collect(is_array($specialtySource) ? $specialtySource : explode(',', $toText($specialtySource)))
            ->map(fn ($item) => trim($toText($item)))
            ->filter()
            ->take(3);
            @endphp
            <div class="team-card" data-aos="flip-left" data-aos-delay="{{ 100 * ($index + 1) }}">
                <div class="team-img-wrapper">
                    @if($memberImage)
                    <img src="{{ $memberImage }}" alt="{{ $memberName }}" class="team-img">
                    <img src="{{ $memberImage }}" alt="{{ $memberName }}" class="team-img img-creative">
                    @endif
                </div>
                <div class="team-info">
                    <h3 class="team-name">{{ $memberName }}</h3>
                    <span class="team-role">{{ $memberPosition }}</span>
                    @if($specialties->count())
                    <div class="team-powers">
                        @foreach($specialties as $spec)
                        <span class="power-tag">{{ $spec }}</span>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
            @else
            <!-- Mock Team Members if empty -->
            <div class="team-card">
                <div class="team-img-wrapper" style="background: var(--card-border); display: flex; align-items: center; justify-content: center;">
                    <span style="font-size: 3rem;">👨‍💻</span>
                </div>
                <div class="team-info">
                    <h3 class="team-name">{{ __('preview.team.fallback.title') }}</h3>
                    <span class="team-role">{{ __('preview.team.fallback.subtitle') }}</span>
                    <div class="team-powers">
                        @foreach(trans('preview.team.fallback.tags') as $tag)
                        <span class="power-tag">{{ $tag }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>
    </section>
    @php
    $estServicesSource = $contentTextMap['preview.estimator.services'] ?? trans('preview.estimator.services');
    $estServices = is_array($estServicesSource) ? $estServicesSource : [];
    if (!$estServices) {
    $estServices = [
    ['label' => __('preview.estimator.service_website'), 'value' => 2000],
    ['label' => __('preview.estimator.service_mobile'), 'value' => 3500],
    ['label' => __('preview.estimator.service_branding'), 'value' => 1500],
    ['label' => __('preview.estimator.service_smm'), 'value' => 1000],
    ];
    }

    $estSizesSource = $contentTextMap['preview.estimator.sizes'] ?? trans('preview.estimator.sizes');
    $estSizes = is_array($estSizesSource) ? $estSizesSource : [];
    if (!$estSizes) {
    $estSizes = [
    ['label' => __('preview.estimator.size_small'), 'value' => 1],
    ['label' => __('preview.estimator.size_medium'), 'value' => 1.5, 'default' => true],
    ['label' => __('preview.estimator.size_large'), 'value' => 2.5],
    ];
    }

    $normalizeEstimator = function ($item) {
    if (is_array($item)) {
    return [
    'label' => trim((string) ($item['label'] ?? $item['name'] ?? '')),
    'value' => $item['value'] ?? $item['val'] ?? null,
    'default' => !empty($item['default']),
    ];
    }
    return [
    'label' => trim((string) $item),
    'value' => null,
    'default' => false,
    ];
    };

    $estServices = array_map($normalizeEstimator, $estServices);
    $estSizes = array_map($normalizeEstimator, $estSizes);

    $defaultServiceIndex = 0;
    foreach ($estServices as $index => $item) {
    if ($item['default']) {
    $defaultServiceIndex = $index;
    break;
    }
    }

    $defaultSizeIndex = 0;
    foreach ($estSizes as $index => $item) {
    if ($item['default']) {
    $defaultSizeIndex = $index;
    break;
    }
    }
    @endphp
    <!-- NEW: SMART ESTIMATOR -->
    @if($sectionEnabled('estimator'))
    <section class="estimator-section"
        data-urgency-slow="{{ $ct('preview.estimator.urgency_slow', __('preview.estimator.urgency_slow')) }}"
        data-urgency-normal="{{ $ct('preview.estimator.urgency_normal', __('preview.estimator.urgency_normal')) }}"
        data-urgency-urgent="{{ $ct('preview.estimator.urgency_urgent', __('preview.estimator.urgency_urgent')) }}"
        data-exchange-rate="1.7"
        data-est-select-service="{{ $ct('preview.estimator.select_service', __('preview.estimator.select_service', ['defaultValue' => 'Select a service'])) }}">










        <h2 class="section-title reveal-text" data-lang="est_title"><span>{{ __('preview.est_title') }}</span></h2>
        <p class="section-subtitle" data-lang="est_sub" data-aos="fade-up" data-aos-delay="100">{{ __('preview.est_sub') }}</p>

        <div class="estimator-container" data-aos="zoom-in-up" data-aos-delay="200">
            <div class="estimator-grid">
                <div class="estimator-controls">
                    <div class="est-header-row" style="display:flex; justify-content:space-between; align-items:center; margin-bottom:15px;">
                        <span class="est-label" style="margin:0;">{{ __('preview.estimator.service_type') }}</span>
                        <!-- Currency Toggle -->
                        <div class="currency-toggle-wrapper">
                            <span class="curr-label active" id="lbl-usd">USD</span>
                            <label class="est-switch">
                                <input type="checkbox" id="est-currency-toggle">
                                <span class="est-slider round"></span>
                            </label>
                            <span class="curr-label" id="lbl-azn">AZN</span>
                        </div>
                    </div>
                    <div class="service-options" id="est-services">
                        @foreach($estServices as $index => $item)
                        @php $service = $normalizeEstimator($item); @endphp
                        @if($service['label'] !== '')
                        <div class="service-opt {{ $index === $defaultServiceIndex ? 'selected' : '' }}" data-val="{{ $service['value'] !== null ? $service['value'] : 0 }}" tabindex="0" role="button">{{ $service['label'] }}</div>
                        @endif
                        @endforeach
                    </div>

                    <span class="est-label">{{ __('preview.estimator.urgency') }}</span>
                    <p style="font-size:0.85rem; opacity:0.7; margin-top:-5px; margin-bottom:10px;">{{ __('preview.estimator.urgency_hint') }}</p>
                    <input type="range" min="1" max="3" value="2" id="est-time">
                    <div style="display:flex; justify-content:space-between; font-size:0.8rem; opacity:0.8; margin-top:5px; padding: 0 10px;">
                        <span style="transform: translateX(-10%);">{{ __('preview.estimator.urgency_slow') }}</span>
                        <span>{{ __('preview.estimator.urgency_normal') }}</span>
                        <span style="transform: translateX(10%);">{{ __('preview.estimator.urgency_urgent') }}</span>
                    </div>

                    <span class="est-label">{{ __('preview.estimator.size') }}</span>
                    <div class="service-options" id="est-size">
                        @foreach($estSizes as $index => $item)
                        @php $size = $normalizeEstimator($item); @endphp
                        @if($size['label'] !== '')
                        <div class="service-opt {{ $index === $defaultSizeIndex ? 'selected' : '' }}" data-val="{{ $size['value'] !== null ? $size['value'] : 0 }}" tabindex="0" role="button">{{ $size['label'] }}</div>
                        @endif
                        @endforeach
                    </div>
                </div>
                <div class="est-result-box">
                    <div class="est-result-content">
                        <span class="est-subtitle">{{ __('preview.estimator.investment') }}</span>
                        <div class="est-action-row">
                            <div class="est-price" id="est-price">{{ __('preview.estimator.range') }}</div>
                            <button type="button" id="est-cta" class="kinetic-btn">{{ __('preview.estimator.cta') }}</button>
                        </div>
                        <div class="est-disclaimer">
                            {{ __('preview.estimator.disclaimer') }}
                        </div>
                    </div>
                </div>
            </div>
    </section>
    @endif


    <section class="section" id="portfolio">
        <h2 class="section-title">{{ __('preview.portfolio.title') }}</h2>
        <p class="section-subtitle">{{ __('preview.portfolio.subtitle') }}</p>
        @if(($portfolios ?? collect())->count())
        <div class="portfolio-grid">
            @foreach(($portfolios ?? collect())->take(6) as $portfolio)
            @php
            $portfolioImage = $portfolio->image ? asset('storage/' . $portfolio->image) : null;
            $portfolioTitle = $toText($portfolio->title ?? '');
            $portfolioDescSource = $portfolio->short_description ?? $portfolio->description ?? $portfolioTitle;
            $portfolioDesc = \Illuminate\Support\Str::limit(strip_tags($toText($portfolioDescSource)), 120);
            $portfolioTags = collect($portfolio->pcategories ?? [])->take(2);
            $portfolioSlug = is_string($portfolio->slug ?? null) ? $portfolio->slug : null;
            @endphp
            <article class="project-card" data-tilt data-title="{{ $portfolioTitle }}" data-desc="{{ $portfolioDesc }}" data-img="{{ $portfolioImage }}" data-url="{{ $portfolioSlug ? route('preview.portfolio.single', $portfolioSlug) : '#' }}" data-aos="{{ $loop->index % 2 == 0 ? 'fade-right' : 'fade-left' }}" data-aos-delay="100">
                @if($portfolioImage)
                <img src="{{ $portfolioImage }}" alt="{{ $portfolioTitle }}" class="project-img">
                @endif
                <div class="project-overlay-gradient"></div>
                <div class="project-info">
                    <div class="project-tags">
                        @forelse($portfolioTags as $tag)
                        <span class="p-tag">{{ $toText($tag->name ?? '') }}</span>
                        @empty
                        <span class="p-tag">{{ __('preview.portfolio.tag') }}</span>
                        @endforelse
                    </div>
                    <h3 class="project-title">{{ $portfolioTitle }}</h3>
                    <p class="project-desc">{{ $portfolioDesc }}</p>
                    <a href="{{ $portfolioSlug ? route('preview.portfolio.single', $portfolioSlug) : '#' }}" class="project-link">{{ __('preview.portfolio.view') }} <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z" />
                        </svg></a>
                </div>
            </article>
            @endforeach
        </div>
        <div class="portfolio-footer">
            <a href="{{ route('preview.portfolio') }}" class="kinetic-btn" data-lang="btn_view_all">{{ __('preview.portfolio.btn_view_all') }} <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z" />
                </svg></a>
        </div>
        @else
        <div class="portfolio-grid">
            @for ($i = 0; $i < 3; $i++)
                <article class="project-card" style="background: linear-gradient(135deg, rgba(var(--brand-primary-rgb), 0.2), rgba(var(--brand-secondary-rgb), 0.15)); height: 320px;">
                <div class="project-overlay-gradient"></div>
                <div class="project-info" style="position: absolute;">
                    <div class="project-tags">
                        <span class="p-tag">{{ __('preview.portfolio.placeholder_tag') }}</span>
                    </div>
                    <h3 class="project-title">{{ __('preview.portfolio.placeholder_title') }}</h3>
                    <p class="project-desc">{{ __('preview.portfolio.placeholder_desc') }}</p>
                </div>
                </article>
                @endfor
        </div>
        @endif
    </section>

    <!-- NEW: HALL OF FAME (FIXED STYLE) -->
    @if($sectionEnabled('fame'))
    <section class="hall-of-fame-section">
        <h2 class="section-title">{{ __('preview.fame.title') }}</h2>
        <div class="fame-grid">
            @php
            $fameSource = $contentTextMap['preview.fame.items'] ?? [];
            $fameItems = is_array($fameSource) ? $fameSource : [];
            $fameList = [];

            foreach ($fameItems as $item) {
            $label = '';
            $url = '';

            if (is_array($item)) {
            $label = trim((string) ($item['label'] ?? $item['name'] ?? ''));
            $url = trim((string) ($item['url'] ?? $item['logo'] ?? $item['icon'] ?? ''));
            } else {
            $raw = trim((string) $item);
            if ($raw !== '') {
            $parts = preg_split('/\\s*\\|\\s*/', $raw, 2);
            if (count($parts) === 2) {
            $first = trim($parts[0]);
            $second = trim($parts[1]);
            if ($looksLikeUrl($first)) {
            $url = $first;
            $label = $second;
            } elseif ($looksLikeUrl($second)) {
            $url = $second;
            $label = $first;
            } else {
            $label = $raw;
            }
            } else {
            if ($looksLikeUrl($raw)) {
            $url = $raw;
            } else {
            $label = $raw;
            }
            }
            }
            }

            if ($label !== '' || $url !== '') {
            $fameList[] = [
            'label' => $label,
            'url' => $url,
            ];
            }
            }
            @endphp

            @if(count($fameList))
            @foreach($fameList as $fame)
            <div class="fame-item">
                @if($fame['url'] !== '')
                <img class="fame-logo" src="{{ $normalizeAssetUrl($fame['url']) }}" alt="{{ $fame['label'] !== '' ? $fame['label'] : 'Logo' }}" loading="lazy" onerror="this.style.display='none'">
                @if($fame['label'] !== '')
                <span class="fame-label">{{ $fame['label'] }}</span>
                @endif
                @else
                {{ $fame['label'] }}
                @endif
            </div>
            @endforeach
            @elseif(($case_studies ?? collect())->count())
            @foreach(($case_studies ?? collect())->take(6) as $caseStudy)
            <div class="fame-item">{{ $toText($caseStudy->title ?? '') }}</div>
            @endforeach
            @else
            <div class="fame-item">{{ __('preview.fame.item_1') }}</div>
            <div class="fame-item">{{ __('preview.fame.item_2') }}</div>
            <div class="fame-item">{{ __('preview.fame.item_3') }}</div>
            <div class="fame-item">{{ __('preview.fame.item_4') }}</div>
            @endif
        </div>
    </section>
    @endif

    <section class="testimonials-section">
        <h2 class="section-title" style="margin-bottom: 40px;">{{ __('preview.testimonials.title') }}</h2>
        @if(($testimonials ?? collect())->count())
        <div class="testimonial-slider" id="testimonial-slider">
            @foreach(($testimonials ?? collect())->take(6) as $testimonial)
            @php
            $testimonialText = \Illuminate\Support\Str::limit(strip_tags($toText($testimonial->content ?? '')), 160);
            $testimonialImage = $testimonial->image ? asset('storage/' . $testimonial->image) : null;
            $testimonialName = $toText($testimonial->name ?? '');
            $testimonialPosition = $toText($testimonial->position ?? '');
            @endphp
            <div class="testimonial-card">
                <div class="testimonial-text">"{{ $testimonialText }}"</div>
                <div class="testimonial-author">
                    <div class="author-avatar" @if($testimonialImage) style="background-image: url('{{ $testimonialImage }}'); background-size: cover; background-position: center;" @endif></div>
                    <div class="author-info">
                        <h5>{{ $testimonialName }}</h5>
                        <span>{{ $testimonialPosition }}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="testimonials-track" id="testimonials-track"></div>
        @endif
    </section>

    <!-- FAQ SECTION -->
    <section class="faq-section" id="faq">
        <h2 class="section-title reveal-text"><span>{{ __('preview.faq.title') }}</span></h2>
        @if(($faqs ?? collect())->count())
        @foreach(($faqs ?? collect())->take(6) as $index => $faq)
        @php
        $faqQuestion = $toText($faq->question ?? '');
        $faqAnswer = \Illuminate\Support\Str::limit(strip_tags($toText($faq->answer ?? '')), 300);
        @endphp
        <div class="faq-item" data-aos="fade-up" data-aos-delay="{{ 50 * ($index + 1) }}">
            <div class="faq-question">{{ $faqQuestion }} <span class="faq-icon"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg></span></div>
            <div class="faq-answer">{{ $faqAnswer }}</div>
        </div>
        @endforeach
        @else
        <div class="faq-item">
            <div class="faq-question">{{ __('preview.faq.fallback.item_1.question') }} <span class="faq-icon"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg></span></div>
            <div class="faq-answer">{{ __('preview.faq.fallback.item_1.answer') }}</div>
        </div>
        <div class="faq-item">
            <div class="faq-question">{{ __('preview.faq.fallback.item_2.question') }} <span class="faq-icon"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg></span></div>
            <div class="faq-answer">{{ __('preview.faq.fallback.item_2.answer') }}</div>
        </div>
        <div class="faq-item">
            <div class="faq-question">{{ __('preview.faq.fallback.item_3.question') }} <span class="faq-icon"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg></span></div>
            <div class="faq-answer">{{ __('preview.faq.fallback.item_3.answer') }}</div>
        </div>
        @endif
    </section>

    <section class="blog-section" id="blog">
        <h2 class="section-title reveal-text"><span>{{ __('preview.blog.title') }}</span></h2>
        @php
        $blogItems = ($blogs ?? collect())->take(3);
        $blogDirections = ['fade-right', 'fade-up', 'fade-left'];
        $fallbackImages = [
        'https://images.unsplash.com/photo-1620712943543-bcc4688e7485?auto=format&fit=crop&w=500&q=60',
        'https://images.unsplash.com/photo-1542744173-8e7e53415bb0?auto=format&fit=crop&w=500&q=60',
        'https://images.unsplash.com/photo-1531403009284-440f080d1e12?auto=format&fit=crop&w=500&q=60',
        ];
        @endphp
        <div class="blog-slider">
            @if($blogItems->count())
            @foreach($blogItems as $index => $blog)
            @php
            $blogTitle = $toText($blog->title ?? '');
            $blogImage = $blog->image ? asset('storage/' . $blog->image) : ($fallbackImages[$index % count($fallbackImages)] ?? null);
            $blogLink = $blog->slug ? route('preview.blog', $blog->slug) : '#';
            $blogLabel = $toText($blog->created_at ?? '') ?: __('preview.blog.default_label');
            $direction = $blogDirections[$index % count($blogDirections)];
            @endphp
            <div class="blog-card" data-aos="{{ $direction }}" data-aos-delay="{{ 200 + ($index * 100) }}">
                @if($blogImage)
                <img src="{{ $blogImage }}" class="blog-img" alt="{{ $blogTitle }}">
                @endif
                <div class="blog-content">
                    <span class="blog-date">{{ $blogLabel }}</span>
                    <h3 class="blog-title">{{ $blogTitle }}</h3>
                    <a href="{{ $blogLink }}" class="blog-link">{{ __('preview.blog.read_more') }} ></a>
                </div>
            </div>
            @endforeach
            @else
            <!-- 1. LEFT (fade-right) -->
            <div class="blog-card" data-aos="fade-right" data-aos-delay="200">
                <img src="https://images.unsplash.com/photo-1620712943543-bcc4688e7485?auto=format&fit=crop&w=500&q=60" class="blog-img">
                <div class="blog-content"><span class="blog-date">{{ __('preview.blog.cards.card_1.category') }}</span>
                    <h3 class="blog-title">{{ __('preview.blog.cards.card_1.title') }}</h3><a href="#" class="blog-link">{{ __('preview.blog.read_more') }} ></a>
                </div>
            </div>
            <!-- 2. UP (fade-up) -->
            <div class="blog-card" data-aos="fade-up" data-aos-delay="300">
                <img src="https://images.unsplash.com/photo-1542744173-8e7e53415bb0?auto=format&fit=crop&w=500&q=60" class="blog-img">
                <div class="blog-content"><span class="blog-date">{{ __('preview.blog.cards.card_2.category') }}</span>
                    <h3 class="blog-title">{{ __('preview.blog.cards.card_2.title') }}</h3><a href="#" class="blog-link">{{ __('preview.blog.read_more') }} ></a>
                </div>
            </div>
            <!-- 3. RIGHT (fade-left) -->
            <div class="blog-card" data-aos="fade-left" data-aos-delay="400">
                <img src="https://images.unsplash.com/photo-1531403009284-440f080d1e12?auto=format&fit=crop&w=500&q=60" class="blog-img">
                <div class="blog-content"><span class="blog-date">{{ __('preview.blog.cards.card_3.category') }}</span>
                    <h3 class="blog-title">{{ __('preview.blog.cards.card_3.title') }}</h3><a href="#" class="blog-link">{{ __('preview.blog.read_more') }} ></a>
                </div>
            </div>
            @endif
        </div>
    </section>

    <!-- LEAD MAGNET (AUDIT) -->
    @if($sectionEnabled('lead_magnet'))
    <section class="lead-magnet-section" style="position: relative; overflow: hidden;">




        <div id="audit-scan-overlay" class="scan-overlay">
            <div class="scan-content">
                <div class="scan-radar"></div>
                <div class="success-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                    </svg>
                </div>
                <!-- Initial text empty or default -->
                <div class="scan-text" style="color: #fff; font-size: 14px; font-weight: 500;">
                    Analyzing website...
                </div>
            </div>
        </div>



        <h2 class="magnet-title" data-lang="magnet_title">{{ $ct('preview.magnet_title', __('preview.magnet_title')) }}</h2>
        <p class="magnet-desc" data-lang="magnet_desc">{{ $ct('preview.magnet_desc', __('preview.magnet_desc')) }}</p>
        <form class="magnet-form" id="audit-form" method="POST" action="{{ route('subscribe') }}" onsubmit="event.preventDefault(); return false;">
            @csrf
            <input type="url" class="magnet-input" name="website" placeholder="{{ __('preview.magnet_url') }}" required>
            <input type="email" class="magnet-input" name="mail" placeholder="{{ __('preview.ph_email') }}" data-lang-placeholder="ph_email" required>
            <button type="button" class="magnet-btn" onclick="startWebsiteAudit(this)" data-lang="btn_audit">{{ __('preview.btn_audit') }}</button>
        </form>
    </section>
    @endif

    <section class="contact-section" id="contact">
        <h2 class="section-title" data-lang="sec_contact_title">{{ __('preview.sec_contact_title') }}</h2>
        <form class="contact-form" method="POST" action="{{ route('contact.submit') }}">
            @csrf
            <div class="form-group"><input type="text" class="form-input" name="full_name" placeholder="{{ __('preview.ph_name') }}" data-lang-placeholder="ph_name" required></div>
            <div class="form-group"><input type="email" class="form-input" name="email" placeholder="{{ __('preview.ph_email') }}" data-lang-placeholder="ph_email" required></div>
            <div class="form-group"><input type="tel" class="form-input" name="phone" placeholder="{{ __('preview.ph_phone') }}" data-lang-placeholder="ph_phone" required></div>
            <div class="form-group full"><textarea class="form-input" name="message" placeholder="{{ __('preview.ph_msg') }}" data-lang-placeholder="ph_msg" required></textarea></div>
            <input type="hidden" name="type" value="preview">
            <button type="submit" class="form-btn" data-lang="btn_submit">{{ __('preview.btn_submit') }}</button>
        </form>
    </section>

    <div class="quote-modal-overlay" id="quote-modal-overlay" aria-hidden="true" style="display: none;">
        <div id="quote-modal" class="quote-modal" role="dialog" aria-modal="true">
            <div class="quote-modal-content premium-modal">
                <span class="close-modal" id="quote-modal-close">&times;</span>
                <div class="premium-modal-grid">
                    <!-- LEFT: RECEIPT SUMMARY -->
                    <div class="modal-receipt">
                        <div class="receipt-header">
                            <div class="receipt-brand">CHALANG</div>
                            <div class="receipt-title">{{ __('preview.modal.project_summary') }}</div>
                        </div>
                        <div class="receipt-dash-line"></div>
                        <div class="receipt-body">
                            <div class="receipt-row" data-summary-row="service">
                                <div class="receipt-label">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layers">
                                        <polygon points="12 2 2 7 12 12 22 7 12 2"></polygon>
                                        <polyline points="2 17 12 22 22 17"></polyline>
                                        <polyline points="2 12 12 17 22 12"></polyline>
                                    </svg>
                                    {{ __('preview.modal.service_type') }}
                                </div>
                                <div class="receipt-value" data-summary-value="service">-</div>
                            </div>
                            <div class="receipt-row" data-summary-row="size">
                                <div class="receipt-label">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-maximize">
                                        <path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"></path>
                                    </svg>
                                    {{ __('preview.modal.volume') }}
                                </div>
                                <div class="receipt-value" data-summary-value="size">-</div>
                            </div>
                            <div class="receipt-row" data-summary-row="urgency">
                                <div class="receipt-label">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <polyline points="12 6 12 12 16 14"></polyline>
                                    </svg>
                                    {{ __('preview.modal.duration') }}
                                </div>
                                <div class="receipt-value" data-summary-value="urgency">-</div>
                            </div>
                        </div>
                        <div class="receipt-dash-line"></div>
                        <div class="receipt-total" data-summary-row="estimate">
                            <div class="receipt-label">{{ __('preview.modal.investment') }}</div>
                            <div class="receipt-value price-tag" data-summary-value="estimate">-</div>
                            <div class="est-disclaimer-text">
                                * {{ __('preview.estimator.disclaimer') }}
                            </div>
                        </div>
                    </div>

                    <!-- RIGHT: INPUT FORM -->
                    <div class="modal-form-side">
                        <h3 class="form-side-title">{{ __('preview.modal.personal_details') }}</h3>
                        <form class="quote-form premium-form" method="POST" action="{{ route('contact.submit') }}" data-quote-form="1">
                            @csrf
                            <div class="form-group floating-group">
                                <input type="text" class="form-input" name="full_name" placeholder=" " required>
                                <label class="floating-label">{{ __('preview.ph_name') }}</label>
                            </div>
                            <div class="form-group floating-group">
                                <input type="text" class="form-input" name="company_name" id="quote-company" placeholder=" ">
                                <label class="floating-label">{{ __('preview.ph_company') }}</label>
                            </div>
                            <div class="form-group floating-group">
                                <input type="email" class="form-input" name="email" placeholder=" " required>
                                <label class="floating-label">{{ __('preview.ph_email') }}</label>
                            </div>
                            <div class="form-group floating-group">
                                <input type="tel" class="form-input" name="phone" placeholder=" " required>
                                <label class="floating-label">{{ __('preview.ph_phone') }}</label>
                            </div>
                            <div class="form-group full floating-group">
                                <textarea class="form-input" name="note" id="quote-note" placeholder=" "></textarea>
                                <label class="floating-label">{{ __('preview.ph_msg') }}</label>
                            </div>
                            <input type="hidden" name="message" id="quote-message">
                            <input type="hidden" name="type" value="preview_estimator">

                            <button type="submit" class="form-btn premium-btn">
                                {{ __('preview.modal.submit_btn') }}
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-send">
                                    <line x1="22" y1="2" x2="11" y2="13"></line>
                                    <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                                </svg>
                            </button>
                            <p class="privacy-note">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                </svg>
                                {{ __('preview.modal.privacy_note') }}
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="ai-widget">
        <div class="ai-modal" id="ai-modal">
            <div class="ai-header">
                <h4>{{ __('preview.ai.title') }}</h4>
                <button class="ai-close">&times;</button>
            </div>
            <div class="ai-body" id="ai-body">
                <div class="ai-message">{{ __('preview.ai.greeting') }}</div>
            </div>
            <div class="typing-indicator" id="typing-indicator">{{ __('preview.ai.typing') }}</div>
            <div class="ai-input-group">
                <input type="text" class="ai-input" id="ai-input" placeholder="{{ __('preview.ai.placeholder') }}" data-lang-placeholder="ai_placeholder">
                <button class="ai-send" id="ai-send">{{ __('preview.ai.send') }}</button>
            </div>
        </div>

        <!-- Docked Logic: Rocket is part of the Widget now -->
        <div class="docked-rocket" id="docked-rocket" style="opacity: 0; visibility: hidden;">
            <svg class="rocket-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 19V5M5 12l7-7 7 7" />
            </svg>
        </div>

        <button class="ai-trigger" id="ai-trigger"><svg width="30" height="30" viewBox="0 0 24 24" fill="currentColor">
                <path d="M19 9.3V4h-3v2.6L12 3 2 12h3v8h5v-6h4v6h5v-8h3l-3-2.7zm-9 .7c0-1.1.9-2 2-2s2 .9 2 2-.9 2-2 2-2-.9-2-2z" />
            </svg></button>
    </div>





    @include('front.layouts.partials.footer-modern')

    <!-- MOBILE NAV -->
    <div class="mobile-nav" id="mobile-nav">
        <button class="close-btn" id="close-menu"><svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z" />
            </svg></button>
        <ul>
            <li><a href="{{ route('preview') }}">{{ __('front.home') }}</a></li>
            <li><a href="{{ route('preview.services') }}">{{ $ct('services', __('services')) }}</a></li>
            <li><a href="{{ route('preview.packages') }}">{{ __('preview.nav.packages') }}</a></li>
            <li><a href="{{ route('preview.portfolio') }}">{{ $ct('portfolio', __('portfolio')) }}</a></li>
            <li><a href="{{ route('preview.case-study.index') }}">{{ __('preview.nav.case_studies') }}</a></li>
            <li><a href="{{ route('preview.team.index') }}">{{ __('preview.nav.team') }}</a></li>
            <li><a href="{{ route('preview.about-us') }}">{{ $ct('about', __('about')) }}</a></li>
            <li><a href="{{ route('preview.blogs') }}">{{ $ct('blog', __('blog')) }}</a></li>
            <li><a href="{{ route('preview.contact') }}">{{ $ct('contact', __('contact')) }}</a></li>
        </ul>
        <div class="mobile-controls">
            <button class="mobile-control-btn" id="mobile-theme-toggle">
                <svg class="icon-sun" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="4"></circle>
                    <path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M4.93 19.07l1.41-1.41M17.66 6.34l1.41-1.41"></path>
                </svg>
                <svg class="icon-moon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"></path>
                </svg>
                {{ __('preview.mobile.theme') }}
            </button>
            <button class="mobile-control-btn" id="mobile-lang-toggle" data-lang-change-url="{{ route('lang.change', ['lang' => ':lang']) }}" data-current-lang="{{ strtoupper(app()->getLocale()) }}">
                {{ strtoupper(app()->getLocale()) }}
            </button>
        </div>
    </div>

    <!-- BACK TO TOP -->
    <!-- BACK TO TOP MOVED TO AI WIDGET -->



    <!-- VENDOR JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tilt.js/1.2.1/tilt.jquery.min.js"></script>

    <!-- CHALANG V2.0 GLOBAL (Preview System) -->
    <script src="{{ asset('assets/js/chalang-preview.js?v=') . time() }}"></script>

    <script>
        $(document).ready(function() {
            // BRIDGE: SAL to AOS (Fix for Shared Footer on Preview Page)
            document.querySelectorAll('[data-sal]').forEach(el => {
                let salAnim = el.getAttribute('data-sal');
                let salDelay = el.getAttribute('data-sal-delay');

                // Map SAL animations to AOS
                if (salAnim === 'slide-up') el.setAttribute('data-aos', 'fade-up');
                if (salAnim === 'slide-down') el.setAttribute('data-aos', 'fade-down');
                if (salAnim === 'slide-left') el.setAttribute('data-aos', 'fade-left');
                if (salAnim === 'slide-right') el.setAttribute('data-aos', 'fade-right');

                if (salDelay) el.setAttribute('data-aos-delay', salDelay);
            });

            // AOS INIT
            if (window.AOS && typeof AOS.init === 'function') {
                AOS.init({
                    duration: 1000,
                    once: true
                });
            } else {
                document.documentElement.setAttribute('data-aos-disabled', 'true');
            }

            // PORTFOLIO MODAL LOGIC
            $('.project-card').on('click', function(e) {
                if ($(e.target).closest('a').length) return;
                const card = $(this);
                const title = card.attr('data-title');
                const desc = card.attr('data-desc');
                const img = card.attr('data-img');
                const tags = card.find('.project-tags').html();
                const url = card.attr('data-url');

                $('#modal-title').text(title);
                $('#modal-desc').text(desc);
                $('#modal-img').attr('src', img);
                $('#modal-tags').html(tags);
                $('.modal-project-link').attr('href', url);

                $('#project-modal-overlay').addClass('active');
            });

            $('.modal-close, #project-modal-overlay').on('click', function(e) {
                if (e.target === this || $(e.target).hasClass('modal-close')) {
                    $('#project-modal-overlay').removeClass('active');
                }
            });

            // MAGNETIC EFFECT
            const magneticElements = document.querySelectorAll('.progress-wrap, .kinetic-btn, .ai-trigger');
            magneticElements.forEach((el) => {
                el.addEventListener('mousemove', function(e) {
                    const pos = this.getBoundingClientRect();
                    const x = e.clientX - pos.left - pos.width / 2;
                    const y = e.clientY - pos.top - pos.height / 2;
                    this.style.transform = 'translate(' + x * 0.3 + 'px, ' + y * 0.3 + 'px)';
                });
                el.addEventListener('mouseout', function() {
                    this.style.transform = 'translate(0px, 0px)';
                });
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // FIX: Inline Estimator Logic to ensure it runs
            const estServices = document.querySelectorAll('#est-services .service-opt');
            const estSizes = document.querySelectorAll('#est-size .service-opt');
            const estTime = document.getElementById('est-time');
            const estPriceDisplay = document.getElementById('est-price');
            const currencyToggle = document.getElementById('est-currency-toggle');
            const lblUsd = document.getElementById('lbl-usd');
            const lblAzn = document.getElementById('lbl-azn');
            let currentCurrency = 'USD';
            const exchangeRate = 1.7;

            const calculateEstimate = () => {
                if (!estServices.length || !estSizes.length || !estTime || !estPriceDisplay) return;

                const selectedService = document.querySelector('#est-services .service-opt.selected');
                const basePrice = selectedService ? parseFloat(selectedService.getAttribute('data-val')) : 0;

                const selectedSize = document.querySelector('#est-size .service-opt.selected');
                const sizeMultiplier = selectedSize ? parseFloat(selectedSize.getAttribute('data-val')) : 1;

                const urgencyVal = parseInt(estTime.value, 10);
                let urgencyFactor = 1.0;
                // Default multipliers
                if (urgencyVal === 1) urgencyFactor = 1.0;
                if (urgencyVal === 2) urgencyFactor = 1.25;
                if (urgencyVal === 3) urgencyFactor = 1.5;

                let finalTotal = basePrice * sizeMultiplier * urgencyFactor;

                if (currentCurrency === 'AZN') {
                    finalTotal = finalTotal * exchangeRate;
                }

                const min = Math.round(finalTotal * 0.9);
                const max = Math.round(finalTotal * 1.2);

                const locale = currentCurrency === 'AZN' ? 'az-AZ' : 'en-US';
                const formatter = new Intl.NumberFormat(locale, {
                    style: 'currency',
                    currency: currentCurrency,
                    maximumFractionDigits: 0
                });

                if (basePrice > 0) {
                    let formattedMin = formatter.format(min).replace('AZN', '₼').replace('USD', '$');
                    let formattedMax = formatter.format(max).replace('AZN', '₼').replace('USD', '$');
                    formattedMin = formattedMin.replace(/\s+/g, ' ').trim();
                    formattedMax = formattedMax.replace(/\s+/g, ' ').trim();
                    estPriceDisplay.textContent = `${formattedMin} - ${formattedMax}`;
                } else {
                    estPriceDisplay.textContent = (currentCurrency === 'AZN' ? 'Bir xidmət seçin' : 'Select a service');
                }
            };

            if (currencyToggle) {
                currencyToggle.addEventListener('change', () => {
                    currentCurrency = currencyToggle.checked ? 'AZN' : 'USD';
                    if (lblUsd && lblAzn) {
                        lblUsd.classList.toggle('active', !currencyToggle.checked);
                        lblAzn.classList.toggle('active', currencyToggle.checked);
                    }
                    calculateEstimate();
                });
            }

            estServices.forEach(btn => {
                btn.addEventListener('click', () => {
                    estServices.forEach(b => b.classList.remove('selected'));
                    btn.classList.add('selected');
                    calculateEstimate();
                });
            });

            estSizes.forEach(btn => {
                btn.addEventListener('click', () => {
                    estSizes.forEach(b => b.classList.remove('selected'));
                    btn.classList.add('selected');
                    calculateEstimate();
                });
            });

            if (estTime) {
                estTime.addEventListener('input', calculateEstimate);
                estTime.addEventListener('change', calculateEstimate); // Fallback
            }

            // Initial Run
            setTimeout(calculateEstimate, 500);

            // FIX: Inline Counter Animation Logic
            const counters = document.querySelectorAll('.counter');
            if (counters.length) {
                const animateCounter = (el) => {
                    const rawText = el.innerText;
                    const target = parseInt(rawText.replace(/[^\d]/g, ''), 10);
                    if (isNaN(target)) return;

                    const duration = 2000;
                    const frameDuration = 1000 / 60;
                    const totalFrames = Math.round(duration / frameDuration);
                    const easeOutQuad = (t) => t * (2 - t);
                    let frame = 0;

                    const updateCount = () => {
                        frame++;
                        const progress = easeOutQuad(frame / totalFrames);
                        const currentCount = Math.round(target * progress);

                        if (frame < totalFrames) {
                            el.innerText = currentCount;
                            requestAnimationFrame(updateCount);
                        } else {
                            el.innerText = target;
                        }
                    };
                    updateCount();
                    el.classList.add('animated');
                };

                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting && !entry.target.classList.contains('animated')) {
                            animateCounter(entry.target);
                            observer.unobserve(entry.target);
                        }
                    });
                }, {
                    threshold: 0.5
                });

                counters.forEach(counter => observer.observe(counter));
            }
        });

        // Modal Logic (Duplicate check avoided by simple overwrite of listeners if needed, but existing is fine)
        document.addEventListener('DOMContentLoaded', () => {
            const openBtn = document.getElementById('est-cta');
            const modal = document.getElementById('quote-modal-overlay');
            if (!openBtn || !modal) {
                return;
            }
            const closeBtn = document.getElementById('quote-modal-close');
            const openModal = () => {
                modal.classList.add('active');
                modal.setAttribute('aria-hidden', 'false');
                document.body.classList.add('modal-open');
            };
            const closeModal = () => {
                modal.classList.remove('active');
                modal.setAttribute('aria-hidden', 'true');
                document.body.classList.remove('modal-open');
            };
            openBtn.addEventListener('click', (event) => {
                event.preventDefault();
                openModal();
            });
            if (closeBtn) {
                closeBtn.addEventListener('click', closeModal);
            }
            modal.addEventListener('click', (event) => {
                if (event.target === modal) {
                    closeModal();
                }
            });
            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape') {
                    closeModal();
                }
            });
        });
        document.addEventListener('DOMContentLoaded', () => {
            const scanOverlay = document.getElementById('audit-scan-overlay');
            if (scanOverlay) {
                scanOverlay.addEventListener('click', () => {
                    scanOverlay.classList.remove('active');
                    scanOverlay.classList.remove('success');
                    const btn = document.querySelector('.magnet-btn');
                    if (btn) btn.disabled = false;
                });
            }
        });



        // EXPOSE TO WINDOW TO PREVENT SCOPE ISSUES
        window.startWebsiteAudit = function(btn) {
            console.log('startWebsiteAudit called');

            try {
                const form = document.getElementById('audit-form');
                if (!form.checkValidity()) {
                    form.reportValidity();
                    return;
                }

                const scanOverlay = document.getElementById('audit-scan-overlay');
                const scanText = scanOverlay ? scanOverlay.querySelector('.scan-text') : null;
                const originalBtnText = btn.innerHTML;

                btn.disabled = true;
                btn.innerHTML = 'Analiz edilir...';

                // 1. Force Show Scanning Overlay
                if (scanOverlay) {
                    scanOverlay.classList.remove('success');
                    scanOverlay.classList.add('active');

                    // BRUTE FORCE STYLES - Just to be 100% sure
                    scanOverlay.style.visibility = 'visible';
                    scanOverlay.style.opacity = '1';

                    if (scanText) scanText.innerText = 'Sayt analiz edilir...';
                }

                // 2. Timers
                const startTime = Date.now();
                const minTime = 3000; // Fast feedback
                const timers = [];

                timers.push(setTimeout(() => {
                    if (scanText && scanOverlay && scanOverlay.classList.contains('active')) scanText.innerText = 'Səhifələr yoxlanılır...';
                }, 1000));

                timers.push(setTimeout(() => {
                    if (scanText && scanOverlay && scanOverlay.classList.contains('active')) scanText.innerText = 'Hesabat hazırlanır...';
                }, 2000));

                const formData = new FormData(form);

                const fetchPromise = fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });

                // 10s Timeout limit
                const timeoutPromise = new Promise((_, reject) => {
                    setTimeout(() => reject(new Error('Request timed out')), 10000);
                });

                Promise.race([fetchPromise, timeoutPromise])
                    .then(response => {
                        if (response.ok) return response.json();
                        return response.text().then(text => {
                            throw new Error(text || 'Network error');
                        });
                    })
                    .then(data => {
                        const elapsed = Date.now() - startTime;
                        const remaining = Math.max(0, minTime - elapsed);
                        setTimeout(() => {
                            if (scanText) scanText.innerText = data.message || 'Uğurlu! Hesabat emailinizə göndəriləcək.';
                            if (scanOverlay) scanOverlay.classList.add('success');

                            btn.disabled = false;
                            btn.innerHTML = originalBtnText;

                            setTimeout(() => {
                                if (scanOverlay) {
                                    scanOverlay.classList.remove('active');
                                    scanOverlay.classList.remove('success');
                                    // Reset Brute Force
                                    scanOverlay.style.visibility = '';
                                    scanOverlay.style.opacity = '';
                                }
                                form.reset();
                            }, 4000);
                        }, remaining);
                    })
                    .catch(error => {
                        console.error('Audit Error:', error);
                        timers.forEach(t => clearTimeout(t));

                        if (scanText) scanText.innerText = 'Xəta: ' + (error.message || 'Bilinməyən xəta');

                        btn.disabled = false;
                        btn.innerHTML = originalBtnText;

                        setTimeout(() => {
                            if (scanOverlay && !scanOverlay.classList.contains('success')) {
                                scanOverlay.classList.remove('active');
                                // Reset Brute Force
                                scanOverlay.style.visibility = '';
                                scanOverlay.style.opacity = '';
                            }
                        }, 3000);
                    });
            } catch (err) {
                console.error('Audit Error:', err);
                btn.disabled = false;

                // Parse friendly error message if possible
                let cleanMsg = 'Xəta baş verdi. Zəhmət olmasa bir az sonra cəhd edin.';

                if (err.message) {
                    try {
                        // If it's a JSON string (Laravel error response)
                        if (err.message.trim().startsWith('{') || err.message.trim().startsWith('[')) {
                            const errorObj = JSON.parse(err.message);
                            if (errorObj.message) cleanMsg = errorObj.message;
                            else if (errorObj.error) cleanMsg = errorObj.error;

                            // Detect if it's a raw exception (Sentry/Laravel Debug)
                            if (errorObj.file || errorObj.exception || errorObj.trace) {
                                cleanMsg = 'Sistem xətası (Server Error). Cəhdiniz qeydə alınmadı.';
                            }
                        } else {
                            // Plain text error
                            cleanMsg = err.message.length > 100 ? 'Sistem xətası baş verdi.' : err.message;
                        }
                    } catch (e) {
                        cleanMsg = err.message.length > 100 ? 'Sistem xətası baş verdi.' : err.message;
                    }
                }

                if (scanOverlay) {
                    scanOverlay.classList.remove('active'); // Hide overlay on error so user isn't stuck
                    setTimeout(() => {
                        alert(cleanMsg); // Show alert instead of stuck text
                    }, 500);
                }
            }
        }
    </script>





    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // FIX: Inline Estimator Logic to ensure it runs
            const estServices = document.querySelectorAll('#est-services .service-opt');
            const estSizes = document.querySelectorAll('#est-size .service-opt');
            const estTime = document.getElementById('est-time');
            const estPriceDisplay = document.getElementById('est-price');
            const currencyToggle = document.getElementById('est-currency-toggle');
            const lblUsd = document.getElementById('lbl-usd');
            const lblAzn = document.getElementById('lbl-azn');
            let currentCurrency = 'USD';
            const exchangeRate = 1.7;

            const calculateEstimate = () => {
                if (!estServices.length || !estSizes.length || !estTime || !estPriceDisplay) return;

                const selectedService = document.querySelector('#est-services .service-opt.selected');
                const basePrice = selectedService ? parseFloat(selectedService.getAttribute('data-val')) : 0;

                const selectedSize = document.querySelector('#est-size .service-opt.selected');
                const sizeMultiplier = selectedSize ? parseFloat(selectedSize.getAttribute('data-val')) : 1;

                const urgencyVal = parseInt(estTime.value, 10);
                let urgencyFactor = 1.0;
                // Default multipliers
                if (urgencyVal === 1) urgencyFactor = 1.0;
                if (urgencyVal === 2) urgencyFactor = 1.25;
                if (urgencyVal === 3) urgencyFactor = 1.5;

                let finalTotal = basePrice * sizeMultiplier * urgencyFactor;

                if (currentCurrency === 'AZN') {
                    finalTotal = finalTotal * exchangeRate;
                }

                const min = Math.round(finalTotal * 0.9);
                const max = Math.round(finalTotal * 1.2);

                const locale = currentCurrency === 'AZN' ? 'az-AZ' : 'en-US';
                const formatter = new Intl.NumberFormat(locale, {
                    style: 'currency',
                    currency: currentCurrency,
                    maximumFractionDigits: 0
                });

                if (basePrice > 0) {
                    let formattedMin = formatter.format(min).replace('AZN', '₼').replace('USD', '$');
                    let formattedMax = formatter.format(max).replace('AZN', '₼').replace('USD', '$');
                    formattedMin = formattedMin.replace(/\s+/g, ' ').trim();
                    formattedMax = formattedMax.replace(/\s+/g, ' ').trim();
                    estPriceDisplay.textContent = `${formattedMin} - ${formattedMax}`;
                } else {
                    estPriceDisplay.textContent = (currentCurrency === 'AZN' ? 'Bir xidmət seçin' : 'Select a service');
                }
            };

            if (currencyToggle) {
                currencyToggle.addEventListener('change', () => {
                    currentCurrency = currencyToggle.checked ? 'AZN' : 'USD';
                    if (lblUsd && lblAzn) {
                        lblUsd.classList.toggle('active', !currencyToggle.checked);
                        lblAzn.classList.toggle('active', currencyToggle.checked);
                    }
                    calculateEstimate();
                });
            }

            estServices.forEach(btn => {
                btn.addEventListener('click', () => {
                    estServices.forEach(b => b.classList.remove('selected'));
                    btn.classList.add('selected');
                    calculateEstimate();
                });
            });

            estSizes.forEach(btn => {
                btn.addEventListener('click', () => {
                    estSizes.forEach(b => b.classList.remove('selected'));
                    btn.classList.add('selected');
                    calculateEstimate();
                });
            });

            if (estTime) {
                estTime.addEventListener('input', calculateEstimate);
                estTime.addEventListener('change', calculateEstimate); // Fallback
            }

            // Initial Run
            setTimeout(calculateEstimate, 500);

            // FIX: Inline Counter Animation Logic
            const counters = document.querySelectorAll('.counter');
            if (counters.length) {
                const animateCounter = (el) => {
                    const rawText = el.innerText;
                    const target = parseInt(rawText.replace(/[^\d]/g, ''), 10);
                    if (isNaN(target)) return;

                    const duration = 2000;
                    const frameDuration = 1000 / 60;
                    const totalFrames = Math.round(duration / frameDuration);
                    const easeOutQuad = (t) => t * (2 - t);
                    let frame = 0;

                    const updateCount = () => {
                        frame++;
                        const progress = easeOutQuad(frame / totalFrames);
                        const currentCount = Math.round(target * progress);

                        if (frame < totalFrames) {
                            el.innerText = currentCount;
                            requestAnimationFrame(updateCount);
                        } else {
                            el.innerText = target;
                        }
                    };
                    updateCount();
                    el.classList.add('animated');
                };

                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting && !entry.target.classList.contains('animated')) {
                            animateCounter(entry.target);
                            observer.unobserve(entry.target);
                        }
                    });
                }, {
                    threshold: 0.5
                });

                counters.forEach(counter => observer.observe(counter));
            }

            // NEW: Mobile Modal Accordion Logic
            const modalReceipt = document.querySelector('.modal-receipt');
            const receiptHeader = document.querySelector('.receipt-header');

            if (modalReceipt && receiptHeader) {
                receiptHeader.addEventListener('click', () => {
                    // Only active on mobile (based on CSS check or window width)
                    if (window.innerWidth <= 768) {
                        modalReceipt.classList.toggle('active');
                    }
                });
            }
        });
    </script>

    {{-- P0-08: Mobile Sticky CTA Bottom Bar --}}
    <div class="mobile-sticky-cta">
        <a href="{{ route('contact') }}" class="btn btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 8px;">
                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                <polyline points="22,6 12,13 2,6"></polyline>
            </svg>
            {{ $ct('preview', 'btn_start', __('preview.btn_start', [], app()->getLocale())) }}
        </a>
    </div>

    @include('front.layouts.partials.cookie-consent')
</body>

</html>
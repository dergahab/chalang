<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Services\FrontService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Lang;
use App\Http\Resources\ServiceResource;
use App\Http\Resources\PortfolioResource;
use App\Http\Resources\TestimonialResource;
use App\Http\Resources\BlogResource;

class MainController extends Controller
{
    protected $frontService;

    public function __construct(FrontService $frontService)
    {
        $this->frontService = $frontService;
    }

    public function index()
    {
        $isComingSoon = \App\Models\Setting::where('key', 'is_coming_soon')->first();
        if ($isComingSoon && $isComingSoon->value == '1' && !auth()->check()) {
            return view('coming-soon');
        }

        $main_services = $this->frontService->getMainServices();
        $portfolios = $this->frontService->getPortfolios(); // Default logic for main page
        $portfolio_categories = $this->frontService->getPortfolioCategories($portfolios);
        $banner = $this->frontService->getBanner();
        $companies = $this->frontService->getCompanies();
        $blogs = $this->frontService->getBlogs();

        // New modules
        $case_studies = $this->frontService->getCaseStudies(3);
        $testimonials = $this->frontService->getTestimonials();
        $partners = $this->frontService->getPartners();
        $pricing_plans = $this->frontService->getPricingPlans();
        $team_members = $this->frontService->getTeamMembers(true); // Featured only for home
        $faqs = $this->frontService->getFaqs();

        $view = 'front.index.index_new';

        return view($view, compact(
            'main_services',
            'portfolio_categories',
            'portfolios',
            'companies',
            'blogs',
            'banner',
            'case_studies',
            'testimonials',
            'partners',
            'pricing_plans',
            'team_members',
            'faqs'
        ));
    }

    public function preview()
    {
        if (config('app.env') !== 'local') {
            abort(404);
        }

        $locale = app()->getLocale();
        $this->overrideLiveStatusTranslation($locale);
        $main_services = $this->frontService->getMainServices();
        $portfolios = $this->frontService->getPortfolios(6); // Limit 6 for preview
        $case_studies = $this->frontService->getCaseStudies(3);
        $testimonials = $this->frontService->getTestimonials(6);
        $partners = $this->frontService->getPartners();
        $pricing_plans = $this->frontService->getPricingPlans();
        $team_members = $this->frontService->getTeamMembers(true); // Featured only for home
        $faqs = $this->frontService->getFaqs(6);
        $socialmedia = \App\Models\Socialmedia::all();
        $banner = $this->frontService->getBanner();
        $steps = $this->frontService->getSteps(4);
        $blogs = $this->frontService->getBlogs(3, true);
        $contentTexts = $this->frontService->getContentTexts(
            ['services', 'portfolio', 'blog', 'contact', 'about'],
            ['preview.', 'front.']
        );
        $contentTextMap = $this->applyContentTextOverrides($contentTexts, $locale);

        return response()
            ->view('front.preview', compact(
                'main_services',
                'portfolios',
                'case_studies',
                'testimonials',
                'partners',
                'pricing_plans',
                'team_members',
                'faqs',
                'socialmedia',
                'banner',
                'steps',
                'blogs',
                'contentTextMap'
            ))
            ->header('Content-Type', 'text/html; charset=UTF-8');
    }

    protected function applyContentTextOverrides($contentTexts, string $locale): array
    {
        $lines = [];
        $map = [];
        $groupsToLoad = [];

        foreach ($contentTexts as $item) {
            $value = $this->resolveContentTextValue($item, $locale);
            if ($value === null) {
                continue;
            }
            if (is_string($value) && trim($value) === (string) $item->key) {
                continue;
            }

            $map[$item->key] = $value;

            if (str_contains($item->key, '.')) {
                $lines[$item->key] = $value;
                $groupsToLoad[strtok($item->key, '.')] = true;
            }
        }

        if ($lines) {
            foreach (array_keys($groupsToLoad) as $group) {
                Lang::get($group . '.__load', [], $locale);
            }
            Lang::addLines($lines, $locale);
        }

        return $map;
    }

    protected function resolveContentTextValue($item, string $locale)
    {
        $translation = $item->translate($locale);
        $raw = $translation?->content ?? $translation?->title ?? '';
        $raw = is_string($raw) ? trim($raw) : '';

        if ($raw === '') {
            return null;
        }

        return $this->parseContentTextValue($raw, (string) $item->key);
    }

    protected function parseContentTextValue(string $raw, string $key)
    {
        $trimmed = trim($raw);
        if ($trimmed === '') {
            return null;
        }

        if (
            (str_starts_with($trimmed, '[') && str_ends_with($trimmed, ']'))
            || (str_starts_with($trimmed, '{') && str_ends_with($trimmed, '}'))
        ) {
            $decoded = json_decode($trimmed, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                return $decoded;
            }
        }

        if (str_ends_with($key, '.tech_stack.items')) {
            return $this->parseIconLabelList($trimmed);
        }

        if (str_ends_with($key, '.services') || str_ends_with($key, '.sizes')) {
            return $this->parseKeyValueList($trimmed);
        }

        if (
            str_ends_with($key, '.items')
            || str_ends_with($key, '.tags')
            || str_ends_with($key, '.ticker_default')
        ) {
            return $this->splitList($trimmed);
        }

        return $trimmed;
    }

    protected function splitList(string $raw): array
    {
        $plain = trim(strip_tags($raw));
        if ($plain === '') {
            return [];
        }

        $parts = preg_split('/\r?\n|,/', $plain);

        return array_values(array_filter(array_map('trim', $parts), static function ($item) {
            return $item !== '';
        }));
    }

    protected function parseKeyValueList(string $raw): array
    {
        $plain = trim(strip_tags($raw));
        if ($plain === '') {
            return [];
        }

        $lines = preg_split('/\r?\n/', $plain);
        $items = [];

        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '') {
                continue;
            }

            $parts = preg_split('/\s*\|\s*|\s*:\s*/', $line, 2);
            $labelRaw = trim($parts[0] ?? '');
            $value = trim($parts[1] ?? '');
            $isDefault = false;

            if ($labelRaw !== '' && $labelRaw[0] === '*') {
                $isDefault = true;
                $labelRaw = ltrim(substr($labelRaw, 1));
            }

            $label = trim($labelRaw);

            if ($label === '') {
                continue;
            }

            if ($value !== '' && is_numeric($value)) {
                $value = $value + 0;
            }

            $items[] = [
                'label' => $label,
                'value' => $value !== '' ? $value : null,
                'default' => $isDefault,
            ];
        }

        return $items;
    }

    protected function parseIconLabelList(string $raw): array
    {
        $plain = trim(strip_tags($raw));
        if ($plain === '') {
            return [];
        }

        $lines = preg_split('/\r?\n/', $plain);
        $items = [];

        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '') {
                continue;
            }

            $parts = preg_split('/\s*\|\s*|\s*:\s*/', $line, 2);
            if (count($parts) === 2) {
                $icon = trim($parts[0]);
                $label = trim($parts[1]);
            } else {
                $icon = '';
                $label = $line;
            }

            if ($label === '') {
                continue;
            }

            $items[] = [
                'icon' => $icon,
                'label' => $label,
            ];
        }

        return $items;
    }
    public function reactPreview()
    {
        $locale = app()->getLocale();
        $main_services = $this->frontService->getMainServices();
        $portfolios = $this->frontService->getPortfolios(6);
        $case_studies = $this->frontService->getCaseStudies(3);
        $testimonials = $this->frontService->getTestimonials(6);
        $partners = $this->frontService->getPartners();
        $pricing_plans = $this->frontService->getPricingPlans();
        $team_members = $this->frontService->getTeamMembers(true);
        $faqs = $this->frontService->getFaqs(6);
        $socialmedia = \App\Models\Socialmedia::all();
        $banner = $this->frontService->getBanner();
        $steps = $this->frontService->getSteps(4);
        $blogs = $this->frontService->getBlogs(3, true);


        // Content Texts
        $contentTexts = $this->frontService->getContentTexts(
            ['services', 'portfolio', 'blog', 'contact', 'about'],
            ['preview.', 'front.']
        );
        $contentTextMap = $this->applyContentTextOverrides($contentTexts, $locale);

        // Theme Settings (Full sync with dynamic-styles.blade.php)
        $theme = $this->getThemeSettings();

        // Full translations for all sections
        $translations = __('preview');
        $this->overrideLiveStatusTranslation($locale, $translations);

        // Map FAQs with active locale and English fallback
        $translatedFaqs = $faqs->map(function ($faq) use ($locale) {
            $trans = $faq->translate($locale) ?? $faq->translate('en') ?? $faq->translations->first();
            return [
                'id' => $faq->id,
                'question' => $trans?->question ?? '',
                'answer' => $trans?->answer ?? '',
            ];
        });

        // Map Team Members with active locale and English fallback
        $translatedTeam = $team_members->map(function ($member) use ($locale) {
            $trans = $member->translate($locale) ?? $member->translate('en') ?? $member->translations->first();
            return [
                'id' => $member->id,
                'name' => $trans?->name ?? '',
                'position' => $trans?->position ?? '',
                'image' => $member->image,
                'specialties' => $trans?->specialties ?? '',
            ];
        });

        // Data for React
        return \Inertia\Inertia::render('Home', [
            'theme' => $theme,
            'banner' => $banner,
            'main_services' => $main_services,
            'portfolio_items' => $portfolios,
            'case_studies' => $case_studies,
            'testimonials' => $testimonials,
            'partners' => $partners,
            'pricing_plans' => $pricing_plans,
            'team_members' => $translatedTeam,
            'faq_items' => $translatedFaqs,
            'social_media' => $socialmedia,
            'steps' => $steps,
            'blogs' => $blogs,
            'content_text_map' => $contentTextMap,
            'marquee_text' => $contentTextMap['preview.marquee_text'] ?? __('preview.marquee'),
            'locale' => $locale,
            'translations' => $translations,
        ]);
    }

    public function reactAbout()
    {
        if (config('app.env') !== 'local') {
            abort(404);
        }

        $locale = app()->getLocale();
        
        // About data (with fallback)
        $about = $this->frontService->getAbout();
        if (!$about) {
            $about = (object) [
                'id' => 1,
                'title' => 'Gələcəyi Yaradanlar',
                'description' => '<p>Chalang, brendlərin rəqəmsal dünyada parlamasına kömək edən yaradıcı agentlikdir. Biz minimalist, lakin təsirli dizaynlar yaradırıq.</p>',
                'image' => '/assets/media/about/about-1.png'
            ];
        }
        
        $steps = $this->frontService->getSteps(4);
        $teamMembers = $this->frontService->getTeamMembers(false);
        $partners = $this->frontService->getPartners();
        
        // Footer & Estimator dependencies
        $main_services = $this->frontService->getMainServices();
        $socialmedia = \App\Models\Socialmedia::all();
        
        // Content Texts
        $contentTexts = $this->frontService->getContentTexts(['about'], ['preview.', 'front.']);
        $contentTextMap = $this->applyContentTextOverrides($contentTexts, $locale);
        
        // Theme Settings
        $theme = $this->getThemeSettings();
        
        // Translations
        $translations = __('preview');
        $this->overrideLiveStatusTranslation($locale, $translations);
        
        return \Inertia\Inertia::render('About', [
            'about' => $about,
            'steps' => $steps,
            'teamMembers' => $teamMembers,
            'partners' => $partners,
            'content_text_map' => $contentTextMap,
            'locale' => $locale,
            'translations' => $translations,
            'theme' => $theme,
            'main_services' => $main_services,
            'social_media' => $socialmedia,
        ]);
    }

    private function overrideLiveStatusTranslation(string $locale, array &$translations = null): void
    {
        $dbStatusMessage = \App\Models\Setting::getValue('live_status_message_' . $locale) 
            ?? \App\Models\Setting::getValue('live_status_message_az');
        if ($dbStatusMessage) {
            app('translator')->addLines(['preview.footer.live_status' => $dbStatusMessage], $locale);
            app('translator')->addLines(['front.footer.live_status' => $dbStatusMessage], $locale);
            if ($translations !== null && isset($translations['footer'])) {
                $translations['footer']['live_status'] = $dbStatusMessage;
            }
        }
    }

    private function getThemeSettings()
    {
        $hex2rgb = function ($hex) {
            $hex = str_replace('#', '', $hex);
            if (strlen($hex) == 3) {
                $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
                $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
                $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
            } else {
                $r = hexdec(substr($hex, 0, 2));
                $g = hexdec(substr($hex, 2, 2));
                $b = hexdec(substr($hex, 4, 2));
            }
            return "$r, $g, $b";
        };

        $pLight = \App\Models\Setting::getValue('theme_color_primary_light') ?? '#4b0082';
        $sLight = \App\Models\Setting::getValue('theme_color_secondary_light') ?? '#d500f9';
        $tLight = \App\Models\Setting::getValue('theme_color_tertiary_light') ?? '#9333ea'; // brand-violet
        $pDark  = \App\Models\Setting::getValue('theme_color_primary_dark')  ?? '#7c3aed';
        $sDark  = \App\Models\Setting::getValue('theme_color_secondary_dark') ?? '#c026d3';
        $tDark  = \App\Models\Setting::getValue('theme_color_tertiary_dark')  ?? '#8b00ff'; // deep violet
        $fontFamily    = \App\Models\Setting::getValue('theme_font_family')    ?? 'Outfit';
        $borderRadius  = \App\Models\Setting::getValue('theme_border_radius')  ?? 'rounded';
        $smartBg       = \App\Models\Setting::getValue('theme_smart_bg')       ?? false;
        $glowIntensity = (int) (\App\Models\Setting::getValue('theme_glow_intensity') ?? 15);
        $customCss     = \App\Models\Setting::getValue('theme_custom_css') ?? '';
        $customJs      = \App\Models\Setting::getValue('theme_custom_js') ?? '';

        // Gradient Studio
        $gradientAngle    = (int) (\App\Models\Setting::getValue('gradient_angle')             ?? 135);
        $ambientIntensity = (int) (\App\Models\Setting::getValue('gradient_ambient_intensity') ?? 60);
        $gradientBtnStart = \App\Models\Setting::getValue('gradient_btn_start') ?? '';
        $gradientBtnEnd   = \App\Models\Setting::getValue('gradient_btn_end')   ?? '';
        $gradientTxtStart = \App\Models\Setting::getValue('gradient_text_start') ?? '';
        $gradientTxtEnd   = \App\Models\Setting::getValue('gradient_text_end')   ?? '';

        // Radius Mapping (synced with dynamic-styles.blade.php)
        $radii = [
            'square'  => ['btn' => '0px',  'card' => '0px',  'input' => '0px'],
            'rounded' => ['btn' => '12px', 'card' => '24px', 'input' => '12px'],
            'pill'    => ['btn' => '50px', 'card' => '30px', 'input' => '25px'],
        ];
        $r = $radii[$borderRadius] ?? $radii['rounded'];

        // Font mapping
        $fonts = [
            'Outfit'          => 'Outfit:wght@300;400;500;600;700;800;900',
            'Inter'           => 'Inter:wght@300;400;500;600;700;800;900',
            'Roboto'          => 'Roboto:wght@300;400;500;700;900',
            'Playfair Display'=> 'Playfair+Display:wght@400;600;700;900',
        ];
        $fontUrl = $fonts[$fontFamily] ?? $fonts['Outfit'];

        return [
            'colors' => [
                'light' => [
                    'primary'       => $pLight,
                    'secondary'     => $sLight,
                    'tertiary'      => $tLight,
                    'primary_rgb'   => $hex2rgb($pLight),
                    'secondary_rgb' => $hex2rgb($sLight),
                    'tertiary_rgb'  => $hex2rgb($tLight),
                ],
                'dark' => [
                    'primary'       => $pDark,
                    'secondary'     => $sDark,
                    'tertiary'      => $tDark,
                    'primary_rgb'   => $hex2rgb($pDark),
                    'secondary_rgb' => $hex2rgb($sDark),
                    'tertiary_rgb'  => $hex2rgb($tDark),
                ],
            ],
            'font'                     => $fontFamily,
            'font_url'                 => $fontUrl,
            'border_radius'            => $borderRadius,
            'radii'                    => $r,
            'smart_bg'                 => (bool) $smartBg,
            'glow_intensity'           => $glowIntensity,
            'custom_css'               => $customCss,
            'custom_js'                => $customJs,
            // Gradient Studio
            'gradient_angle'             => $gradientAngle,
            'gradient_ambient_intensity' => $ambientIntensity,
            'gradient_btn_start'         => $gradientBtnStart,
            'gradient_btn_end'           => $gradientBtnEnd,
            'gradient_text_start'        => $gradientTxtStart,
            'gradient_text_end'          => $gradientTxtEnd,
            'gradient_brand_css'         => \App\Models\Setting::getValue('gradient_brand_css') ?? '',
            'gradient_stops_json'        => \App\Models\Setting::getValue('gradient_stops_json') ?? '',
        ];
    }

    public function apiServices()
    {
        // Servisləri keşləyirik — nadir dəyişən data
        $locale = app()->getLocale();
        $services = Cache::remember('api_services_' . $locale, 300, function () {
            return $this->frontService->getMainServices();
        });
        return ServiceResource::collection($services);
    }

    public function apiPortfolio()
    {
        // Portfolioları keşləyirik — nadir dəyişən data
        $locale = app()->getLocale();
        $portfolios = Cache::remember('api_portfolio_' . $locale, 300, function () {
            return $this->frontService->getPortfolios(6);
        });
        return PortfolioResource::collection($portfolios);
    }

    public function apiTestimonials()
    {
        // Rəyləri keşləyirik — nadir dəyişən data
        $locale = app()->getLocale();
        $testimonials = Cache::remember('api_testimonials_' . $locale, 300, function () {
            return $this->frontService->getTestimonials(6);
        });
        return TestimonialResource::collection($testimonials);
    }

    public function apiBlog()
    {
        // Bloqları keşləyirik — nadir dəyişən data
        $locale = app()->getLocale();
        $blogs = Cache::remember('api_blog_' . $locale, 300, function () {
            return $this->frontService->getBlogs(3, true);
        });
        return BlogResource::collection($blogs);
    }

    public function apiMetrics()
    {
        $locale = app()->getLocale();

        // Metriklər statik datadır — keşləyirik, DB yükünü azaldırıq
        return Cache::remember('api_metrics_' . $locale, 300, function () use ($locale) {
            $contentTexts = $this->frontService->getContentTexts(
                ['services', 'portfolio', 'blog', 'contact', 'about'],
                ['preview.', 'front.']
            );
            $contentTextMap = $this->applyContentTextOverrides($contentTexts, $locale);

            return response()->json([
                'data' => [
                    'years' => [
                        'value' => $contentTextMap['preview.metrics.years_value'] ?? '10',
                        'label' => $contentTextMap['preview.metrics.years'] ?? __('preview.metrics.years')
                    ],
                    'projects' => [
                        'value' => $contentTextMap['preview.metrics.projects_value'] ?? '150',
                        'label' => $contentTextMap['preview.metrics.projects'] ?? __('preview.metrics.projects')
                    ],
                    'satisfaction' => [
                        'value' => $contentTextMap['preview.metrics.satisfaction_value'] ?? '99',
                        'label' => $contentTextMap['preview.metrics.satisfaction'] ?? __('preview.metrics.satisfaction')
                    ],
                    'awards' => [
                        'value' => $contentTextMap['preview.metrics.awards_value'] ?? '12',
                        'label' => $contentTextMap['preview.metrics.awards'] ?? __('preview.metrics.awards')
                    ],
                ]
            ]);
        });
    }
}


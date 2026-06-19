<?php

namespace App\Http\Controllers\Front;

use App\Helpers\FeatureFlag;
use App\Http\Controllers\Controller;
use App\Services\FrontService;

class PackageController extends Controller
{
    protected FrontService $frontService;

    public function __construct(FrontService $frontService)
    {
        $this->frontService = $frontService;
    }

    public function index()
    {
        return $this->render(false);
    }

    public function preview()
    {
        if (config('app.env') !== 'local') {
            abort(404);
        }

        return $this->render(true);
    }

    protected function render(bool $isPreview)
    {
        $pricingPlans = $this->frontService->getPricingPlans();
        $addons = $this->packageAddons();
        $fallbackPackages = $this->fallbackPackages();
        $view = FeatureFlag::isUiV2Enabled() || $isPreview
            ? 'front.pages.packages.index_new'
            : 'front.pages.packages.index_new';

        return view($view, compact('pricingPlans', 'addons', 'fallbackPackages'));
    }

    protected function packageAddons(): array
    {
        return [
            [
                'key' => 'seo_boost',
                'name' => 'SEO Boost',
                'description' => 'Axtarış optimizasiyası və texniki audit paketi.',
            ],
            [
                'key' => 'branding',
                'name' => 'Branding',
                'description' => 'Brend kimliyi, logo və vizual qaydalar.',
            ],
            [
                'key' => 'content_pack',
                'name' => 'Kontent Paketi',
                'description' => 'Landing və blog kontenti üçün copywriting.',
            ],
            [
                'key' => 'support_sla',
                'name' => 'Support SLA',
                'description' => 'Prioritetli dəstək və cavab vaxtları.',
            ],
            [
                'key' => 'hosting_infra',
                'name' => 'Hosting / Infra',
                'description' => 'Deploy, monitoring və infrastruktura dəstək.',
            ],
            [
                'key' => 'analytics_tracking',
                'name' => 'Analytics / Tracking',
                'description' => 'GA4, pixel, event tracking və dashboard.',
            ],
            [
                'key' => 'automation',
                'name' => 'Automation',
                'description' => 'CRM avtomatları və bildiriş ssenariləri.',
            ],
            [
                'key' => 'security_hardening',
                'name' => 'Security Hardening',
                'description' => 'Audit, hardening və risklərin azaldılması.',
            ],
        ];
    }

    protected function fallbackPackages(): array
    {
        return [
            [
                'name' => 'Start',
                'description' => 'Yeni başlayanlar üçün sürətli başlanğıc paketi.',
                'features' => [
                    'Əsas səhifə + 3 daxili səhifə',
                    'Basic SEO setup',
                    'Kontakt formu',
                ],
            ],
            [
                'name' => 'Growth',
                'description' => 'Böyümək istəyən bizneslər üçün balanslı paket.',
                'features' => [
                    '8-12 səhifə',
                    'Konversiya blokları',
                    'Blog və analitika',
                ],
            ],
            [
                'name' => 'Enterprise',
                'description' => 'Komandalar və böyük proseslər üçün paket.',
                'features' => [
                    'Çox dilli arxitektura',
                    'İnteqrasiya və avtomatlaşdırma',
                    'Təhlükəsizlik əlavələri',
                ],
            ],
            [
                'name' => 'Custom',
                'description' => 'Tamamilə sizə uyğunlaşdırılmış paket.',
                'features' => [
                    'Məqsədə görə scope',
                    'Fərdi timeline',
                    'Təklifə əsasən',
                ],
            ],
        ];
    }
}

<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        // Lazy-load translations so that per-page controllers (e.g. reactPreview)
        // can override with the full `__('preview')` array when they need it.
        return array_merge(parent::share($request), [
            'locale' => session('lang', app()->getLocale()),
            'translations' => function () {
                return [
                    'nav' => __('preview.nav'),
                    'footer' => __('preview.footer'),
                ];
            },
            // Shared global settings from database
            'global_settings' => function () {
                return \App\Models\Setting::pluck('value', 'key')->toArray();
            },
            // CSRF token for React fetch() calls (QuoteModal, LeadMagnet, etc.)
            'csrf_token' => csrf_token(),
        ]);
    }
}

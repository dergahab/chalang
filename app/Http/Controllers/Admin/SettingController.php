<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Spatie\Permission\Models\Role;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key')->toArray();
        $notificationRouting = [];
        $notificationRoutingRaw = $settings['notification_routing'] ?? null;
        if ($notificationRoutingRaw) {
            $decoded = json_decode($notificationRoutingRaw, true);
            if (is_array($decoded)) {
                $notificationRouting = $decoded;
            }
        }
        $notificationUsers = User::orderBy('name')->orderBy('surname')->get();
        $notificationRoles = Role::orderBy('name')->get();
        $notificationEvents = [
            'contact' => 'Contact form',
            'order' => 'Order form',
            'call' => 'Book a call',
            'package' => 'Package inquiry',
        ];
        $notificationChannels = [
            'database' => 'Dashboard',
            'mail' => 'Email',
            'slack' => 'Slack (future)',
        ];

        return view('admin.pages.settings.index', compact(
            'settings',
            'notificationRouting',
            'notificationUsers',
            'notificationRoles',
            'notificationEvents',
            'notificationChannels'
        ));
    }

    public function update(Request $request)
    {
        $request->validate([
            'site_title' => 'nullable|string|max:255',
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|string|max:50',
            'site_logo' => 'nullable|string|max:255',
            'site_logo_dark' => 'nullable|string|max:255',
            'site_favicon' => 'nullable|string|max:255',
            'maintenance_mode' => 'nullable|boolean',
            'seo_meta_title' => 'nullable|string|max:255',
            'seo_meta_description' => 'nullable|string|max:500',
            'seo_meta_keywords' => 'nullable|string|max:255',
            // Alerts
            'alert_payment_drop_active' => 'nullable|boolean',
            'alert_payment_drop_threshold' => 'nullable|integer|min:0',
            'alert_order_drop_active' => 'nullable|boolean',
            'alert_order_drop_threshold' => 'nullable|integer|min:0',
            'alert_form_spike_active' => 'nullable|boolean',
            'alert_form_spike_threshold' => 'nullable|integer|min:0',
            'alert_notification_email' => 'nullable|email|max:255',
            // Navigation Feature Toggles
            'nav_client_portal' => 'nullable|boolean',
            'nav_partner_hub' => 'nullable|boolean',
            // Theme Colors (regex validation handled below, basic type check here)
            'theme_color_tertiary_light' => 'nullable|string|max:9',
            'theme_color_tertiary_dark'  => 'nullable|string|max:9',
            // Gradient Studio
            'gradient_angle'             => 'nullable|integer|min:0|max:360',
            'gradient_ambient_intensity' => 'nullable|integer|min:0|max:100',
            'gradient_btn_start'         => 'nullable|string|max:9',
            'gradient_btn_end'           => 'nullable|string|max:9',
            'gradient_text_start'        => 'nullable|string|max:9',
            'gradient_text_end'          => 'nullable|string|max:9',
            'gradient_brand_css'         => 'nullable|string|max:1000',
            'gradient_stops_json'        => 'nullable|string|max:5000',
        ]);

        $notificationRouting = $request->input('notification_routing');
        if ($notificationRouting !== null) {
            if (!$request->user() || !$request->user()->hasRole('super-admin')) {
                abort(403, 'Unauthorized');
            }
            $normalizedRoutes = [];
            foreach ($notificationRouting as $eventKey => $config) {
                $channels = [];
                if (isset($config['channels']) && is_array($config['channels'])) {
                    $channels = array_values(array_unique(array_filter($config['channels'], 'is_string')));
                }
                $admins = [];
                if (isset($config['admins']) && is_array($config['admins'])) {
                    $admins = array_values(array_unique(array_filter(array_map('intval', $config['admins']))));
                }
                $roles = [];
                if (isset($config['roles']) && is_array($config['roles'])) {
                    $roles = array_map('strval', $config['roles']);
                    $roles = array_map('trim', $roles);
                    $roles = array_values(array_unique(array_filter($roles, static function ($role) {
                        return $role !== '';
                    })));
                }
                $emails = [];
                if (isset($config['emails'])) {
                    $emails = is_array($config['emails'])
                        ? $config['emails']
                        : explode(',', (string) $config['emails']);
                    $emails = array_values(array_unique(array_filter(array_map('trim', $emails))));
                }
                $normalizedRoutes[$eventKey] = [
                    'channels' => $channels,
                    'admins' => $admins,
                    'roles' => $roles,
                    'emails' => $emails,
                ];
            }
            Setting::setValue('notification_routing', json_encode($normalizedRoutes));
        }

        $data = $request->except('_token', '_method', 'notification_routing');

        foreach ($data as $key => $value) {
            // 1. Rəng Validasiyası (Hex Code)
            if (str_contains($key, 'theme_color_') && !empty($value)) {
                if (!preg_match('/^#([a-f0-9]{3}){1,2}$/i', $value)) {
                    continue; // Səhv formatdırsa, yadda saxlama
                }
            }

            // 2. Font Validasiyası (Allowlist)
            if ($key === 'theme_font_family') {
                $allowedFonts = ['Outfit', 'Inter', 'Roboto', 'Playfair Display'];
                if (!in_array($value, $allowedFonts)) {
                    $value = 'Outfit'; // Default
                }
            }

            // 3. Radius Validasiyası
            if ($key === 'theme_border_radius') {
                $allowedRadius = ['rounded', 'square', 'pill'];
                if (!in_array($value, $allowedRadius)) {
                    $value = 'rounded';
                }
            }
            
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        // Clear cache
        Cache::forget('settings');

        return redirect()->back()->with('success', 'Tənzimləmələr uğurla yeniləndi.');
    }
}

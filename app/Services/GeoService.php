<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class GeoService
{
    /**
     * Detect country from IP address
     */
    public static function detectCountry(string $ip): ?string
    {
        // Skip local IPs
        if (self::isLocalIP($ip)) {
            return 'local';
        }

        return Cache::remember("geo_country_{$ip}", 86400, function () use ($ip) {
            try {
                // Use ip-api.com (free tier - 45 requests/minute)
                $response = Http::get("http://ip-api.com/json/{$ip}", [
                    'fields' => 'status,countryCode',
                ]);

                if ($response->successful()) {
                    $data = $response->json();
                    return $data['countryCode'] ?? null;
                }
            } catch (\Exception $e) {
                // Silent fail
            }

            return null;
        });
    }

    /**
     * Detect city from IP address
     */
    public static function detectCity(string $ip): ?string
    {
        // Skip local IPs
        if (self::isLocalIP($ip)) {
            return null;
        }

        return Cache::remember("geo_city_{$ip}", 86400, function () use ($ip) {
            try {
                $response = Http::get("http://ip-api.com/json/{$ip}", [
                    'fields' => 'status,city',
                ]);

                if ($response->successful()) {
                    $data = $response->json();
                    return $data['city'] ?? null;
                }
            } catch (\Exception $e) {
                // Silent fail
            }

            return null;
        });
    }

    /**
     * Get full location data
     */
    public static function detectLocation(string $ip): array
    {
        if (self::isLocalIP($ip)) {
            return [
                'country' => 'local',
                'country_code' => 'local',
                'city' => null,
                'timezone' => null,
                'isp' => null,
            ];
        }

        return Cache::remember("geo_location_{$ip}", 86400, function () use ($ip) {
            try {
                $response = Http::get("http://ip-api.com/json/{$ip}");

                if ($response->successful()) {
                    $data = $response->json();
                    return [
                        'country' => $data['country'] ?? null,
                        'country_code' => $data['countryCode'] ?? null,
                        'city' => $data['city'] ?? null,
                        'region' => $data['regionName'] ?? null,
                        'timezone' => $data['timezone'] ?? null,
                        'isp' => $data['isp'] ?? null,
                        'lat' => $data['lat'] ?? null,
                        'lon' => $data['lon'] ?? null,
                    ];
                }
            } catch (\Exception $e) {
                // Silent fail
            }

            return [
                'country' => null,
                'country_code' => null,
                'city' => null,
                'region' => null,
                'timezone' => null,
                'isp' => null,
                'lat' => null,
                'lon' => null,
            ];
        });
    }

    /**
     * Check if IP is local/private
     */
    public static function isLocalIP(string $ip): bool
    {
        // Localhost
        if ($ip === '127.0.0.1' || $ip === '::1') {
            return true;
        }

        // Private IP ranges
        $privateRanges = [
            '10.',           // 10.0.0.0/8
            '172.16.',      // 172.16.0.0/12
            '192.168.',      // 192.168.0.0/16
            '127.',         // 127.0.0.0/8
            '169.254.',     // link-local
            '::1',         // IPv6 localhost
            'fe80:',        // IPv6 link-local
        ];

        foreach ($privateRanges as $range) {
            if (str_starts_with($ip, $range)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get all available countries for dropdown
     */
    public static function getCountries(): array
    {
        return [
            'AZ' => 'Azərbaycan',
            'US' => 'ABŞ',
            'RU' => 'Rusiya',
            'TR' => 'Türkiyə',
            'GB' => 'Birləşmiş Krallıq',
            'DE' => 'Almaniya',
            'FR' => 'Fransa',
            'UA' => 'Ukrayna',
            'GE' => 'Gürcüstan',
            'IR' => 'İran',
        ];
    }

    /**
     * Detect device type from user agent
     */
    public static function detectDeviceType(?string $userAgent): string
    {
        if (!$userAgent) {
            return 'desktop';
        }

        $ua = strtolower($userAgent);

        if (str_contains($ua, 'mobile') || str_contains($ua, 'android')) {
            if (str_contains($ua, 'tablet') || str_contains($ua, 'ipad')) {
                return 'tablet';
            }
            return 'mobile';
        }

        if (str_contains($ua, 'tablet') || str_contains($ua, 'ipad')) {
            return 'tablet';
        }

        return 'desktop';
    }
}
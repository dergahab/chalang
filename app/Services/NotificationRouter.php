<?php

namespace App\Services;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Notifications\Notification as BaseNotification;
use Illuminate\Support\Facades\Notification;
use App\Services\AlertService;

class NotificationRouter
{
    public static function notify(string $eventKey, BaseNotification $notification): void
    {
        $routes = self::getRoutes();

        if (!$routes) {
            self::notifyLegacy($notification);
            return;
        }

        $config = $routes[$eventKey] ?? null;
        if (!$config) {
            self::notifyLegacy($notification);
            return;
        }

        $channels = self::normalizeChannels($config['channels'] ?? []);
        $adminIds = self::normalizeIds($config['admins'] ?? []);
        $roles = self::normalizeRoles($config['roles'] ?? []);
        $emails = self::normalizeEmails($config['emails'] ?? []);

        $admins = collect();
        if (!empty($roles)) {
            $admins = $admins->merge(User::role($roles)->get());
        }
        if (!empty($adminIds)) {
            $admins = $admins->merge(User::whereIn('id', $adminIds)->get());
        }
        $admins = $admins->unique('id')->values();

        if (in_array('database', $channels, true) && $admins->isNotEmpty()) {
            $dbNotification = clone $notification;
            if (method_exists($dbNotification, 'setChannels')) {
                $dbNotification->setChannels(['database']);
            }
            Notification::send($admins, $dbNotification);
        }

        if (in_array('mail', $channels, true)) {
            $mailNotification = clone $notification;
            if (method_exists($mailNotification, 'setChannels')) {
                $mailNotification->setChannels(['mail']);
            }

            if ($admins->isNotEmpty()) {
                Notification::send($admins, $mailNotification);
            }

            foreach ($emails as $email) {
                Notification::route('mail', $email)->notify($mailNotification);
            }
        }

        if (in_array('slack', $channels, true)) {
            self::sendSlackNotification($notification);
        }
    }

    protected static function getRoutes(): ?array
    {
        $raw = Setting::getValue('notification_routing');
        if (!$raw) {
            return null;
        }

        $decoded = json_decode($raw, true);

        return is_array($decoded) ? $decoded : null;
    }

    protected static function notifyLegacy(BaseNotification $notification): void
    {
        $users = User::all();
        Notification::send($users, $notification);

        $adminEmail = Setting::getValue('alert_notification_email');
        if ($adminEmail) {
            Notification::route('mail', $adminEmail)->notify($notification);
        }

        if (config('alert.slack_webhook')) {
            self::sendSlackNotification($notification);
        }
    }

    protected static function normalizeChannels($channels): array
    {
        if (!is_array($channels)) {
            return [];
        }

        return array_values(array_unique(array_filter($channels, 'is_string')));
    }

    protected static function normalizeIds($ids): array
    {
        if (!is_array($ids)) {
            return [];
        }

        $normalized = array_map('intval', $ids);

        return array_values(array_unique(array_filter($normalized)));
    }

    protected static function normalizeEmails($emails): array
    {
        if (is_string($emails)) {
            $emails = explode(',', $emails);
        }

        if (!is_array($emails)) {
            return [];
        }

        $normalized = array_map('trim', $emails);
        $normalized = array_filter($normalized, static function ($email) {
            return $email !== '';
        });

        return array_values(array_unique($normalized));
    }

    protected static function normalizeRoles($roles): array
    {
        if (!is_array($roles)) {
            return [];
        }

        $normalized = array_map('strval', $roles);
        $normalized = array_filter($normalized, static function ($role) {
            return trim($role) !== '';
        });

        return array_values(array_unique($normalized));
    }

    protected static function sendSlackNotification(BaseNotification $notification): void
    {
        if ($notification instanceof \App\Notifications\NewMessageNotification) {
            $msg = $notification->message;
            AlertService::alert(
                AlertService::TYPE_SUCCESS,
                "Yeni Mesaj Daxil Oldu (Əlaqə)",
                "Sayt üzərindən yeni əlaqə mesajı göndərilib.",
                [
                    'Ad Soyad' => $msg->full_name,
                    'E-poçt' => $msg->email,
                    'Telefon' => $msg->phone ?? '-',
                    'Məzmun' => $msg->message,
                ],
                AlertService::CHANNEL_SLACK
            );
        } elseif ($notification instanceof \App\Notifications\NewSubmissionNotification) {
            $sub = $notification->submission;
            $typeLabel = match ($sub->type) {
                'call' => 'Zəng Sifarişi',
                'order' => 'Layihə Sifarişi (Estimator)',
                'package' => 'Paket Sifarişi',
                default => 'Yeni Müraciət',
            };
            
            $data = is_array($sub->data) ? $sub->data : json_decode($sub->data ?? '{}', true);

            AlertService::alert(
                AlertService::TYPE_SUCCESS,
                "Yeni Müraciət ({$typeLabel})",
                "Sayt üzərindən yeni {$sub->type} sorğusu daxil olub.",
                [
                    'Ad' => $data['name'] ?? $sub->name ?? 'Anonim',
                    'E-poçt' => $data['email'] ?? $sub->email ?? '-',
                    'Telefon' => $data['phone'] ?? $sub->phone ?? '-',
                    'Məzmun' => $data['message'] ?? $sub->message ?? '-',
                    'IP Ünvanı' => $sub->ip_address,
                ],
                AlertService::CHANNEL_SLACK
            );
        }
    }
}

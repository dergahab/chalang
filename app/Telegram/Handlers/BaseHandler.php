<?php

namespace App\Telegram\Handlers;

use SergiX44\Nutgram\Nutgram;
use App\Models\TelegramSubscriber;

class BaseHandler
{
    /**
     * İstifadəçinin icazəsini yoxlayır və aktivlik loqunu yazır.
     */
    protected function checkPermission(Nutgram $bot, string $permission, string $logMessage = null): bool
    {
        $subscriber = TelegramSubscriber::where('chat_id', (string)$bot->chatId())->where('is_active', true)->first();
        
        if (!$subscriber) {
            $bot->sendMessage(text: __('telegram.error_unlinked'), parse_mode: 'HTML');
            return false;
        }

        // Faza 5: JSON əvəzinə Spatie Role/Permission istifadəsi (Əgər super-admin deyilsə, yoxla)
        $user = $subscriber->user;
        if (!$user) {
            $bot->sendMessage(text: __('telegram.error_permission'), parse_mode: 'HTML');
            return false;
        }

        // Super Admin hər şeyə icazəlidir
        $hasPermission = $user->hasRole('super-admin');

        // Spatie üzərindən telegram.{permission} icazəsi və ya JSON fallback
        if (!$hasPermission && $user->hasPermissionTo("telegram.{$permission}")) {
            $hasPermission = true;
        }

        // Qeyd: Keçid (Migration) dövrü üçün JSON settings-i fallback olaraq saxlayırıq. 
        // Tam keçiddən sonra bu blok silinə bilər.
        if (!$hasPermission && ($subscriber->notification_settings[$permission] ?? false)) {
            $hasPermission = true;
        }

        if (!$hasPermission) {
            $bot->sendMessage(text: __('telegram.error_permission'), parse_mode: 'HTML');
            return false;
        }

        if ($logMessage) {
            activity()
                ->causedBy($subscriber->user)
                ->log($logMessage);
        }

        return true;
    }
}

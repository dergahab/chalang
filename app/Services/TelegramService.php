<?php

namespace App\Services;

use SergiX44\Nutgram\Nutgram;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class TelegramService
{
    protected Nutgram $bot;
    protected ?string $adminChatId;

    public function __construct(Nutgram $bot)
    {
        $this->bot = $bot;
        
        // Priority: DB Settings -> config/env
        $dbAdminId = \App\Models\Setting::where('key', 'telegram_admin_chat_id')->first()?->value;
        $this->adminChatId = $dbAdminId ?? config('nutgram.admin_chat_id') ?? env('TELEGRAM_ADMIN_CHAT_ID');

        $dbToken = \App\Models\Setting::where('key', 'telegram_token')->first()?->value;
        if ($dbToken && $dbToken !== config('nutgram.token')) {
            // Re-initialize bot with new token if provided in DB
            config(['nutgram.token' => $dbToken]);
        }
    }

    // ============================================
    // ÜMUMİ METODLAR
    // ============================================

    /**
     * Mesajı müvafiq abunəçilərə növbə ilə göndər
     */
    public function dispatchMessage(string $message, ?string $type = null, array $options = []): void
    {
        // 1. Find subscribers who have this notification type enabled
        $query = \App\Models\TelegramSubscriber::where('is_active', true);

        if ($type) {
            $query->where("notification_settings->{$type}", true);
        }

        $subscribers = $query->get();

        // 2. If no specific subscribers found, fallback to main admin if type is null
        if ($subscribers->isEmpty() && $this->adminChatId) {
            \App\Jobs\ProcessTelegramNotification::dispatch((string)$this->adminChatId, $message, $options);
            return;
        }

        // 3. Dispatch for each subscriber
        foreach ($subscribers as $sub) {
            $currentOptions = $options;
            if ($sub->is_silent) {
                $currentOptions['disable_notification'] = true;
            }
            \App\Jobs\ProcessTelegramNotification::dispatch((string)$sub->chat_id, $message, $currentOptions);
        }
    }

    /**
     * Admin-a mesaj göndər (Növbəyə salır)
     */
    public function sendToAdmin(string $message, array $options = []): bool
    {
        $this->dispatchMessage($message, null, $options);
        return true;
    }

    /**
     * Inline buttons ilə mesaj göndər (Növbəyə salır)
     */
    public function sendWithButtons(string $message, array $buttons): bool
    {
        $inlineButtons = [];
        foreach ($buttons as $button) {
            $inlineButtons[] = [
                'text' => $button['text'], 
                'url' => $button['url'] ?? null, 
                'callback_data' => $button['callback'] ?? null
            ];
        }

        $options = [
            'reply_markup' => json_encode(['inline_keyboard' => array_chunk($inlineButtons, 2)])
        ];

        $this->dispatchMessage($message, null, $options);
        return true;
    }

    // ============================================
    // İSTİFADƏÇİ HADİSƏLƏRİ
    // ============================================

    /**
     * Yeni müraciət (lead/contact)
     */
    public function notifyNewLead(array $leadData): bool
    {
        $message = "<b>🚀 Yeni Müraciət!</b>\n\n" .
                   "<b>Müştəri:</b> " . ($leadData['name'] ?? 'Naməlum') . "\n" .
                   "<b>Email:</b> " . ($leadData['email'] ?? '-') . "\n" .
                   "<b>Telefon:</b> " . ($leadData['phone'] ?? '-') . "\n" .
                   "<b>Mövzu:</b> " . ($leadData['subject'] ?? '-') . "\n" .
                   "<b>Mesaj:</b> " . ($leadData['message'] ?? '-');

        $this->dispatchMessage($message, 'leads_commands', [
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [['text' => '📩 Birbaşa Cavabla', 'callback_data' => 'reply_lead_' . ($leadData['id'] ?? 0)]],
                    [
                        ['text' => '✅ Qəbul', 'callback_data' => 'approve_lead_' . ($leadData['id'] ?? 0)],
                        ['text' => '❌ Rədd', 'callback_data' => 'reject_lead_' . ($leadData['id'] ?? 0)]
                    ],
                    [['text' => '🔗 Saytda Aç', 'url' => url('/admin/message/' . ($leadData['id'] ?? ''))]]
                ]
            ])
        ]);
        return true;
    }

    /**
     * Gecikən cavab (Müştəri mesajına 30 dəqiqə+ cavab verilməyib)
     */
    public function notifyDelayedReply(array $leadData, int $minutes): bool
    {
        $message = "<b>⏱️ Gecikən Cavab Xəbərdarlığı!</b>\n\n" .
                   "<b>Müştəri:</b> " . ($leadData['full_name'] ?? 'Naməlum') . "\n" .
                   "<b>Gecikmə:</b> <code>{$minutes} dəqiqə</code>\n" .
                   "<b>Mövzu:</b> " . ($leadData['subject'] ?? '-') . "\n\n" .
                   "⚠️ Müştəri hələ də cavab gözləyir. Lütfən operativ müdaxilə edin.";

        $this->dispatchMessage($message, 'delayed_replies', [
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [['text' => '📩 İndi Cavabla (Telegram)', 'callback_data' => 'reply_lead_' . ($leadData['id'] ?? 0)]],
                    [['text' => '🔗 Saytda Aç', 'url' => url('/admin/message/' . ($leadData['id'] ?? ''))]]
                ]
            ])
        ]);

        return true;
    }

    /**
     * Yeni abunə (subscribe)
     */
    public function notifyNewSubscription(string $email): bool
    {
        $message = "<b>📧 Yeni Abunə!</b>\n\n" .
                   "<b>Email:</b> <code>{$email}</code>\n" .
                   "<b>Vaxt:</b> " . now()->format('d.m.Y H:i');

        return $this->sendToAdmin($message);
    }

    /**
     * Yeni istifadəçi qeydiyyatı
     */
    public function notifyNewUser(array $userData): bool
    {
        $message = "<b>👤 Yeni İstifadəçi!</b>\n\n" .
                   "<b>Ad:</b> " . ($userData['name'] ?? 'Naməlum') . "\n" .
                   "<b>Email:</b> " . ($userData['email'] ?? '-') . "\n" .
                   "<b>Rol:</b> " . ($userData['role'] ?? 'user') . "\n" .
                   "<b>Vaxt:</b> " . now()->format('d.m.Y H:i');

        return $this->sendToAdmin($message);
    }

    /**
     * Admin daxil oldu
     */
    public function notifyLogin(array $userData): bool
    {
        $message = "<b>🔐 Admin Girişi!</b>\n\n" .
                   "<b>İstifadəçi:</b> " . ($userData['name'] ?? 'Naməlum') . "\n" .
                   "<b>Email:</b> " . ($userData['email'] ?? '-') . "\n" .
                   "<b>IP:</b> <code>" . ($userData['ip'] ?? request()->ip()) . "</code>\n" .
                   "<b>Vaxt:</b> " . now()->format('d.m.Y H:i');

        return $this->sendToAdmin($message);
    }

    /**
     * Uğursuz login cəhdı
     */
    public function notifyFailedLogin(string $email, string $ip): bool
    {
        $message = "<b>⚠️ Uğursuz Giriş Cəhdı!</b>\n\n" .
                   "<b>Email:</b> <code>{$email}</code>\n" .
                   "<b>IP:</b> <code>{$ip}</code>\n" .
                   "<b>Vaxt:</b> " . now()->format('d.m.Y H:i');

        return $this->sendToAdmin($message);
    }

    // ============================================
    // MƏLUMAT İDXAL/İXRAC
    // ============================================

    /**
     * Import nəticəsi
     */
    public function notifyImport(string $modelType, int $successCount, int $failedCount, array $errors = []): bool
    {
        $message = "<b>📥 Import Nəticəsi</b>\n\n" .
                   "<b>Model:</b> {$modelType}\n" .
                   "<b>Uğurlu:</b> ✅ {$successCount}\n" .
                   "<b>Uğursuz:</b> ❌ {$failedCount}";

        if (!empty($errors)) {
            $message .= "\n\n<b>Xətalar:</b>";
            foreach (array_slice($errors, 3) as $error) {
                $message .= "\n• " . substr($error, 0, 50);
            }
        }

        $message .= "\n<b>Vaxt:</b> " . now()->format('d.m.Y H:i');

        return $this->sendToAdmin($message);
    }

    /**
     * Export nəticəsi
     */
    public function notifyExport(string $modelType, int $count, string $filePath): bool
    {
        $message = "<b>📤 Export Nəticəsi</b>\n\n" .
                   "<b>Model:</b> {$modelType}\n" .
                   "<b>Cəmi:</b> {$count} yazı\n" .
                   "<b>Fayl:</b> <code>{$filePath}</code>\n" .
                   "<b>Vaxt:</b> " . now()->format('d.m.Y H:i');

        return $this->sendToAdmin($message);
    }

    // ============================================
    // SİSTEM HADİSƏLƏRİ
    // ============================================

    /**
     * Yavaş sorğu
     */
    public function notifySlowRequest(string $url, float $duration): bool
    {
        $message = "<b>⚠️ Yavaş Sorğu!</b>\n\n" .
                   "<b>URL:</b> <code>{$url}</code>\n" .
                   "<b>Müddət:</b> <code>" . round($duration) . "ms</code>\n" .
                   "<b>IP:</b> <code>" . request()->ip() . "</code>";

        $this->dispatchMessage($message, 'server_commands');
        return true;
    }

    /**
     * PHP xətası
     */
    public function notifyError(string $error, string $file, int $line): bool
    {
        $message = "<b>❌ PHP Xətası!</b>\n\n" .
                   "<b>Xəta:</b> " . substr($error, 0, 100) . "\n" .
                   "<b>Fayl:</b> <code>{$file}:{$line}</code>\n" .
                   "<b>URL:</b> <code>" . request()->fullUrl() . "</code>\n" .
                   "<b>Vaxt:</b> " . now()->format('d.m.Y H:i');

        return $this->sendToAdmin($message);
    }

    /**
     * Database xətası
     */
    public function notifyDatabaseError(string $query, string $error): bool
    {
        $message = "<b>🗄️ Database Xətası!</b>\n\n" .
                   "<b>Sorğu:</b> <code>" . substr($query, 0, 80) . "</code>\n" .
                   "<b>Xəta:</b> " . substr($error, 0, 80);

        return $this->sendToAdmin($message);
    }

    /**
     * Disk sahəsi azalıb
     */
    public function notifyLowDiskSpace(int $freePercent): bool
    {
        $message = "<b>💾 Disk Sahəsi Az!</b>\n\n" .
                   "<b>Boş yer:</b> <code>{$freePercent}%</code>\n" .
                   "<b>Server:</b> " . gethostname() . "\n" .
                   "<b>Vaxt:</b> " . now()->format('d.m.Y H:i');

        return $this->sendToAdmin($message);
    }

    /**
     * Yaddaş (RAM) azalıb
     */
    public function notifyLowMemory(int $usedPercent): bool
    {
        $message = "<b>🧠 Yaddaş Az!</b>\n\n" .
                   "<b>İstifadə:</b> <code>{$usedPercent}%</code>\n" .
                   "<b>Server:</b> " . gethostname() . "\n" .
                   "<b>Vaxt:</b> " . now()->format('d.m.Y H:i');

        return $this->sendToAdmin($message);
    }

    /**
     * Cache təmizləndi
     */
    public function notifyCacheClear(string $type): bool
    {
        $message = "<b>🗑️ Cache Təmizləndi!</b>\n\n" .
                   "<b>Növ:</b> {$type}\n" .
                   "<b>İstifadəçi:</b> " . (auth()->user()->name ?? 'System') . "\n" .
                   "<b>Vaxt:</b> " . now()->format('d.m.Y H:i');

        return $this->sendToAdmin($message);
    }

    // ============================================
    // A/B TEST HADİSƏLƏRİ
    // ============================================

    /**
     * Yeni experiment başladı
     */
    public function notifyExperimentStarted(array $experiment): bool
    {
        $message = "<b>🧪 Experiment Başladı!</b>\n\n" .
                   "<b>Ad:</b> " . ($experiment['name'] ?? 'Naməlum') . "\n" .
                   "<b>Traffic:</b> " . ($experiment['traffic_percentage'] ?? 0) . "%\n" .
                   "<b>Variant sayı:</b> " . ($experiment['variants_count'] ?? 0) . "\n" .
                   "<b>Vaxt:</b> " . now()->format('d.m.Y H:i');

        return $this->sendToAdmin($message);
    }

    /**
     * Experiment bitdi (qalib olan var)
     */
    public function notifyExperimentComplete(array $experiment, array $winner): bool
    {
        $message = "<b>🏆 Experiment Bitdi!</b>\n\n" .
                   "<b>Ad:</b> " . ($experiment['name'] ?? 'Naməlum') . "\n" .
                   "<b>Qalib variant:</b> " . ($winner['name'] ?? '-') . "\n" .
                   "<b>Təsir:</b> +" . ($winner['improvement'] ?? 0) . "%\n" .
                   "<b>Ehtimal:</b> " . ($winner['confidence'] ?? 0) . "%";

        return $this->sendToAdmin($message);
    }

    // ============================================
    // BULK HADİSƏLƏRİ
    // ============================================

    /**
     * Bulk əməliyyat tamamlandı
     */
    public function notifyBulkAction(string $action, string $model, int $count): bool
    {
        $message = "<b>🔄 Bulk {$action}!</b>\n\n" .
                   "<b>Model:</b> {$model}\n" .
                   "<b>Cəmi:</b> {$count} yazı\n" .
                   "<b>İstifadəçi:</b> " . (auth()->user()->name ?? 'System') . "\n" .
                   "<b>Vaxt:</b> " . now()->format('d.m.Y H:i');

        return $this->sendToAdmin($message);
    }

    /**
     * Scheduled action icra oldu
     */
    public function notifyScheduledAction(string $name, int $success, int $failed): bool
    {
        $message = "<b>⏰ Scheduled Action!</b>\n\n" .
                   "<b>Ad:</b> {$name}\n" .
                   "<b>Uğurlu:</b> ✅ {$success}\n" .
                   "<b>Uğursuz:</b> ❌ {$failed}\n" .
                   "<b>Vaxt:</b> " . now()->format('d.m.Y H:i');

        return $this->sendToAdmin($message);
    }

    // ============================================
    // SİSTEM İNFORMASİYASI
    // ============================================

    /**
     * Günlük statistika
     */
    public function notifyDailyStats(array $stats): bool
    {
        $message = "<b>📊 Günlük Statistikа</b>\n\n" .
                   "<b>İstifadəçilər:</b> " . ($stats['users'] ?? 0) . "\n" .
                   "<b>Müraciətlər:</b> " . ($stats['leads'] ?? 0) . "\n" .
                   "<b>Abunələr:</b> " . ($stats['subscribers'] ?? 0) . "\n" .
                   "<b>Portal ziyarətləri:</b> " . ($stats['visitors'] ?? 0) . "\n" .
                   "<b>Vaxt:</b> " . now()->format('d.m.Y H:i');

        $this->dispatchMessage($message, 'stats_commands');
        return true;
    }

    /**
     * Sistem sağlamlığı
     */
    public function notifySystemHealth(array $health): bool
    {
        $status = ($health['status'] ?? 'unknown') === 'healthy' ? '✅' : '⚠️';
        
        $message = "<b>{$status} Sistem Sağlamlığı</b>\n\n" .
                   "<b>Status:</b> " . ($health['status'] ?? 'Naməlum') . "\n" .
                   "<b>CPU:</b> " . ($health['cpu'] ?? 0) . "%\n" .
                   "<b>RAM:</b> " . ($health['memory'] ?? 0) . "%\n" .
                   "<b>Disk:</b> " . ($health['disk'] ?? 0) . "%\n" .
                   "<b>Request sayı:</b> " . ($health['requests'] ?? 0) . "\n" .
                   "<b>Vaxt:</b> " . now()->format('d.m.Y H:i');

        return $this->sendToAdmin($message);
    }
}
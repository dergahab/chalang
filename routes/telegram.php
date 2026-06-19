<?php

use SergiX44\Nutgram\Nutgram;
use App\Telegram\Handlers\MenuHandler;
use App\Telegram\Handlers\StatsHandler;
use App\Telegram\Handlers\SystemHandler;
use App\Telegram\Handlers\LeadsHandler;

/*
|--------------------------------------------------------------------------
| Security & Middlewares
|--------------------------------------------------------------------------
*/

$bot->middleware(function (Nutgram $bot, $next) {
    $userId = $bot->userId();
    if (!$userId) return $next($bot);

    $key = 'tg_rate_' . $userId;
    // Maksimum 20 komanda 1 dəqiqə ərzində
    if (\Illuminate\Support\Facades\RateLimiter::tooManyAttempts($key, 20)) {
        if (\Illuminate\Support\Facades\RateLimiter::attempts($key) === 21) {
            $bot->sendMessage("⚠️ <b>Sistem Qorunması (Rate Limit):</b>\nÇox sürətlə sorğu atırsınız. Lütfən 1 dəqiqə gözləyin.", parse_mode: 'HTML');
        }
        return; // Drop request
    }
    \Illuminate\Support\Facades\RateLimiter::hit($key, 60);
    
    return $next($bot);
});

/*
|--------------------------------------------------------------------------
| Menus & Navigation
|--------------------------------------------------------------------------
*/

$bot->onCommand('start', function (Nutgram $bot) {
    $text = $bot->message()->text;
    if (str_contains($text, ' ')) {
        $code = strtoupper(explode(' ', $text)[1]);
        return linkSubscriber($bot, $code);
    }
    return $bot->sendMessage(
        text: str_replace(':chat_id', $bot->chatId(), __('telegram.welcome_message')),
        parse_mode: 'HTML',
        reply_markup: MenuHandler::getMainKeyboard()
    );
})->description('Botu başladır və ana menyunu göstərir');

$bot->onText('.*Ana Menyu.*', [MenuHandler::class, 'main']);
$bot->onText('.*Aktivlik.*', [MenuHandler::class, 'aktivlik']);
$bot->onText('.*İnsaytlar.*', [MenuHandler::class, 'insaytlar']);
$bot->onText('.*Ayarlar.*', [MenuHandler::class, 'ayarlar']);

$bot->onCallbackQueryData('go_home_inline', [MenuHandler::class, 'main']);
$bot->onCallbackQueryData('nav_aktivlik', [MenuHandler::class, 'aktivlik']);
$bot->onCallbackQueryData('nav_insaytlar', [MenuHandler::class, 'insaytlar']);
$bot->onCallbackQueryData('nav_ayarlar', [MenuHandler::class, 'ayarlar']);

$bot->onCallbackQueryData('go_home', [LeadsHandler::class, 'goHome']);
$bot->onCallbackQueryData('cancel_action', [SystemHandler::class, 'cancelAction']);

/*
|--------------------------------------------------------------------------
| Logic Handlers
|--------------------------------------------------------------------------
*/

// Aktivlik
$bot->onText('.*Statistika.*', [StatsHandler::class, 'showStats']);
$bot->onCallbackQueryData('refresh_stats', [StatsHandler::class, 'showStats']);

$bot->onText('.*Server Status.*', [StatsHandler::class, 'serverStatus']);
$bot->onCallbackQueryData('refresh_server_status', [StatsHandler::class, 'serverStatus']);

// İnsaytlar
$bot->onText('.*Son Müraciətlər.*', [LeadsHandler::class, 'latestLeads']);
$bot->onCallbackQueryData('list_leads_{index}', [LeadsHandler::class, 'latestLeads']);
$bot->onText('.*Abunəçilər.*', [LeadsHandler::class, 'listSubscribers']);
$bot->onCallbackQueryData('refresh_subscribers', [LeadsHandler::class, 'listSubscribers']);

// Ayarlar (System Maintenance & Cache)
$bot->onText('.*Keşi Təmizlə.*', [SystemHandler::class, 'askCacheClear']);
$bot->onCallbackQueryData('ask_clear_cache', [SystemHandler::class, 'askCacheClear']);
$bot->onCallbackQueryData('confirm_clear_cache', [SystemHandler::class, 'confirmCacheClear']);

$bot->onText('.*Bakım Modu.*', [SystemHandler::class, 'askMaintenance']);
$bot->onCallbackQueryData('ask_maintenance', [SystemHandler::class, 'askMaintenance']);
$bot->onCallbackQueryData('confirm_maintenance', [SystemHandler::class, 'confirmMaintenance']);

use App\Telegram\Handlers\ReplyHandler;

/*
|--------------------------------------------------------------------------
| System & Pairing
|--------------------------------------------------------------------------
*/

$bot->onCommand('help', function (Nutgram $bot) {
    return $bot->sendMessage(text: __('telegram.help_message'), parse_mode: 'HTML');
});

$bot->onText('([A-Z0-9]{6})', function (Nutgram $bot, $code) {
    return linkSubscriber($bot, strtoupper($code));
});

function linkSubscriber(Nutgram $bot, $code) {
    $subscriber = \App\Models\TelegramSubscriber::where('verification_code', $code)->whereNull('chat_id')->first();
    if (!$subscriber) return $bot->sendMessage(text: __('telegram.error_invalid_code'), parse_mode: 'HTML');
    
    if ($subscriber->verification_code_expires_at && $subscriber->verification_code_expires_at->isPast()) {
        $subscriber->delete();
        return $bot->sendMessage(text: __('telegram.error_expired_code'), parse_mode: 'HTML');
    }

    $subscriber->update(['chat_id' => (string)$bot->chatId(), 'username' => $bot->user()->username ?? $bot->user()->first_name, 'verification_code' => null, 'verification_code_expires_at' => null, 'is_active' => true]);
    return $bot->sendMessage(text: __('telegram.success_linked'), parse_mode: 'HTML', reply_markup: MenuHandler::getMainKeyboard());
}

/*
|--------------------------------------------------------------------------
| Replies & Actions
|--------------------------------------------------------------------------
*/

$bot->onCallbackQueryData('reply_lead_{id}', [ReplyHandler::class, 'initReply']);
$bot->onCallbackQueryData('approve_lead_{id}', [ReplyHandler::class, 'handleApproveReject']);
$bot->onCallbackQueryData('reject_lead_{id}', [ReplyHandler::class, 'handleApproveReject']);

// Bütün daxil olan adi mətn mesajları (əgər rejimdədirsə, reply handler tutacaq)
$bot->onMessage([ReplyHandler::class, 'handleIncomingReply']);

$bot->fallback(function (Nutgram $bot) {
    return $bot->sendMessage(__('telegram.error_fallback'), parse_mode: 'HTML', reply_markup: MenuHandler::getMainKeyboard());
});

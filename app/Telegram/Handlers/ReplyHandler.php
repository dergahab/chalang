<?php

declare(strict_types=1);

namespace App\Telegram\Handlers;

use SergiX44\Nutgram\Nutgram;
use App\Models\Message;
use App\Models\TelegramSubscriber;
use App\Notifications\NewSubmissionNotification;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class ReplyHandler extends BaseHandler
{
    // Cache key prefix for pending replies (chat_id → lead_id)
    private const PENDING_REPLY_PREFIX = 'tg_pending_reply_';

    /**
     * Admin "Cavabla" düyməsini tıkladı → cavab gözləmə vəziyyəti başladır
     * callback_data format: reply_lead_{lead_id}
     */
    public function initReply(Nutgram $bot): void
    {
        if (!$this->checkPermission($bot, 'leads_commands')) return;

        $data      = $bot->callbackQuery()->data ?? '';
        $leadId    = (int) str_replace('reply_lead_', '', $data);
        $lead      = Message::find($leadId);
        $chatId    = (string) $bot->chatId();

        if (!$lead) {
            $bot->answerCallbackQuery(text: '❌ Müraciət tapılmadı.', show_alert: true);
            return;
        }

        // 10 dəqiqə boyunca cavab vəziyyətini saxla
        Cache::put(self::PENDING_REPLY_PREFIX . $chatId, $leadId, now()->addMinutes(10));

        $bot->answerCallbackQuery();
        $bot->sendMessage(
            text: "✏️ <b>Cavab Rejimi Aktiv</b>\n\n"
                . "📌 <b>Müraciət:</b> {$lead->full_name}\n"
                . "📩 <b>E-poçt:</b> <code>{$lead->email}</code>\n\n"
                . "Cavabınızı yazın. Ləğv etmək üçün /cancel göndərin.",
            parse_mode: 'HTML'
        );
    }

    /**
     * Admin cavab yazdı → müştəriyə e-poçt göndər
     */
    public function handleIncomingReply(Nutgram $bot): void
    {
        $chatId  = (string) $bot->chatId();
        $cacheKey = self::PENDING_REPLY_PREFIX . $chatId;

        // Cavab gözləmə vəziyyəti yoxlanılır
        $leadId = Cache::get($cacheKey);
        if (!$leadId) return; // bu mesaj cavab deyil, fallback-ə burax

        $text = $bot->message()?->text ?? '';

        // /cancel əmri
        if (strtolower(trim($text)) === '/cancel') {
            Cache::forget($cacheKey);
            $bot->sendMessage('❌ Cavab ləğv edildi.', reply_markup: \App\Telegram\Handlers\MenuHandler::getMainKeyboard());
            return;
        }

        $lead = Message::find($leadId);
        if (!$lead) {
            Cache::forget($cacheKey);
            $bot->sendMessage('❌ Müraciət artıq mövcud deyil.');
            return;
        }

        try {
            // Müştəriyə e-poçt bildirişi göndər
            \Notification::route('mail', $lead->email)
                ->notify(new \App\Notifications\TelegramReplyNotification($lead, $text));

            Cache::forget($cacheKey);

            // Subscriber-i tap ki adını göstərə bilək
            $subscriber = TelegramSubscriber::where('chat_id', $chatId)->with('user')->first();
            $adminName  = $subscriber?->user?->name ?? 'Admin';

            activity()
                ->causedBy($subscriber?->user)
                ->log("Telegram üzərindən müraciətə cavab verildi → {$lead->full_name} ({$lead->email})");

            $bot->sendMessage(
                text: "✅ <b>Cavab Göndərildi!</b>\n\n"
                    . "👤 <b>Alıcı:</b> {$lead->full_name}\n"
                    . "📩 <b>E-poçt:</b> <code>{$lead->email}</code>\n\n"
                    . "📝 <b>Cavabınız:</b>\n<i>{$text}</i>",
                parse_mode: 'HTML',
                reply_markup: MenuHandler::getMainKeyboard()
            );
        } catch (\Exception $e) {
            Log::error("Telegram reply failed: " . $e->getMessage());
            $bot->sendMessage('❌ Cavab göndərilərkən xəta baş verdi: ' . $e->getMessage());
        }
    }

    /**
     * Approve/Reject callback handler
     * callback_data: approve_lead_{id} | reject_lead_{id}
     */
    public function handleApproveReject(Nutgram $bot): void
    {
        if (!$this->checkPermission($bot, 'leads_commands')) return;

        $data   = $bot->callbackQuery()->data ?? '';
        $action = str_starts_with($data, 'approve_lead_') ? 'approve' : 'reject';
        $leadId = (int) str_replace(['approve_lead_', 'reject_lead_'], '', $data);
        $lead   = Message::find($leadId);

        if (!$lead) {
            $bot->answerCallbackQuery(text: '❌ Müraciət tapılmadı.', show_alert: true);
            return;
        }

        $statusMap = ['approve' => 'approved', 'reject' => 'rejected'];
        $emojiMap  = ['approve' => '✅', 'reject' => '❌'];

        // Statusu yenilə
        if (in_array($action, array_keys($statusMap))) {
            $lead->update(['status' => $statusMap[$action]]);
        }

        $bot->answerCallbackQuery(
            text: $emojiMap[$action] . ' Müraciət ' . ($action === 'approve' ? 'qəbul edildi' : 'rədd edildi'),
            show_alert: true
        );

        $bot->editMessageText(
            text: ($action === 'approve' ? '✅' : '❌') . " <b>Müraciət {$statusMap[$action]}</b>\n\n"
                . "👤 {$lead->full_name}\n"
                . "📩 {$lead->email}\n"
                . "⏰ " . now()->format('d.m.Y H:i'),
            parse_mode: 'HTML'
        );
    }
}

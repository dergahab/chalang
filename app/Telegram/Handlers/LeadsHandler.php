<?php

namespace App\Telegram\Handlers;

use SergiX44\Nutgram\Nutgram;
use App\Models\Message;
use App\Models\TelegramSubscriber;
use Illuminate\Support\Str;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton;

class LeadsHandler extends BaseHandler
{
    public function latestLeads(Nutgram $bot, int $index = 0)
    {
        if (!$this->checkPermission($bot, 'leads_commands', $index === 0 ? __('telegram.log_leads_checked') : null)) return;

        // Callback-dən index oxumaq (əgər varsa)
        if ($bot->isCallbackQuery()) {
            $data = $bot->callbackQuery()->data;
            if (str_starts_with($data, 'list_leads_')) {
                $index = (int) str_replace('list_leads_', '', $data);
            }
        }

        $leads = Message::orderBy('id', 'desc')->limit(10)->get();
        
        if ($leads->isEmpty()) {
            return $bot->sendMessage(__('telegram.leads_empty'));
        }

        $total = $leads->count();
        if ($index >= $total) $index = $total - 1;
        if ($index < 0) $index = 0;

        $lead = $leads[$index];
        
        // Status üçün emoji və mətn
        $statusEmoji = match($lead->status) {
            'approved' => '✅',
            'rejected' => '❌',
            default => '⏳'
        };

        $response = "<b>📩 Müraciət " . ($index + 1) . " / {$total}</b>\n"
                  . "───────────────────\n"
                  . "👤 <b>Ad:</b> {$lead->full_name}\n"
                  . "📧 <b>E-poçt:</b> <code>{$lead->email}</code>\n"
                  . "📞 <b>Tel:</b> <code>{$lead->phone}</code>\n"
                  . "📊 <b>Status:</b> {$statusEmoji} <code>{$lead->status}</code>\n"
                  . "📅 <b>Tarix:</b> " . $lead->created_at->format('d.m.Y H:i') . "\n\n"
                  . "📝 <b>Məzmun:</b>\n<i>" . Str::limit($lead->message, 300) . "</i>";

        $keyboard = InlineKeyboardMarkup::make();

        // İdarəetmə Düymələri
        if ($lead->status === 'pending') {
            $keyboard->addRow(
                InlineKeyboardButton::make('✅ Təsdiqlə', callback_data: "approve_lead_{$lead->id}"),
                InlineKeyboardButton::make('❌ Rədd et', callback_data: "reject_lead_{$lead->id}")
            );
        }
        
        $keyboard->addRow(InlineKeyboardButton::make('✉️ Cavabla', callback_data: "reply_lead_{$lead->id}"));

        // Naviqasiya Düymələri
        $navRow = [];
        if ($index > 0) {
            $navRow[] = InlineKeyboardButton::make('◀️ Geri', callback_data: "list_leads_" . ($index - 1));
        }
        if ($index < $total - 1) {
            $navRow[] = InlineKeyboardButton::make('İrəli ▶️', callback_data: "list_leads_" . ($index + 1));
        }
        
        if (!empty($navRow)) {
            $keyboard->addRow(...$navRow);
        }

        $keyboard->addRow(InlineKeyboardButton::make('🏠 Ana Menyu', callback_data: 'go_home'));

        if ($bot->isCallbackQuery()) {
            $bot->editMessageText($response, parse_mode: 'HTML', reply_markup: $keyboard);
            $bot->answerCallbackQuery();
        } else {
            $bot->sendMessage(text: $response, parse_mode: 'HTML', reply_markup: $keyboard);
        }
    }

    public function listSubscribers(Nutgram $bot)
    {
        if (!$this->checkPermission($bot, 'leads_commands')) return;

        $subs = TelegramSubscriber::whereNotNull('chat_id')->get();
        $response = __('telegram.subs_title') . "\n\n";
        
        foreach ($subs as $sub) {
            $response .= "• " . ($sub->user->full_name ?? __('telegram.subs_unknown')) . " (@{$sub->username})\n";
        }

        $keyboard = InlineKeyboardMarkup::make()
            ->addRow(InlineKeyboardButton::make(__('telegram.btn_refresh'), callback_data: 'refresh_subscribers'))
            ->addRow(InlineKeyboardButton::make(__('telegram.btn_home'), callback_data: 'go_home'));

        if ($bot->isCallbackQuery()) {
            $bot->editMessageText($response, parse_mode: 'HTML', reply_markup: $keyboard);
            $bot->answerCallbackQuery();
        } else {
            $bot->sendMessage(text: $response, parse_mode: 'HTML', reply_markup: $keyboard);
        }
    }

    public function goHome(Nutgram $bot)
    {
        (new MenuHandler())->main($bot);
    }
}

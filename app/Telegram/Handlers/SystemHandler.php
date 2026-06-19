<?php

namespace App\Telegram\Handlers;

use SergiX44\Nutgram\Nutgram;
use App\Models\Setting;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton;

class SystemHandler extends BaseHandler
{
    public function askCacheClear(Nutgram $bot)
    {
        if (!$this->checkPermission($bot, 'maintenance_commands')) return;

        $text = __('telegram.cache_warning');
        $keyboard = self::getConfirmationKeyboard('clear_cache');

        if ($bot->isCallbackQuery()) {
            $bot->editMessageText($text, parse_mode: 'HTML', reply_markup: $keyboard);
            $bot->answerCallbackQuery();
        } else {
            $bot->sendMessage($text, parse_mode: 'HTML', reply_markup: $keyboard);
        }
    }

    public function confirmCacheClear(Nutgram $bot)
    {
        if (!$this->checkPermission($bot, 'maintenance_commands')) {
            return $bot->answerCallbackQuery(text: __('telegram.error_permission'));
        }

        $bot->editMessageText(__('telegram.cache_processing'), parse_mode: 'HTML');

        try {
            Artisan::call('optimize:clear');
            
            $subscriber = \App\Models\TelegramSubscriber::where('chat_id', (string)$bot->chatId())->first();
            activity()->causedBy($subscriber->user)->log(__('telegram.log_cache_cleared'));
            
            $keyboard = InlineKeyboardMarkup::make()->addRow(InlineKeyboardButton::make('⬅️ Geri (Ayarlar)', callback_data: 'nav_ayarlar'));
            $bot->editMessageText(__('telegram.cache_success'), parse_mode: 'HTML', reply_markup: $keyboard);
        } catch (\Exception $e) {
            Log::error('Telegram Optimize Clear Error: ' . $e->getMessage());
            $bot->editMessageText(__('telegram.error_system'), parse_mode: 'HTML');
        }
        
        $bot->answerCallbackQuery();
    }

    public function askMaintenance(Nutgram $bot)
    {
        if (!$this->checkPermission($bot, 'maintenance_commands')) return;

        $currentStatus = \App\Models\Setting::getValue('maintenance_mode');
        $modeText = $currentStatus ? __('telegram.maintenance_status_on') : __('telegram.maintenance_status_off');
        $text = str_replace(':status', $modeText, __('telegram.maintenance_warning'));
        $keyboard = self::getConfirmationKeyboard('maintenance');

        if ($bot->isCallbackQuery()) {
            $bot->editMessageText($text, parse_mode: 'HTML', reply_markup: $keyboard);
            $bot->answerCallbackQuery();
        } else {
            $bot->sendMessage($text, parse_mode: 'HTML', reply_markup: $keyboard);
        }
    }

    public function confirmMaintenance(Nutgram $bot)
    {
        if (!$this->checkPermission($bot, 'maintenance_commands')) {
            return $bot->answerCallbackQuery(text: __('telegram.error_permission'));
        }

        $bot->editMessageText(__('telegram.maintenance_processing'), parse_mode: 'HTML');

        try {
            $currentStatus = \App\Models\Setting::getValue('maintenance_mode');
            Artisan::call($currentStatus ? 'up' : 'down');
            
            $newStatus = $currentStatus ? 0 : 1;
            \App\Models\Setting::updateOrCreate(['key' => 'maintenance_mode'], ['value' => $newStatus]);

            $msg = $newStatus ? __('telegram.maintenance_on') : __('telegram.maintenance_off');
            
            $subscriber = \App\Models\TelegramSubscriber::where('chat_id', (string)$bot->chatId())->first();
            activity()->causedBy($subscriber->user)->log($newStatus ? __('telegram.log_maintenance_on') : __('telegram.log_maintenance_off'));

            $keyboard = InlineKeyboardMarkup::make()->addRow(InlineKeyboardButton::make('⬅️ Geri (Ayarlar)', callback_data: 'nav_ayarlar'));
            $bot->editMessageText($msg, parse_mode: 'HTML', reply_markup: $keyboard);
        } catch (\Exception $e) {
            Log::error('Telegram Maintenance Error: ' . $e->getMessage());
            $bot->editMessageText(__('telegram.error_system'), parse_mode: 'HTML');
        }

        $bot->answerCallbackQuery();
    }

    public function cancelAction(Nutgram $bot)
    {
        $keyboard = InlineKeyboardMarkup::make()->addRow(InlineKeyboardButton::make('⬅️ Geri (Ayarlar)', callback_data: 'nav_ayarlar'));
        $bot->editMessageText(__('telegram.action_cancelled'), parse_mode: 'HTML', reply_markup: $keyboard);
        $bot->answerCallbackQuery();
    }

    public static function getConfirmationKeyboard(string $action)
    {
        return InlineKeyboardMarkup::make()
            ->addRow(
                InlineKeyboardButton::make(__('telegram.btn_yes'), callback_data: 'confirm_' . $action),
                InlineKeyboardButton::make(__('telegram.btn_no'), callback_data: 'cancel_action')
            );
    }
}

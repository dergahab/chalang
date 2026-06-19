<?php

namespace App\Telegram\Handlers;

use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Keyboard\ReplyKeyboardMarkup;
use SergiX44\Nutgram\Telegram\Types\Keyboard\KeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton;

class MenuHandler extends BaseHandler
{
    public function main(Nutgram $bot)
    {
        $text = __('telegram.menu_home_returned');
        
        if ($bot->isCallbackQuery()) {
            $bot->editMessageText($text, parse_mode: 'HTML', reply_markup: self::getInlineHomeKeyboard());
            $bot->answerCallbackQuery();
        } else {
            // Əsas menyuda həm Inline (mesajda), həm Reply (aşağıda) göstəririk
            $bot->sendMessage($text, reply_markup: self::getMainKeyboard());
        }
    }

    public function aktivlik(Nutgram $bot)
    {
        $text = __('telegram.menu_activity_desc');
        $keyboard = self::getAktivlikKeyboard();

        if ($bot->isCallbackQuery()) {
            $bot->editMessageText($text, parse_mode: 'HTML', reply_markup: $keyboard);
            $bot->answerCallbackQuery();
        } else {
            $bot->sendMessage($text, parse_mode: 'HTML', reply_markup: $keyboard);
        }
    }

    public function insaytlar(Nutgram $bot)
    {
        $text = __('telegram.menu_insights_desc');
        $keyboard = self::getInsaytlarKeyboard();

        if ($bot->isCallbackQuery()) {
            $bot->editMessageText($text, parse_mode: 'HTML', reply_markup: $keyboard);
            $bot->answerCallbackQuery();
        } else {
            $bot->sendMessage($text, parse_mode: 'HTML', reply_markup: $keyboard);
        }
    }

    public function ayarlar(Nutgram $bot)
    {
        $text = __('telegram.menu_settings_desc');
        $keyboard = self::getAyarlarKeyboard();

        if ($bot->isCallbackQuery()) {
            $bot->editMessageText($text, parse_mode: 'HTML', reply_markup: $keyboard);
            $bot->answerCallbackQuery();
        } else {
            $bot->sendMessage($text, parse_mode: 'HTML', reply_markup: $keyboard);
        }
    }

    public static function getMainKeyboard()
    {
        return \SergiX44\Nutgram\Telegram\Types\Keyboard\ReplyKeyboardMarkup::make(resize_keyboard: true)
            ->addRow(
                \SergiX44\Nutgram\Telegram\Types\Keyboard\KeyboardButton::make(__('telegram.btn_activity')), 
                \SergiX44\Nutgram\Telegram\Types\Keyboard\KeyboardButton::make(__('telegram.btn_insights'))
            )
            ->addRow(\SergiX44\Nutgram\Telegram\Types\Keyboard\KeyboardButton::make(__('telegram.btn_settings')))
            ->addRow(\SergiX44\Nutgram\Telegram\Types\Keyboard\KeyboardButton::make(__('telegram.btn_home')));
    }

    public static function getInlineHomeKeyboard()
    {
        return \SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup::make()
            ->addRow(
                \SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton::make(__('telegram.btn_activity'), callback_data: 'nav_aktivlik'),
                \SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton::make(__('telegram.btn_insights'), callback_data: 'nav_insaytlar')
            )
            ->addRow(\SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton::make(__('telegram.btn_settings'), callback_data: 'nav_ayarlar'));
    }

    public static function getAktivlikKeyboard()
    {
        return \SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup::make()
            ->addRow(
                \SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton::make(__('telegram.btn_stats'), callback_data: 'refresh_stats'),
                \SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton::make(__('telegram.btn_server_status'), callback_data: 'refresh_server_status')
            )
            ->addRow(\SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton::make('⬅️ Geri', callback_data: 'go_home_inline'));
    }

    public static function getInsaytlarKeyboard()
    {
        return \SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup::make()
            ->addRow(
                \SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton::make(__('telegram.btn_latest_leads'), callback_data: 'list_leads_0'),
                \SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton::make(__('telegram.btn_subscribers'), callback_data: 'refresh_subscribers')
            )
            ->addRow(\SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton::make('⬅️ Geri', callback_data: 'go_home_inline'));
    }

    public static function getAyarlarKeyboard()
    {
        return \SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup::make()
            ->addRow(
                \SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton::make(__('telegram.btn_clear_cache'), callback_data: 'ask_clear_cache'),
                \SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton::make(__('telegram.btn_maintenance'), callback_data: 'ask_maintenance')
            )
            ->addRow(\SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton::make('⬅️ Geri', callback_data: 'go_home_inline'));
    }
}

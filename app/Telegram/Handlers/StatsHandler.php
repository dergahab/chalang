<?php

namespace App\Telegram\Handlers;

use SergiX44\Nutgram\Nutgram;
use App\Models\AnalyticsEvent;
use App\Models\Message;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton;

class StatsHandler extends BaseHandler
{
    public function showStats(Nutgram $bot)
    {
        if (!$this->checkPermission($bot, 'stats_commands', __('telegram.log_stats_checked'))) return;

        $today = now()->startOfDay();
        $visits = AnalyticsEvent::where('event_type', 'page_view')->where('created_at', '>=', $today)->count();
        $leads = Message::where('created_at', '>=', $today)->count();

        // 7 günlük qrafik datası hazırlığı
        $days = [];
        $visitsData = [];
        $leadsData = [];
        for($i=6; $i>=0; $i--) {
            $date = now()->subDays($i)->startOfDay();
            $days[] = $date->format('d M');
            $visitsData[] = AnalyticsEvent::where('event_type', 'page_view')->whereDate('created_at', $date)->count();
            $leadsData[] = Message::whereDate('created_at', $date)->count();
        }

        $chartConfig = [
            'type' => 'bar',
            'data' => [
                'labels' => $days,
                'datasets' => [
                    ['label' => 'Ziyarətlər', 'data' => $visitsData, 'backgroundColor' => 'rgba(0, 242, 254, 0.8)'],
                    ['label' => 'Müraciətlər', 'data' => $leadsData, 'backgroundColor' => 'rgba(213, 0, 249, 0.8)']
                ]
            ],
            'options' => [
                'plugins' => [
                    'datalabels' => ['display' => true, 'align' => 'end', 'color' => '#fff']
                ]
            ]
        ];
        
        $chartUrl = 'https://quickchart.io/chart?w=600&h=300&c=' . urlencode(json_encode($chartConfig));

        $keyboard = InlineKeyboardMarkup::make()
            ->addRow(InlineKeyboardButton::make(__('telegram.btn_refresh'), callback_data: 'refresh_stats'))
            ->addRow(InlineKeyboardButton::make(__('telegram.btn_home'), callback_data: 'go_home'));

        $text = __('telegram.stats_title') . "\n\n"
              . __('telegram.stats_visitors') . " <code>{$visits}</code>\n"
              . __('telegram.stats_leads') . " <code>{$leads}</code>";

        if ($bot->isCallbackQuery()) {
            // Şəkil URL-i dəyişməyəcək qədər sabitdirsə, sadəcə caption dəyişirik. 
            // Amma qrafik dəyişirsə editMessageMedia lazımdır. QuickChart API URL-i dinamikdir, 
            // ona görə də ən yaxşısı köhnəsini silib təzəsini atmaq və ya InputMediaPhoto istifadə etməkdir.
            // Sadəlik üçün InputMediaPhoto istifadə edək:
            $media = \SergiX44\Nutgram\Telegram\Types\Input\InputMediaPhoto::make(
                media: $chartUrl,
                caption: $text,
                parse_mode: 'HTML'
            );
            
            try {
                $bot->editMessageMedia($media, reply_markup: $keyboard);
                $bot->answerCallbackQuery(text: __('telegram.stats_refreshed'));
            } catch (\Exception $e) {
                // Əgər mesaj tipi fərqlidirsə (şəkil deyildisə), köhnəsini silib yenisini at
                $bot->deleteMessage((string)$bot->chatId(), $bot->messageId());
                $bot->sendPhoto(photo: $chartUrl, caption: $text, parse_mode: 'HTML', reply_markup: $keyboard);
                $bot->answerCallbackQuery();
            }
        } else {
            $bot->sendPhoto(photo: $chartUrl, caption: $text, parse_mode: 'HTML', reply_markup: $keyboard);
        }
    }

    public function serverStatus(Nutgram $bot)
    {
        if (!$this->checkPermission($bot, 'server_commands', $bot->isCallbackQuery() ? null : __('telegram.log_server_checked'))) return;

        $cpuLoad = "0";
        $ramUsage = "N/A";
        $diskPercent = "0";

        try {
            // 1. Disk Məlumatı
            $free = @disk_free_space("C:");
            $total = @disk_total_space("C:");
            if ($total > 0) {
                $diskPercent = round((($total - $free) / $total) * 100, 1);
            }
            
            // 2. CPU və RAM (Yalnız exec mövcuddursa)
            if (function_exists('exec')) {
                if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                    // CPU
                    $cpuOutput = [];
                    @exec('wmic cpu get loadpercentage', $cpuOutput);
                    $cpuLoad = isset($cpuOutput[1]) ? trim($cpuOutput[1]) : "0";

                    // RAM
                    $ramOutput = [];
                    @exec('wmic OS get FreePhysicalMemory,TotalVisibleMemorySize /Value', $ramOutput);
                    $freeRam = 0; $totalRam = 0;
                    foreach($ramOutput as $line) {
                        if (str_contains($line, 'FreePhysicalMemory')) $freeRam = (int)filter_var($line, FILTER_SANITIZE_NUMBER_INT);
                        if (str_contains($line, 'TotalVisibleMemorySize')) $totalRam = (int)filter_var($line, FILTER_SANITIZE_NUMBER_INT);
                    }
                    if ($totalRam > 0) {
                        $ramPercent = round((($totalRam - $freeRam) / $totalRam) * 100, 1);
                        $ramUsage = $ramPercent . "%";
                    }
                }
            }
        } catch (\Exception $e) {
            \Log::error("Telegram Server Stats Error: " . $e->getMessage());
        }

        $cpuEmoji = (int)$cpuLoad > 80 ? '🔥' : ((int)$cpuLoad > 50 ? '⚠️' : '🚀');
        $ramEmoji = '🧠';
        $diskEmoji = (float)$diskPercent > 90 ? '🚨' : '💾';

        $response = "<b>🖥️ Server Sağlamlığı (Canlı)</b>\n"
                  . "───────────────────\n"
                  . "{$cpuEmoji} <b>CPU Yükü:</b> <code>{$cpuLoad}%</code>\n"
                  . "{$ramEmoji} <b>RAM İstifadəsi:</b> <code>{$ramUsage}</code>\n"
                  . "{$diskEmoji} <b>Disk (C:):</b> <code>{$diskPercent}%</code>\n"
                  . "───────────────────\n"
                  . "🔋 <b>PHP:</b> <code>" . PHP_VERSION . "</code>\n"
                  . "⏱️ <b>Zaman:</b> <code>" . now()->format('H:i:s') . "</code>\n\n"
                  . "<i>Son yenilənmə: " . now()->format('d.m.Y H:i:s') . "</i>";

        $keyboard = \SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup::make()
            ->addRow(\SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton::make('🔄 Yenilə', callback_data: 'refresh_server_status'))
            ->addRow(\SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton::make('⬅️ Geri', callback_data: 'nav_aktivlik'));

        if ($bot->isCallbackQuery()) {
            $bot->editMessageText($response, parse_mode: 'HTML', reply_markup: $keyboard);
            $bot->answerCallbackQuery();
        } else {
            $bot->sendMessage(text: $response, parse_mode: 'HTML', reply_markup: $keyboard);
        }
    }
}

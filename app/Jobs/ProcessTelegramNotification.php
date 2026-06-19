<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\TelegramNotificationLog;
use App\Models\TelegramSubscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use SergiX44\Nutgram\Nutgram;
use Illuminate\Support\Facades\Log;

class ProcessTelegramNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $backoff = 30;

    protected string $chatId;
    protected string $message;
    protected array $options;
    protected string $type;

    public function __construct(string $chatId, string $message, array $options = [], string $type = 'general')
    {
        $this->chatId = $chatId;
        $this->message = $message;
        $this->options = $options;
        $this->type = $type;
    }

    public function handle(Nutgram $bot): void
    {
        // Log qeydi yarat
        $subscriber = TelegramSubscriber::where('chat_id', $this->chatId)->first();

        // Check if subscriber exists and is active
        if ($subscriber && !$subscriber->is_active) {
            Log::warning("Telegram notification aborted: Subscriber {$this->chatId} is inactive.");
            return;
        }

        // Apply silent mode if enabled
        if ($subscriber && $subscriber->is_silent) {
            $this->options['disable_notification'] = true;
        }

        $log = TelegramNotificationLog::create([
            'subscriber_id'  => $subscriber?->id,
            'chat_id'        => $this->chatId,
            'type'           => $this->type,
            'message_preview' => mb_substr(strip_tags($this->message), 0, 200),
            'status'         => 'pending',
            'attempts'       => $this->attempts() + 1,
        ]);

        try {
            $params = array_merge([
                'chat_id'    => $this->chatId,
                'parse_mode' => 'HTML',
            ], $this->options);

            if (isset($params['photo'])) {
                $params['caption'] = $this->message;
                $bot->sendPhoto(...$params);
            } else {
                $params['text'] = $this->message;
                $bot->sendMessage(...$params);
            }

            // Uğurlu → logu yenilə
            $log->update([
                'status'  => 'sent',
                'sent_at' => now(),
            ]);

            Log::info("Telegram notification sent to {$this->chatId} [{$this->type}]");
        } catch (\Exception $e) {
            // Uğursuz → logu yenilə
            $log->update([
                'status'        => 'failed',
                'error_message' => $e->getMessage(),
                'attempts'      => $this->attempts() + 1,
            ]);

            Log::error("Failed to send Telegram message to {$this->chatId}: " . $e->getMessage());

            throw $e; // retry trigger
        }
    }
}

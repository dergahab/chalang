<?php

declare(strict_types=1);

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Message;

class TelegramReplyNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public Message $lead;
    public string $replyText;

    /**
     * Create a new notification instance.
     */
    public function __construct(Message $lead, string $replyText)
    {
        $this->lead = $lead;
        $this->replyText = $replyText;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Müraciətinizə Cavab: ' . config('app.name'))
            ->greeting('Hörmətli ' . $this->lead->full_name . ',')
            ->line('Saytımız vasitəsilə etdiyiniz müraciətə cavab olaraq bildiririk:')
            ->line($this->replyText)
            ->line('Əlavə suallarınız yaransa, bizimlə əlaqə saxlamaqdan çəkinməyin.')
            ->action('Sayta keçid et', url('/'))
            ->salutation('Hörmətlə, ' . config('app.name') . ' komandası');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'lead_id' => $this->lead->id,
            'reply_text' => $this->replyText,
        ];
    }
}

<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewMessageNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $message;
    protected ?array $channelsOverride = null;

    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * Notification channels.
     */
    public function via($notifiable)
    {
        return $this->channelsOverride ?? ['database', 'mail'];
    }

    public function setChannels(array $channels): self
    {
        $this->channelsOverride = $channels;
        return $this;
    }

    /**
     * Database payload.
     */
    public function toArray($notifiable)
    {
        return [
            'title' => 'Yeni Mesaj',
            'message' => 'Yeni mesajınız var: ' . $this->message->full_name,
            'url' => route('admin.message.index'),
            'icon' => 'ri-mail-line',
            'type' => 'info',
        ];
    }

    /**
     * Mail payload.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Yeni mesaj')
            ->greeting('Salam,')
            ->line('Sayt üzərindən yeni mesaj daxil olub.')
            ->line('Ad Soyad: ' . $this->message->full_name)
            ->line('E-poçt: ' . $this->message->email)
            ->line('Telefon: ' . ($this->message->phone ?? '-'))
            ->line('Məzmun: ' . $this->message->message)
            ->action('Mesajlara bax', route('admin.message.index'))
            ->salutation('Chalang admin paneli');
    }
}

<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewSubmissionNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $submission;
    protected ?array $channelsOverride = null;

    public function __construct($submission)
    {
        $this->submission = $submission;
    }

    public function via($notifiable)
    {
        return $this->channelsOverride ?? ['database', 'mail'];
    }

    public function setChannels(array $channels): self
    {
        $this->channelsOverride = $channels;
        return $this;
    }

    public function toArray($notifiable)
    {
        return [
            'title' => 'Yeni Müraciət',
            'message' => 'Yeni müraciətiniz var: ' . ($this->submission->name ?? 'Anonim'),
            'url' => route('admin.submission.index'),
            'icon' => 'ri-file-list-3-line',
            'type' => 'success'
        ];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Yeni müraciət')
            ->greeting('Salam,')
            ->line('Sayt üzərindən yeni müraciət daxil olub.')
            ->line('Ad: ' . ($this->submission->name ?? 'Anonim'))
            ->line('E-poçt: ' . ($this->submission->email ?? '-'))
            ->line('Telefon: ' . ($this->submission->phone ?? '-'))
            ->line('Məzmun: ' . ($this->submission->message ?? '-'))
            ->action('Müraciətlərə bax', route('admin.submission.index'))
            ->salutation('Chalang admin paneli');
    }
}

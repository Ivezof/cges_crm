<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VerifyEmail extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct($hashcode)
    {
        $this->hashcode = $hashcode;
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
        $code = $this->hashcode;
        return (new MailMessage)
                    ->greeting('Подтверждение почты')
                    ->line('Пожалуйста, нажмите кнопку ниже или перейдите по ссылке для подтверждения почты')
                    ->action('Подтвердить почту', url('/email/verify/' . $code))
                    ->salutation('С уважением, компания ЦГЭС');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}

<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RegisterNotify extends Notification
{
    use Queueable;
    public Request $newUser;

    /**
     * Create a new notification instance.
     */
    public function __construct(Request $user)
    {
        $this->newUser = $user;
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
        $url = url('/login');
        return (new MailMessage)
                    ->subject('Доступ к CRM системе компании ЦГЭС')
                    ->greeting('Доступ к CRM системе компании ЦГЭС')
                    ->line('Вы были зарегистрированы в CRM системе компании ЦГЭС. Ваши данные для входа в систему:')
                    ->line('Логин: ' . $this->newUser->email)
                    ->line('Пароль: ' . $this->newUser->password)
                    ->salutation('С уважением, компания ЦГЭС')
                    ->action('Войти в аккаунт', $url)
                    ->line('Хорошей работы!');
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

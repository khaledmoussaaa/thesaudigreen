<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public $token)
    {
        $this->token = $token;
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
        $url = env('APP_URL') . '/set-account-password' . '?token=' . $this->token . '&&email=' . $notifiable->email;
        return (new MailMessage)
            ->greeting('Welcome ' . $notifiable->name . ',')
            ->line('Your account is now officially part of The Saudi Green Company, and you can start using our platform to manage and promote your services.')
            ->action('Login here', $url)
            ->line('If you have any questions or need further assistance, please do not hesitate to contact us:')
            ->line('**Email:** contact@thesaudigreen.com')
            ->line('**Phone:** 01015571129')
            ->line('Thank you for choosing **The Saudi Green**. We are excited to support your company on this journey.')
            ->line('---');
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

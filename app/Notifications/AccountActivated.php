<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AccountActivated extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
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
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Activation de Compte')
                    ->greeting('Bonjour ' . $notifiable->name . ' !')
                    ->line('Nous sommes heureux de vous informer que votre compte a été activé avec succès.')
                    ->action('Se Connecter', url('/login'))
                    ->line('Merci d\'utiliser notre application !');
    }
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
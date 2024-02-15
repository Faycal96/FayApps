<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class userNotification extends Notification
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
    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
        ->greeting('Bonjour ' . $notifiable->name . ' !')
                    ->line('Votre compte a été créé avec succès.')
                    ->line('Votre compte est en cours de traitement et sera validé par l\'administrateur.')
                    ->action('Visiter le site', url('http://localhost:8000/'))
                    ->line('Merci d\'utiliser notre application !');
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}

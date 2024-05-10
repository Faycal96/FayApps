<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AccountDeactivated extends Notification implements ShouldQueue
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
                    ->subject('Désactivation de Compte')
                    ->greeting('Bonjour ' . $notifiable->name . ' !')
                    ->line('Votre compte a été désactivé.')
                    ->line('Si vous pensez que c’est une erreur, veuillez contacter l’administrateur.')
                    ->line('Merci d\'utiliser notre application !');
    }


    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}

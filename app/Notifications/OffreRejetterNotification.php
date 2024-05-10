<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OffreRejetterNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    private $offreDetails;

    public function __construct(array $offreDetails)
    {
        $this->offreDetails = $offreDetails;

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
                    ->subject('Rejet de votre Offre')
                    ->greeting('Bonjour !')
                    ->line('Desolé Votre offre pour la demande numéro ' . $this->offreDetails['demandeId'] . ' a été Rejetée.')
                    ->line('le motif du rejet est  '.$this->offreDetails['motif'])
                    ->line('Merci')
                    ->action('Connexion', url('http://localhost:8000/'))
                    ->line('Merci d\utiliser notre application!');
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

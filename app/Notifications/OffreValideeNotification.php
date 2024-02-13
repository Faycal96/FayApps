<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OffreValideeNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    private $offreDetails;

    public function __construct($offreDetails)
    {
        $this->offreDetails = $offreDetails;
    }

    public function via($notifiable)
    {
        return ['mail', 'database']; // Ajouter 'broadcast' si nécessaire
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Validation d\'offre')
                    ->greeting('Bonjour !')
                    ->line('L\'offre pour la demande numéro ' . $this->offreDetails['demandeId'] . ' a été validée.')
                    ->line('Prix retenu : ' . $this->offreDetails['prix'])
                    ->action('Voir l\'offre', url('/offres/' . $this->offreDetails['offreId']))
                    ->line('Merci d\'utiliser notre plateforme !');
    }

    public function toArray($notifiable)
    {
        return [
            'demandeId' => $this->offreDetails['demandeId'],
            'prix' => $this->offreDetails['prix'],
            'offreId' => $this->offreDetails['offreId'],
            'message' => 'Votre offre pour la demande numéro ' . $this->offreDetails['demandeId'] . ' a été validée. Prix retenu : ' . $this->offreDetails['prix']
        ];
    }
}
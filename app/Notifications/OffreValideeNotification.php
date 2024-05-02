<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OffreValideeNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    private $offreDetails;

    public function __construct($offreDetails,$pdf)
    {
        $this->offreDetails = $offreDetails;

    $this->pdf = $pdf;
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
                    ->action('Voir l\'offre', url('http://localhost:8000/'))
                    ->line('Merci d\'utiliser notre plateforme !')
                    ->attachData($this->pdf, 'offre.pdf', [
                        'mime' => 'application/pdf',
                    ]);
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

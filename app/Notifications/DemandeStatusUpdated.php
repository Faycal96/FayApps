<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DemandeStatusUpdated extends Notification
{
    use Queueable;
    use Queueable;

    public $demandeDetails;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($demandeDetails)
    {
        $this->demandeDetails = $demandeDetails;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Fermeture de demande: ' . $this->demandeDetails['code_demande'])
                    ->greeting('Bonjour ' . $notifiable->name . ',')
                    ->line('La demande avec le code ' . $this->demandeDetails['code_demande'] . 'vient de fermer.')
                    ->line('Nombre d\'offres reçues: ' . $this->demandeDetails['nombre_offres'])
                    // Ajoutez plus de lignes ici si nécessaire
                    ->action('Voir la meilleure offre', url('/demandes/' . $this->demandeDetails['id']))
                    ->line('Merci d\'utiliser notre application !');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            // Informations à stocker dans la base de données, si vous utilisez la base de données comme canal de notification
        ];
    }
}
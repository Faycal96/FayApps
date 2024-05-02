<?php

namespace App\Notifications;

use App\Models\AgenceAcredite;
use App\Models\DemandeBillet;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DemandeCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    private $demande;

    public function __construct(DemandeBillet $demande)
    {
        $this->demande = $demande;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {

        return (new MailMessage)
                    ->subject('Nouvelle Demande Créée')
                    ->greeting('Bonjour ' . $notifiable->name . ' !')
                    ->line('Une nouvelle demande de billet a été créée avec un délai de reception de ' . $this->demande->duree . ' heures.')
                    ->action('Voir la Demande', url('http://localhost:8000/'))
                    ->line('Si vous avez des questions, n\'hésitez pas à contacter l\'administrateur.')
                    ->line('Merci d\'utiliser notre application !');
    }



    public function toArray($notifiable)
    {
        return [
            'demande_id' => $this->demande->id,
            'duree' => $this->demande->duree,
            'message' => 'Une nouvelle demande de billet a été créée avec un délai de reception de ' . $this->demande->duree . ' heures.'
        ];
    }

}

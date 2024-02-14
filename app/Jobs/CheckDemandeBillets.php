<?php

namespace App\Jobs;

use App\Models\DemandeBillet;
use App\Notifications\DemandeStatusUpdated;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckDemandeBillets implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $today = now();

        DemandeBillet::where('etat', 1)->each(function($demande) use ($today) {
            $dateFinValidite = $demande->created_at->addMinutes($demande->duree);
            if ($today->gte($dateFinValidite)) {
                $demande->update(['etat' => 0]);

                // dd($dateFinValidite);
                // Supposons que votre modèle DemandeBillet a une relation 'user' qui renvoie l'utilisateur ayant créé la demande
                $user = $demande->user; // Récupérer l'utilisateur ayant créé la demande

                if ($user) { // Vérifier si l'utilisateur existe
                    // Préparer les détails de la demande pour la notification
                    $demandeDetails = [
                        'id' => $demande->id,
                        'code_demande' => $demande->code_demande,
                        'nombre_offres' => $demande->offres->count(), // Assurez-vous que la relation offres existe
                        // Ajoutez d'autres détails de la demande si nécessaire
                    ];

                    // Envoyer la notification à l'utilisateur ayant créé la demande
                    $user->notify(new DemandeStatusUpdated($demandeDetails));
                }
            }
        });


 }

}

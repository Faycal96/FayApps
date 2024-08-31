<?php

namespace App\Console;

use App\Jobs\CheckDemandeBillets;
use App\Models\DemandeBillet;
use App\Models\User;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
    {
         $schedule->job(new CheckDemandeBillets)->everyMinute();
         $schedule->command('agency:check-validity')->everyMinute();

        // $schedule->call(function () {
        //     $today = now();
        //     DemandeBillet::where('etat', 1)->each(function($demande) use ($today) {
        //         $dateFinValidite = $demande->created_at->addMinutes($demande->duree);
        //         if ($today->gte($dateFinValidite)) {
        //             $demande->update(['etat' => 0]);

        //             // Supposons que votre modèle DemandeBillet a une relation 'user' qui renvoie l'utilisateur ayant créé la demande
        //             $user = $demande->user; // Récupérer l'utilisateur ayant créé la demande

        //             if ($user) { // Vérifier si l'utilisateur existe
        //                 // Préparer les détails de la demande pour la notification
        //                 $demandeDetails = [
        //                     'id' => $demande->id,
        //                     'code_demande' => $demande->code_demande,
        //                     'nombre_offres' => $demande->offres->count(), // Assurez-vous que la relation offres existe
        //                     // Ajoutez d'autres détails de la demande si nécessaire
        //                 ];

        //                 // Envoyer la notification à l'utilisateur ayant créé la demande
        //                 $user->notify(new \App\Notifications\DemandeStatusUpdated($demandeDetails));
        //             }
        //         }
        //     });
        // })->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }

}

<?php

namespace App\Console;

use App\Models\DemandeBillet;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            // Votre logique pour mettre à jour l'état des demandes
            $today = now();
            DemandeBillet::where('etat', 1)->each(function($demande) use ($today) {
                $dateFinValidite = $demande->created_at->addMinutes($demande->duree);
                if ($today->gte($dateFinValidite)) {
                    $demande->update(['etat' => 0]);
                }
            });
        })->everyMinute();
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

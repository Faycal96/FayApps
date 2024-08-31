<?php

namespace App\Console\Commands;

use App\Models\Agency;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckAgencyValidity extends Command
{
    protected $signature = 'agency:check-validity';

    protected $description = 'Check and deactivate agencies that have passed their validity date';

    public function handle()
    {
        $agencies = Agency::where('fin_validite', '<', Carbon::now())
                          ->where('is_active', true)
                          ->get();

        foreach ($agencies as $agency) {
            $agency->update(['is_active' => false]);

            // Désactiver tous les utilisateurs associés
            $agency->users()->update(['is_active' => false]);
        }

        $this->info('Agency validity checked and updated.');
    }
}
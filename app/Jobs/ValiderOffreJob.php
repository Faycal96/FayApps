<?php

namespace App\Jobs;

use App\Models\Offre;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Notifications\OffreValideeNotification;
use App\Http\Controllers\OffreController;


class ValiderOffreJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $offreId;
    protected $motif;

    public function __construct($offreId, $motif)
    {
        $this->offreId = $offreId;
        $this->motif = $motif;
    }

    public function handle()
    {
        $offre = Offre::findOrFail($this->offreId);
        $offre->etats = 'validée';
        $offre->motif = $this->motif;
        $offre->save();

        Offre::where('demande_id', $offre->demande_id)
            ->where('id', '!=', $offre->id)
            ->update(['etats' => 'rejetée']);

        // Générer le PDF
        $pdf = generatePDF($offre);

        // Récupérer les détails nécessaires pour la notification
        $offreDetails = [
            'demandeId' => $offre->demande->code_demande,
            'prix' => $offre->PrixTotal,
            'offreId' => $offre->id,
        ];

        // Envoyer la notification avec le PDF en pièce jointe
        $agence = $offre->agence->user;
        $agence->notify(new OffreValideeNotification($offreDetails, $pdf));
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    use HasFactory;

    protected $fillable = [
        'pelerin_id',
        'montant',
        'date_paiement',
        'mode_paiement',
        'note',
        'statut_paiement',
        'motif_annulation',
        'montant_vers_avant_annulation',
        'total_verse',
        'reste_a_payer',
    ];

    public function pelerin()
    {
        return $this->belongsTo(Pelerin::class);
    }
}
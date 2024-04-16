<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItineraireDemande extends Model
{
    use HasFactory;

    protected $fillable = ['lieuEscale', 'dureeEscale', 'demande_billet_id'];

    public function demandeBillet()
    {
        return $this->belongsTo(DemandeBillet::class);
    }
}
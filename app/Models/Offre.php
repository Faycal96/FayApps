<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offre extends Model
{
    use HasFactory;

    //protected $table = 'offres';

    protected $guarded = [];

    public function demande()
    {
        return $this->belongsTo(DemandeBillet::class, 'demande_id');
    }
    public function agence()
    {
        return $this->belongsTo(AgenceAcredite::class, 'agence_id');
    }
    public function itineraires()
    {
        return $this->hasMany(ItineraireOffre::class);
    }
    public function documents()
    {
        return $this->hasMany(DocumentOffre::class);
    }

}

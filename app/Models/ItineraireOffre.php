<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItineraireOffre extends Model
{
    use HasFactory;
    protected $fillable = ['lieuEscale', 'dureeEscale', 'offre_id'];

    public function offre()
    {
        return $this->belongsTo(Offre::class);
    }
}

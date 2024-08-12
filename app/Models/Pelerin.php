<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelerin extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom', 'passeport', 'prenom', 'date_delivrance', 'date_naissance',
        'date_expiration', 'sexe', 'nationalite', 'telephone', 'motif_candidat',
        'facilitateur', 'statut_candidat', 'ville_province', 'note_observation','user_id'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

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
        'facilitateur', 'statut_candidat', 'ville_province', 'note_observation','user_id','photo','motif_candidat_id',
        'type_vol',
        'lieu_naissance',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function motifCandidat()
{
    return $this->belongsTo(MotifCandidat::class);
}
public function paiements()
{
    return $this->hasMany(Paiement::class);
}
public function montantTotalPaye()
{
    return $this->paiements->sum('montant');
}

public function prixTotalHadj()
{
    // Assurez-vous que `prix_total` est bien défini dans votre modèle Pelerin ou à un autre endroit.
    return $this->motifCandidat->montant ?? 0;
}

public function montantRestant()
{
    return max(0, $this->prixTotalHadj() - $this->montantTotalPaye());
}

}

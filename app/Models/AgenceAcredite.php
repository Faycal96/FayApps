<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class AgenceAcredite extends Model
{
    use HasFactory,Notifiable;

 
    protected $table = 'agence_acredites';


    protected $guarded = [
        'id'
    ];

    protected $fillable = [
        'user_id',
        'numeroIfu',
        'nomAgence',
        'adressAgence',
        'rccm',
        'dateCreationAgence',
    ];


    public function user()
    {
        return $this->hasOne(User::class,'id','user_id');
    }

    public function savePdfFile($pdfFilePath)
    {
        // Mettez à jour le chemin du fichier PDF dans le modèle
        $this->rccm = $pdfFilePath;
        $this->save();
    }
    public function offres()
{
    return $this->hasMany(Offre::class, 'agence_id');
}

}

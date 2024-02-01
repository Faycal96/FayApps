<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgenceAcredite extends Model
{
    use HasFactory;

    // protected $table = 'agence_acredite';

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
}

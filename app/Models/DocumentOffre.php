<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentOffre extends Model
{
    use HasFactory;
    protected $fillable = ['libelle', 'fichier', 'offre_id'];

    public function offre()
    {
        return $this->belongsTo(Offre::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Structure extends Model
{
    use HasFactory;
    protected $fillable = [
        'libelleCourt',
        'libelleLong',
        'ministere_id', // Assurez-vous que l'id du ministère est également fillable
    ];

    // Relation avec le modèle Ministere
    public function ministere()
    {
        return $this->belongsTo(Ministere::class);
    }
}

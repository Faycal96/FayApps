<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SourceFinancement extends Model
{
    use HasFactory;
    protected $fillable = [
    
        'libelleLong',
        'ministere_id', 
    ];

    // Relation avec le modèle Ministere
    public function ministere()
    {
        return $this->belongsTo(Ministere::class);
    }
}

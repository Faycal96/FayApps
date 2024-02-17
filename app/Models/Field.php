<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    use HasFactory;
    protected $fillable = [
        'procedure_id',
        'label',
        'type',
        'required',
    ];
    // Relation avec Procedure
    public function procedure()
    {
        return $this->belongsTo(Procedure::class);
    }

    // Relation avec ApplicationField (pas directement nécessaire dans votre cas mais utile pour accès direct si besoin)
    public function applicationFields()
    {
        return $this->hasMany(ApplicationField::class);
    }
}
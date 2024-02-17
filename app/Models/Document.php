<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;
    protected $fillable = [
        'procedure_id',
        'label',
    ];
    // Relation avec Procedure
    public function procedure()
    {
        return $this->belongsTo(Procedure::class);
    }
}
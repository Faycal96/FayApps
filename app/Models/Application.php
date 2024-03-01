<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'procedure_id',
        'status',
        'request_number',
        'motif',
        'document_path',
    ];
    // Relation avec User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relation avec Procedure
    public function procedure()
    {
        return $this->belongsTo(Procedure::class);
    }

    // Relation avec ApplicationField
    public function applicationFields()
    {
        return $this->hasMany(ApplicationField::class);
    }

    // Relation avec ApplicationDocument
    public function applicationDocuments()
    {
        return $this->hasMany(ApplicationDocument::class);
    }
    public function fields()
{
    // Supposons que vous avez une table pivot personnalisée avec des valeurs de champ
    return $this->belongsToMany(Field::class, 'application_fields')
                ->withPivot('value');
}
}
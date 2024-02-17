<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationField extends Model
{

    use HasFactory;
    protected $fillable = [
        'application_id',
        'field_id',
        'value',
    ];
    // Relation avec Application
    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    // Relation avec Field
    public function field()
    {
        return $this->belongsTo(Field::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationDocument extends Model
{

    use HasFactory;

    protected $fillable = [
        'application_id',
        'document_id',
        'file_path',
    ];

 

    // Relation avec Application
    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    // Relation avec Document
    public function document()
    {
        return $this->belongsTo(Document::class);
    }
}
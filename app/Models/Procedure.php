<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Procedure extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'ministry_id',
        'status',
        'description',
        'is_paid',
        'amount',
        
    ];
    // Relation avec Field
    public function fields()
    {
        return $this->hasMany(Field::class);
    }

    // Relation avec Document
    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    // Relation avec Application
    public function applications()
    {
        return $this->hasMany(Application::class);
    }
    public function ministere()
    {
        return $this->belongsTo(Ministere::class,'ministry_id');
    }
    public function users()
{
    return $this->belongsToMany(User::class,'procedure_user');
}

}
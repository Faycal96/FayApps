<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgenceAcredite extends Model
{
    use HasFactory;

    protected $table = 'agence_acredite';

    protected $guarded = [
        'id'
    ];
    protected $fillable = [
        'user_id',
        'nomAgence',
        'adressAgence',
        'dateCreationAgence',
        'numeroIfu',
        'rccm',
        // ... autres champs
    ];


    public function user()
    {
        return $this->hasOne(User::class,'id','user_id');
    }
}

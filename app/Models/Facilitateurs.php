<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facilitateurs extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'agence_id','telephone'];

    public function agence()
    {
        return $this->belongsTo(Agency::class);
    }
}

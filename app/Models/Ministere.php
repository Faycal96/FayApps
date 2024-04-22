<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ministere extends Model
{
    use HasFactory;
    protected $fillable = [
        'libelleCourt',
        'libelleLong',
        
    ];
   
    public function structures()
    {
        return $this->hasMany(Structure::class);
    }
    public function sources()
    {
        return $this->hasMany(SourceFinancement::class);
    }

}

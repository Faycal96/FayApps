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
    public function procedures()
    {
        return $this->hasMany(Procedure::class,'ministry_id');
    }
   
    

}

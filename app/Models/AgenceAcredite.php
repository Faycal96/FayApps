<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgenceAcredite extends Model
{
    use HasFactory;

    protected $table = 'agence_acredites';

    protected $guarded = [
        'id'
    ];


    public function user()
    {
        return $this->hasOne(User::class,'id','user_id');
    }
}

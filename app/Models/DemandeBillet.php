<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemandeBillet extends Model
{
    use HasFactory;

    protected $table = 'demande_billets';



    // protected $fillable = [
    //     'name', 'address', 'type',
    // ];

    protected $guarded = [];


    public function offres()
    {
        return $this->hasMany(Offre::class, 'demande_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }




}



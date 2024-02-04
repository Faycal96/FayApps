<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemandeBillet extends Model
{
    use HasFactory;

    protected $table = 'demande_billets';
    // Dans DemandeBillet.php
protected $appends = ['prix_minimum'];

public function getPrixMinimumAttribute() {
    return $this->offres()->orderBy('prixBillet', 'asc')->first()->prixBillet ?? null;
}


    // protected $fillable = [
    //     'name', 'address', 'type',
    // ];

    protected $guarded = [];

    public function offres()
{
    return $this->hasMany(Offre::class, 'demande_id');
}

}

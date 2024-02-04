<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offre extends Model
{
    use HasFactory;

    //protected $table = 'offres';

    protected $guarded = [];
    public function demande()
{
    return $this->belongsTo(DemandeBillet::class, 'demande_id');
}

}

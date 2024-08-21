<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MotifCandidat extends Model
{
    use HasFactory;
    protected $fillable = ['nom', 'montant'];
    public function pelerins()
{
    return $this->hasMany(Pelerin::class);
}

}

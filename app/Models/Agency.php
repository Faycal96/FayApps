<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agency extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'address', 'phone_number', 'email','logo','is_active', 'fin_validite'];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}

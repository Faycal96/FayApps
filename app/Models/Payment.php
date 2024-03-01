<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = ['application_id', 'phone', 'amount', 'otp', 'otp_verified_at'];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }
}
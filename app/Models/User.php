<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, HasRoles, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nom',
        'prenom',
        'matricule',
        'telephone',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function agence()
    {
        return $this->hasOne(AgenceAcredite::class, 'user_id', 'id');
    }

    public function ministere()
    {
        return $this->hasOne(Ministere::class,'id','id_m');
    }

    public function demandes()
    {
        return $this->hasMany(DemandeBillet::class);
    }
    use HasFactory, Notifiable;

    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }

    public function pelerins()
    {
        return $this->hasMany(Pelerin::class);
    }




    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function agenceAcredite()
{
    return $this->hasOne(AgenceAcredite::class);
}
//  public function ministere()
//     {
//         return $this->hasOne(Ministere::class);
//     }
}

<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Foundation\Auth\User as Authenticatable;


class Customer extends Authenticatable implements JWTSubject,MustVerifyEmail
{
    use HasFactory,Notifiable;
    protected $guarded=['id'];


    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
    protected $hidden = ['password','remember_token'];
    public function country(){
        return $this->belongsTo(Countries::class,'country_id');
    }
    public function accounts(){
        return $this->hasMany(Account::class,'customer_id');
    }

}

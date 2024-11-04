<?php

namespace App\Models;

use App\Models\wallet;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Currancy extends Model
{
    use HasFactory;
    protected $guarded=['id'];
    protected $table="currances";

    public function wallet()
    {
        return $this->hasMany(wallet::class);
    }


    // public function wallet()
    // {
    //     return $this->belongsTo(wallet::class);
    // }

}

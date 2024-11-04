<?php

namespace App\Models;

use App\Models\wallet;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class walletHistory extends Model
{
    use HasFactory;

    protected $guarded=['id'];

    public function wallet()
    {
        return $this->belongsTo(wallet::class);
    }
}

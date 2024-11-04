<?php

namespace App\Models;

use App\Models\Currancy;
use App\Models\Customer;
use App\Models\walletHistory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class wallet extends Model
{
    use HasFactory;
    protected $guarded=['id'];
    public function history()
    {
        return $this->hasMany(walletHistory::class);
    }

    public function currancy()
    {
        return $this->belongsTo(Currancy::class,'curranc_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}

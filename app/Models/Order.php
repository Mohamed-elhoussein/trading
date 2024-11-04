<?php

namespace App\Models;

use App\Models\Customer;
use App\Models\orderWithMt5;
use App\Models\tradingstock;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;
    protected $guarded=['id'];

    public function customer()
    {

    return $this->belongsTo(Customer::class);
    }

    public function stock()
    {
        return $this->belongsTo(tradingstock::class, 'stock_id');
    }

    public function orderMt5()
    {
        return $this->hasMany(orderWithMt5::class);
    }


}

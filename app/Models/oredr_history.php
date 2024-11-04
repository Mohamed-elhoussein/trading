<?php

namespace App\Models;

use App\Models\User;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class oredr_history extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'action', 'user_id', 'customer_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public static function InsertHistory($orderId,$oredrStatus="")
    {
        if(Auth::user()->id !==null){
            $userId=Auth::user()->id;
            $action=" تم إضافة الاوردر من قبل المسئول+The order was added by the admin";

        }else{
            $customer_id=Auth::guard("api")->user()->id;
            $action=" تم إضافة الاوردر من قبل العميل+The order was added by the customer";
        }


        oredr_history::create([
            'order_id' => $orderId,
            'action' => $oredrStatus??$action,
            'user_id' => $userId??null,
            'customer_id' => $customer_id??null,
        ]);
    }

}

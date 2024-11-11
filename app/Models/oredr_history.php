<?php

namespace App\Models;

use App\Models\User;
use App\Models\Order;
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

    public function order()
    {
        return $this->belongsTo(Order::class);
    }



    public static function InsertHistory($order , $id , $trading_type , $oredrStatus )
    {

        if (Auth::check()) {
            // إذا كان المستخدم قد سجل دخوله باستخدام  web
            $userId = Auth::user()->id;
            $do_by = "Admin";
        } else {
            // إذا كان المستخدم قد سجل دخوله باستخدام  api
            $user = Auth::guard('api')->user();
            $customer_id = $user ? $user->id : null;
            $do_by = "Customer";
        }


        $action = new oredr_history();
        $action->order_id = $id ;  // استخدام id أو orderId
        $action->action = $oredrStatus;
        $action->do_by = $do_by;
        $action->data = json_encode($order);;  // تخزين البيانات بتنسيق JSON
        $action->trading_type = $trading_type;  // يمكن أن يكون 'metaTrade' أو 'local' بناءً على المتطلبات
        $action->customer_id = $customer_id ?? null;  // إذا كان موجودًا
        $action->user_id = $userId ?? null;  // إذا كان موجودًا
        $action->save();
    }

}

<?php

namespace App\Models;

use App\Models\Customer;
use App\Models\oredr_history;
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

    public function history()
    {
        return $this->hasMany(oredr_history::class);
    }



    public static function Profit($request,$Price){
        $order = Order::where('id', $request->orderId)->first();

        if ($order) {
            // حساب السعر القديم قبل التحديث
            $oldPrice = $order->total_price;

            // تحديث total_price
            $update = $order->update([
                "total_price" => $request->volume * $Price
            ]);

            // حساب الأرباح
            return $profit = $oldPrice - ($request->volume * $Price);

            } else {
            // في حال لم يتم العثور على الطلب في قاعدة البيانات
            Toastr::error('Order not found.');
            return response()->json(['error' => 'Order not found'], 404);
        }

}

}

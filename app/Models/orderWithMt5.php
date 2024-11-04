<?php

namespace App\Models;

use App\Models\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class orderWithMt5 extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'message',
        'ticket',
        'profit',
        'volume',
        'open_price',
        'state',
    ];


    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public static function InsertHistory($order_id,$data){
        $orderHistory = new orderWithMt5();
        $orderHistory->order_id = $order_id;
        $orderHistory->message = 'Order sent successfully open with metaTrade5';
        $orderHistory->ticket = $data['ticket'];
        $orderHistory->profit = $data['profit'];
        $orderHistory->volume = $data['volume'];
        $orderHistory->open_price = $data['openPrice'];
        $orderHistory->state = $data['state'];
        $orderHistory->save();
    }
}

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




    public static function InsertHistory($order_id , $data , $status , $message=""){
        $orderWithMt5=orderWithMt5::where('order_id',$order_id);
        if($orderWithMt5->first()){
            $orderWithMt5->where("status",$status)->update([
                "ticket" => $data['ticket']
            ]);
        }else{

            $orderHistory = new orderWithMt5();
            $orderHistory->order_id         = $orderId;
            $orderHistory->do_by            = $do_by;
            $orderHistory->user_id          = $userId??null;
            $orderHistory->customer_id      = $customer_id??null;
            $orderHistory->order_id         = $order_id;
            $orderHistory->message          = $message;
            $orderHistory->data             =json_encode($data);
            $orderHistory->status           ="1";
            $orderHistory->ticket           = $data['ticket'];
            $orderHistory->profit           = $data['profit'];
            $orderHistory->volume           = $data['volume'];
            $orderHistory->open_price       = $data['openPrice'];
            $orderHistory->state            = $data['state'];
            $orderHistory->save();
        }
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\oredr_history;
class OrderHistoryController extends Controller
{
    public function getOrderHistory(Request $request,$orderId)
    {
        $oredr_history=oredr_history::where('order_id', $orderId)->with("user","customer")->get();
        if($oredr_history->count()==0 &&  $request->is("api/trading/orderHistory/$orderId")){
            return response()->json(["message" => "not found data"],404);
        }
        return response()->json($oredr_history);
    }
}

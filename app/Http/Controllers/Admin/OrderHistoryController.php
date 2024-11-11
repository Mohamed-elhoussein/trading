<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\oredr_history;
class OrderHistoryController extends Controller
{
    public function getOrderHistory($orderId)
    {
        $oredr_history=oredr_history::where('order_id', $orderId)->with("user","customer")->get();
        return response()->json($oredr_history);
    }
}

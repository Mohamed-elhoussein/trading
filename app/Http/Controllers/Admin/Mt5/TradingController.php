<?php

namespace App\Http\Controllers\Admin\Mt5;

use App\Models\orderWithMt5;
use Illuminate\Http\Request;
use App\Models\oredr_history;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Http;

class TradingController extends Controller
{
    public function sendOrder(Request $request)
    {
        // return $request;
        // Validate incoming request
        $request->validate([
            'Symbol' => 'required|string',
            'operation' => 'required|string|in:Buy,Sell,BuyStop,SellStop',
            'volume' => 'required|numeric|min:0.1',
        ]);

        // Get the token from the environment
        $id = env('MT5_ID');

        // Construct the API URL
        $url = "https://mt5.mtapi.io/OrderSend?id={$id}&symbol={$request->Symbol}&operation={$request->operation}&volume={$request->volume}";

        // Send the request to the trading API
        $response = Http::get($url);

        if ($response->successful()) {
            $data = $response->json();

            // تحقق من وجود المفتاح 'ticket'
            if (isset($data['ticket'])) {
                Toastr::success('Order sent successfully'); // رسالة نجاح
                $value=[
                    'message' => 'Order sent successfully with metaTrade5',
                    'data' => [
                        'ticket' => $data['ticket'],
                        'profit' => $data['profit'],
                        'volume' => $data['volume'],
                        'openPrice' => $data['openPrice'],
                        'state' => $data['state'],
                        // يمكنك إضافة المزيد من التفاصيل حسب الحاجة
                    ]
                    ];
                    oredr_history::InsertHistory($request->orderId,"Order sent successfully with metaTrade5 + ticket +". $data['ticket']);
                    orderWithMt5::InsertHistory($request->orderId,$data);
                 $data = response()->json($value, 200);
                return $data;
            } else {
                Toastr::error('لم يتم إرسال الطلب بشكل صحيح.'); // رسالة خطأ
                return response()->json(['error' => 'لم يتم إرسال الطلب بشكل صحيح.'], 400);
            }
        } else {
            // Handle error response from the API
            return response()->json(['error' => 'خطأ في إرسال الطلب: ' . $response->body()], $response->status());
        }
}


public function closeOrder(Request $request)
{
    // التحقق من المعلمات
    $id = env('MT5_ID');

    $orderId=$request->orderId;
    $oredrMt5=orderWithMt5::where("order_id",$orderId)->first();

    if($oredrMt5){
        $ticket = $oredrMt5->ticket;
        // إرسال طلب لإغلاق الأمر
        $response = Http::get("https://mt5.mtapi.io/OrderClose", [
            'id' => $id,
            'ticket' => $ticket,
        ]);

        // التحقق من حالة الاستجابة
        if ($response->successful()) {
            return response()->json([
                'message' => 'Order closed successfully',
                'data' => $response->json(),
            ]);
            oredr_history::InsertHistory($request->orderId,"Order closed successfully with metaTrade5 + ticket +". $data['ticket']);
            $oredrMt5->message = "Order closed successfully";
        } else {
            return response()->json([
                'message' => 'Error closing order',
                'error' => $response->json(),
            ], $response->status());
        }
    }
}
}

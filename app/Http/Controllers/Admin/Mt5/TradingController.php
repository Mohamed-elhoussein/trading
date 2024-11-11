<?php

namespace App\Http\Controllers\Admin\Mt5;

use App\Models\Order;
use App\Models\wallet;
use App\Models\orderWithMt5;
use Illuminate\Http\Request;
use App\Models\oredr_history;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\sendOrderMateTradeRequest;

class TradingController extends Controller
{
    public function sendOrder(sendOrderMateTradeRequest $request)
    {

        // return $request;
        // $userAmount=wallet::CheckAmountFound($request);

        // الحصول على التوكن من
        $id = env('MT5_ID');

        // بناء الرابط لإرسال الطلب إلى API
        $url = "https://mt5.mtapi.io/OrderSend?id={$id}&symbol={$request->Symbol}
                &operation={$request->operation}&volume={$request->volume}";

            // إرسال الطلب إلى API

            $response = Http::get($url);

        if ($response->successful()) {
            return $data = $response->json();

            // تحقق من وجود المفتاح 'ticket' في الاستجابة
            if (isset($data['ticket'])) {
                $value = [
                    'message'   => 'Order sent successfully with metaTrade5',
                    'ticket'    => $data['ticket'],
                    'profit'    => $data['profit'],
                    'volume'    => $request->volume,
                    'openPrice' => $request->volume * $data['openPrice'],
                    'state'     => $data['state'],
                    "orderId"   => $request->orderId, // استخدام $request->orderId بشكل صحيح
                ];

                    $openPrice=$data['openPrice'];
                    // إدراج سجل في history
                    $trading_type = "metaTrade";
                    oredr_history::InsertHistory($value , $request->orderId ,$trading_type ,"open");                    // إرجاع الاستجابة بنجاح
                    Toastr::success('Order sent successfully'); // رسالة نجاح
                    return response()->json($value, 200);

            } else {
                // إذا لم يتم العثور على المفتاح 'ticket' في الاستجابة
                Toastr::error('لم يتم إرسال الطلب بشكل صحيح.');
                return response()->json(['error' => 'لم يتم إرسال الطلب بشكل صحيح.'], 400);
            }
        } else {
            // التعامل مع حالة الخطأ من API
            return response()->json(['error' => 'خطأ في إرسال الطلب: ' . $response->body()], $response->status());
        }

}


public function closeOrder(Request $request)
{
    // التحقق من المعلمات
        $id = env('MT5_ID');

        if ($lastTicket) {
            $ticket = json_decode($lastTicket[0]->data)->ticket; // assuming 'data' contains JSON
            // يمكن استخدام $lastTicketValue كما تريد
        } else {
            // لا يوجد بيانات
            return response()->json(['error' => 'No ticket found for this order'], 404);
        }

        // إرسال طلب لإغلاق الأمر
        $response = Http::get("https://mt5.mtapi.io/OrderClose", [
            'id' => $id,
            'ticket' => $ticket,
        ]);

        // التحقق من حالة الاستجابة
        if ($response->successful()) {
            return $response->json();

            $Price=$data['closePrice'];
    
            // إدراج سجل في history
            $trading_type = "metaTrade";
            $orderHistory = oredr_history::InsertHistory($value, $trading_type, "close" ,$profit);
            return response()->json([
                'message' => 'Order closed successfully',
                'data' => $response->json(),
            ]);
        } else {
            return response()->json([
                'message' => 'Error closing order',
                'error' => $response->json(),
            ], $response->status());
        }
    }
}


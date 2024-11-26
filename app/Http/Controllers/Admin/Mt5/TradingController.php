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

        try {
            // تعيين القيم الافتراضية في حال لم تكن موجودة
            $operation = $request->operation ?? "Buy";
            $volume = $request->volume ?? $request->gram / 31.1035;
            $volume = round($volume, 1);

            // الحصول على التوكن من البيئة
            $id = env('MT5_ID');

            // بناء الرابط لإرسال الطلب إلى API
            $url = "https://mt5.mtapi.io/OrderSend?id={$id}&symbol={$request->Symbol}&operation={$operation}&volume={$volume}";

            // إرسال الطلب إلى API
            $response = Http::get($url);

            // التحقق من استجابة API
            if ($response->successful()) {
                $data = $response->json();

                // البدء في المعاملة
                DB::beginTransaction();

                try {
                    // التعامل مع حالة "فتح الطلب"
                    if ($request->is("api/trading/mt5/openOrder")) {
                        $data["customer_id"] = $request->customer_id;
                        $data["shipping_address"] = $request->shipping_address;
                        $data["total_price"] = $volume * $data["openPrice"];
                        $data["volume"] = $volume;
                        $data["trading_type"] = "metaTrade5";

                        // محاولة إنشاء الطلب في قاعدة البيانات
                        $order = order::create($data);
                        $order_id = $order->id ?? null; // إذا لم يتم إنشاء الطلب بنجاح، سيتم إرجاع null
                    }

                    // التأكد من وجود order_id
                    $orderId = $request->orderId ?? $order_id;

                    // تحقق من وجود المفتاح 'ticket' في الاستجابة
                    if (isset($data['ticket'])) {
                        // إعداد البيانات لإدراجها في تاريخ التداول
                        $value = [
                            'message'   => 'Order sent successfully with metaTrade5',
                            'ticket'    => $data['ticket'],
                            'profit'    => $data['profit'],
                            'volume'    => $volume,
                            'openPrice' => $volume * $data['openPrice'],
                            'state'     => $data['state'],
                            "orderId"   =>  $orderId, // استخدام $request->orderId بشكل صحيح
                        ];

                        // إدراج سجل في history
                        $trading_type = "metaTrade";
                        oredr_history::InsertHistory($value, $orderId, $trading_type, "open", $request->customer_id);

                        // إذا تمت جميع العمليات بنجاح، نقوم بتثبيت المعاملة
                        DB::commit();

                        // إرجاع استجابة النجاح
                        Toastr::success('Order sent successfully');
                        return response()->json(["data" => $value], 200);
                    } else {
                        // إذا لم يتم العثور على المفتاح 'ticket' في الاستجابة
                        DB::rollback(); // التراجع عن المعاملة في حال لم يتم العثور على 'ticket'
                        Toastr::error('لم يتم إرسال الطلب بشكل صحيح.');
                        return response()->json(['error' => 'لم يتم إرسال الطلب بشكل صحيح.'], 400);
                    }
                } catch (\Exception $e) {
                    // في حالة حدوث أي استثناء، نقوم بالتراجع عن المعاملة
                    DB::rollback();
                    \Log::error('Error occurred while processing order: ' . $e->getMessage());

                    // إرجاع استجابة الخطأ
                    Toastr::error('حدث خطأ أثناء معالجة الطلب.');
                    return response()->json(['error' => 'حدث خطأ أثناء معالجة الطلب: ' . $e->getMessage()], 500);
                }
            } else {
                // التعامل مع حالة الخطأ من API
                return response()->json(['error' => 'خطأ في إرسال الطلب: ' . $response->body()], $response->status());
            }
        } catch (\Exception $e) {
            // في حالة حدوث استثناءات غير متوقعة خارج المعاملة
            \Log::error('Error occurred: ' . $e->getMessage());
            Toastr::error('حدث خطأ أثناء معالجة الطلب.');
            return response()->json(['error' => 'حدث خطأ أثناء معالجة الطلب: ' . $e->getMessage()], 500);
        }


}


public function closeOrder(Request $request)
{

    // التحقق من المعلمات
        $id = env('MT5_ID');
         $order=oredr_history::where("order_id", $request->orderId);

         $OrderData=$order->where("trading_type","metatrade")
         ->orderBy('created_at', 'desc')
         ->pluck("data")
         ->first();


          $DataJson=json_decode($OrderData,true);

          $lastTicket=$DataJson["ticket"];
        if ($lastTicket) {
            // التحقق من حالة الاستجابة
            // إرسال طلب لإغلاق الأمر
        $response = Http::get("https://mt5.mtapi.io/OrderClose", [
            'id' => $id,
            'ticket' => $lastTicket,
        ]);

        if ($response->successful()  && isset($response->json()["closePrice"]) ) {
            $value =$response->json();
            // إدراج سجل في history

            $trading_type = "metaTrade";

            $price_bid=$value["closePrice"] * $DataJson["volume"];

            $profit = $price_bid - $DataJson["total_price"];
            $order->update([
                'operation'=>'Sell',
                'closePrice' => $data["closePrice"], // حفظ سعر الإغلاق
                // 'total_price' => $current_price,
                'profit' => $profit, // حفظ الربح
                'order_status'=>'closed',
                'delivery' => "1", // تحديث حالة التسليم
            ]);
            $orderHistory = oredr_history::InsertHistory($value, $request->orderId ,$trading_type, "close" );
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


        } else {
            // لا يوجد بيانات
            return response()->json(['error' => 'No ticket found for this order'], 404);
        }




    }






}


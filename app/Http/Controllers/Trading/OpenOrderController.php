<?php

namespace App\Http\Controllers\Trading;

use App\Models\OrderTrade;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class OpenOrderController extends Controller
{
    public function GetPrice($symbol)
    {

    $apiKey = env("TRADE_API_KEY");
    // $symbol=$request->symbol;
    $response = Http::withHeaders([
        'x-access-token' => $apiKey,
        'Accept' => 'application/json'
    ])->get("https://www.goldapi.io/api/{$symbol}/KWD");


    if ($response->failed()) {
        return response()->json(['error' => 'Failed to fetch data'], 500);
    }
        return $response->json();

    }



    public function CreateOrder(Request $request)
    {
        // return $request;

        $symbol=$request->symbol;        // نوع المعدن
         $data=$this->GetPrice($symbol);  // الحصول علي كل البيانات الخاصه بالمعدن
        if($request->order_type=="market")
        {
            return $this->Market($request,$data);
        }


    }




    public function Market($request,$data)
    {
        $customer_id   = $request['customer_id'];
         $all_data = [
            "symbol"        => $request['symbol'], // نوع معدن التداول
            "gram_k"        => $request['gram_k'],  // الحصول على العيار
            "take_profit"   => $request['take_profit'], // تحديد نسبة الربح
            "stop_loss"     => $request['stop_loss'], // تحديد نسبة الخسارة
            "gram"          => $request['gram'],  // تحديد عدد الجرامات
            "order_type"    => $request['order_type'],
            "price_gram_k"  => $data[$request->gram_k],  // الحصول على سعر العيار
            "currency"      => $data["currency"],  // العملة
        ];

        $order = OrderTrade::create([
            "customer_id"=>$customer_id,
            'details' => $all_data, // حفظ البيانات في العمود JSON
        ]);

        return response()->json($order, 201);  // رد بنجاح مع البيانات المخزنة

    }
}

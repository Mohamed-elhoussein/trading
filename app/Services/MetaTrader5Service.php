<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class MetaTrader5Service
{
    protected $server;
    protected $login;
    protected $password;
    protected $id;
    public function __construct()
    {
        $this->server = env('MT5_SERVER');
        $this->login = env('MT5_LOGIN');
        $this->password = env('MT5_PASSWORD');
        $this->id = env('MT5_ID');

    }

    // إتمام الاتصال بـ MT5
    public function connectt()
    {
        $url = "https://mt5.mtapi.io/ConnectEx";


        $response = Http::get($url, [
            'user' => $this->login,
            'password' => $this->password,
            'server' => $this->server,
        ]);

          // التحقق من الاستجابة
    if ($response->successful()) {
        // إرجاع النتيجة إذا كان الطلب ناجحًا
        return response()->json([
            'status' => 'success',
            'data' => $response->body(),
        ]);
    } else {
        // إذا حدث خطأ
        return response()->json([
            'status' => 'error',
            'message' => $response->body(),
        ]);
    }
    }

    // للحصول علي سعر الذهب والفضه


    public function GetPrice()
    {

        $response = Http::get("https://mt5.mtapi.io/GetQuoteMany?id={$this->id}&symbols=XAUUSD&symbols=XAGUSD");

        if ($response->successful()) {
            return response()->json([
                'status' => 'success',
                'data' => json_decode($response->body(), true), // فك التشفير للبيانات
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => $response->body(),
            ]);
        }
    }




    // فتح صفقة شراء
    public function openBuyOrder($symbol, $lotSize, $price)
    {
        $url = "https:///api/v1/order";

        $response = Http::post($url, [
            'server' => $this->server,
            'login' => $this->login,
            'password' => $this->password,
            'action' => 'BUY',
            'symbol' => $symbol,
            'lot_size' => $lotSize,
            'price' => $price,
        ]);

        return $response->json();
    }

    // فتح صفقة بيع
    public function openSellOrder($symbol, $lotSize, $price)
    {
        $url = "https://your_mt5_server_address/api/v1/order";

        $response = Http::post($url, [
            'server' => $this->server,
            'login' => $this->login,
            'password' => $this->password,
            'action' => 'SELL',
            'symbol' => $symbol,
            'lot_size' => $lotSize,
            'price' => $price,
        ]);

        return $response->json();
    }

    // استعلام رصيد الحساب
    public function getBalance()
    {
        $url = "https://your_mt5_server_address/api/v1/balance";

        $response = Http::post($url, [
            'server' => $this->server,
            'login' => $this->login,
            'password' => $this->password,
        ]);

        return $response->json();
    }
}

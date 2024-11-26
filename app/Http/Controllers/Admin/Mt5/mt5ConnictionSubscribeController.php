<?php

namespace App\Http\Controllers\Admin\Mt5;

use Illuminate\Http\Request;
use Ratchet\Client\WebSocket;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class mt5ConnictionSubscribeController extends Controller
{
    public function connectToAPI()
    {

        try {
            // استرجاع البيانات من ملف البيئة
            $user        = config('services.mt5.user');
            $password    = config('services.mt5.password');
            $server      = config('services.mt5.server');



            $url = "https://mt5.mtapi.io/ConnectEx?user={$user}&password={$password}&server={$server}";

            // إرسال الطلب إلى MT5 API
            $response = Http::get($url);

            if ($response->failed()) {
                return response()->json(['error' => 'Connection failed'], 500);
            }

            $id = $response->body();
            return response()->json(['id' => $id]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function subscribeToSymbols($id)
    {
        try {
            $symbols = 'XAUUSD,XAGUSD';
            $url = "https://mt5.mtapi.io/SubscribeMany?id={$id}&symbols={$symbols}";

            $response = Http::get($url);

            // تحقق من أن الاستجابة تحتوي على نتيجة صحيحة
            if ($response->successful()) {
                return response()->json([
                    'message' => 'Subscribed successfully',
                    'status' => $response->status(),
                    'data' => $response->json() // إرسال البيانات الفعلية من الاستجابة
                ]);
                $this->getPrice($response->json());
            } else {
                return response()->json([
                    'error' => 'Subscription failed',
                    'status' => $response->status(),
                    'response' => $response->json()
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function getPrice()
    {

        $id=$this->connectToAPI();
        $id=$this->subscribeToSymbols($id);
        try {
            // WebSocket URL
            $wsUrl = "wss://mt5.mtapi.io/OnQuote?id={$id}";

            // الاتصال بـ WebSocket
            connect($wsUrl)->then(function(WebSocket $conn) {
                // فتح الاتصال بنجاح
                echo "WebSocket connection established.\n";

                // إرسال رسائل أو استقبال البيانات من WebSocket
                $conn->on('message', function($msg) use ($conn) {
                    echo "Received: {$msg}\n";

                    // معالجة البيانات (مثال: تحويل البيانات إلى JSON)
                    $data = json_decode($msg, true);
                    if (isset($data['type']) && $data['type'] === 'Quote') {
                        $symbol = $data['data']['symbol'];
                        $bid = $data['data']['bid'];
                        $ask = $data['data']['ask'];

                        // إرجاع البيانات عبر JSON
                        return response()->json([
                            'symbol' => $symbol,
                            'bid' => $bid,
                            'ask' => $ask
                        ]);
                    }
                });

                // إرسال رسالة إلى الخادم (إذا لزم الأمر)
                // $conn->send('Some message');
            }, function ($e) {
                // في حال فشل الاتصال بـ WebSocket
                echo "Could not connect: {$e->getMessage()}\n";
                return response()->json(['error' => 'Failed to connect to WebSocket'], 500);
            });
        } catch (\Exception $e) {
            // التعامل مع الأخطاء
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}



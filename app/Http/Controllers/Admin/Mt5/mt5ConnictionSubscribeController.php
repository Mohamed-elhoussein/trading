<?php

namespace App\Http\Controllers\Admin\Mt5;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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

}

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
            $user     = config('services.mt5.user');
            $password = config('services.mt5.password');
            $host     = config('services.mt5.host');
            $port     = config('services.mt5.port');

            // بناء الرابط API
            $url = "https://mt5.mtapi.io/Connect?user={$user}&password={$password}&host={$host}&port={$port}";

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

            if ($response->failed()) {
                return response()->json(['error' => 'Subscription failed'], 500);
            }

            return response()->json(['message' => 'Subscribed successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}

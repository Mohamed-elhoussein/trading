<?php
namespace App\Services;

use Log;
use GuzzleHttp\Client;
use Ratchet\Client\Connector as RatchetConnector;
use React\Socket\Connector;
use React\EventLoop\Factory;
use Ratchet\Client\WebSocket;
use Illuminate\Support\Facades\Http;

class Mt5Service{
    protected $user;
    protected $password;
    protected $host;
    protected $port;
    protected $token;

    public function __construct()
    {
        $this->user     = env('MT5_USER');
        $this->password = env('MT5_PASSWORD');
        $this->host     = env('MT5_HOST');
        $this->port     = env('MT5_PORT');

    }

    public function connect()
    {

        $client = new Client();

        try {
             $url = "https://mt5.mtapi.io/Connect";
            $params = [
                'query' => [
                    'user' => $this->user ,
                    'password' => $this->password,
                    'host' => $this->host ,
                    'port' => $this->port,
                ]
            ];

            $response = $client->request('GET', $url, $params);
            $body = $response->getBody()->getContents();

            // تسجيل محتوى الاستجابة
            \Log::info('Response Body: ' . $body);

            // افترض أن الجسم هو التوكن
        $this->token=trim($body); // إزالة أي فراغات
            return response()->json(['token' => $this->token]); // إرجاع التوكن
        } catch (RequestException $e) {
            return response()->json(['error' => 'Unable to connect to MT5: ' . $e->getMessage()], 500);
        }


    }


    public function getGoldPrice()
    {
        if (!$this->token) {
            return null;
        }
        $client = new Client();
        try {
            $url = "https://mt5.mtapi.io/GetQuote";
            $params = [
                'query' => [
                    'id' => $this->token ,
                    'symbol' => 'XAGUSD',
                ],
                'headers' => [
                    'Authorization' => "Bearer {$this->token}",
                ],
            ];

            // استدعاء API لجلب سعر الذهب
            $response = $client->request('GET', $url, $params);
            $body = $response->getBody()->getContents();

            // تسجيل محتوى الاستجابة
            \Log::info('Gold Price Response: ' . $body);

            // تحويل الجسم إلى مصفوفة
            $data = json_decode($body, true);

            // تحقق من الاستجابة وارجع البيانات
            return isset($data['bid']) ? $data : null;

        } catch (RequestException $e) {
            \Log::error('Unable to fetch gold price: ' . $e->getMessage());
            return null;
        }
    }




    public function GetRealTimePrice()
    {
        $client = new Client();
        $prices = []; // مصفوفة لتخزين الأسعار
        // Step 1: Connect to the API and get the ID
        $response = $client->get("https://mt5.mtapi.io/Connect", [
            'query' => [
                'user' => $this->user,
                'password' => $this->password,
                'host' => $this->host,
                'port' => $this->port,
            ],
        ]);

        $id = trim($response->getBody()->getContents());

        // Step 2: Subscribe to symbols
        $client->get("https://mt5.mtapi.io/SubscribeMany", [
            'query' => [
                'id' => $id,
                'symbols' => 'XAUUSD,XAGUSD',
            ],
        ]);

        // Step 3: Create WebSocket connection
        $loop = Factory::create();
        $connector = new RatchetConnector($loop, new Connector($loop));

        $wsUrl = "wss://mt5.mtapi.io/OnQuote?id=$id";

        $connector($wsUrl)
            ->then(function(WebSocket $conn) use ($id) {
                Log::info("Connected to WebSocket with ID: $id");

                $conn->on('message', function($msg) {
                    echo "<pre>";
                    echo "Received message: {$msg}\n";

                });

                $conn->on('close', function($code = null, $reason = null) {
                    Log::info("Connection closed ({$code} - {$reason})");
                });
            }, function($e) {
                Log::error("Could not connect: {$e->getMessage()}");
            });

        $loop->run();

}

    public function disconnect()
    {
        if ($this->token) {
            Http::withToken($this->token)->get("{$this->host}:{$this->port}/Disconnect");
        }
    }
}

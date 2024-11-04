<?php
namespace App\Jobs;

use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use React\EventLoop\Factory;
use Ratchet\Client\Connector as RatchetConnector;

class FetchRealTimePrices implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function handle()
    {
        $loop = Factory::create();
        $connector = new RatchetConnector($loop);

        $wsUrl = "wss://mt5.mtapi.io/OnQuote?id=" . $this->token;

        $connector($wsUrl)
            ->then(function($conn) {
                \Log::info("Connected to WebSocket");

                $conn->on('message', function($msg) {
                    $decodedEvent = json_decode($msg, true);
                    if (isset($decodedEvent['data'])) {
                        $symbol = $decodedEvent['data']['symbol'];
                        $bid = $decodedEvent['data']['bid'];
                        $ask = $decodedEvent['data']['ask'];

                        // إرسال البيانات عبر Ajax باستخدام GuzzleHttp
                        $client = new Client();
                        $client->post('http://127.0.0.1:8000/api/update-prices', [
                            'form_params' => [
                                'symbol' => $symbol,
                                'bid' => $bid,
                                'ask' => $ask,
                            ]
                        ]);

                        \Log::info("Stored price for $symbol - Bid: $bid, Ask: $ask");
                    }
                });

                $conn->on('close', function($code = null, $reason = null) {
                    \Log::info("Connection closed ({$code} - {$reason})");
                });
            }, function($e) {
                \Log::error("Could not connect: {$e->getMessage()}");
            });

        $loop->run();
    }
}

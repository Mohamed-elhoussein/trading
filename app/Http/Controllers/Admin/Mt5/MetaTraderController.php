<?php
namespace App\Http\Controllers\Admin\Mt5;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\MetaTrader5Service;

class MetaTraderController extends Controller
{
    protected $mt5Service;

    public function __construct(MetaTrader5Service $mt5Service)
    {
        $this->mt5Service = $mt5Service;
    }


    public function connect ()
    {
    return $this->mt5Service->connectt();
    }


    //معرفه سعر الذهب والفضه
    public function GetPriceGoldSeliver()
    {
        return $this->mt5Service->GetPrice();
    }
    // فتح صفقة شراء
    public function openBuy(Request $request)
    {
        $symbol = $request->input('symbol', 'EURUSD');
        $lotSize = $request->input('lot_size', 0.1);
        $price = $request->input('price', 1.12345);

        $result = $this->mt5Service->openBuyOrder($symbol, $lotSize, $price);

        return response()->json($result);
    }

    // فتح صفقة بيع
    public function openSell(Request $request)
    {
        $symbol = $request->input('symbol', 'EURUSD');
        $lotSize = $request->input('lot_size', 0.1);
        $price = $request->input('price', 1.12345);

        $result = $this->mt5Service->openSellOrder($symbol, $lotSize, $price);

        return response()->json($result);
    }

    // استعلام الرصيد
    public function getBalance()
    {
        $result = $this->mt5Service->getBalance();
        return response()->json($result);
    }
}

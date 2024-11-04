<?php

namespace App\Http\Controllers\Admin\Mt5;

use App\Services\Mt5Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GoldPriceController extends Controller
{
    protected $Mt5Service;
    public function __construct(Mt5Service $Mt5Service)
    {
        $this->Mt5Service=$Mt5Service;
    }

    public function index()
    {
        if($this->Mt5Service->connect()){
            return $this->Mt5Service->getGoldPrice();
        }
    }




    public function updatePrices(Request $request)
    {
        // هنا يمكنك معالجة البيانات المرسلة
        $symbol = $request->input('symbol');
        $bid = $request->input('bid');
        $ask = $request->input('ask');

        // مثلاً، يمكنك تخزين البيانات أو تحديثها في قاعدة البيانات

        return response()->json(['success' => true]);
    }
}

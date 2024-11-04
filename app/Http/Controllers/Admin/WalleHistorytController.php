<?php

namespace App\Http\Controllers\admin;

use App\Models\wallet;
use Illuminate\Http\Request;
use App\Models\walletHistory;
use App\Http\Controllers\Controller;

class WalleHistorytController extends Controller
{
     public function getWalletHistory($wallet_id)
     {

        $history=walletHistory::where("wallet_id",$wallet_id)->with("wallet.customer")->get();
        return response()->json($history);
     }
}

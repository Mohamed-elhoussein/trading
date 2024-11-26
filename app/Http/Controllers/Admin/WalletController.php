<?php

namespace App\Http\Controllers\admin;

use App\Models\wallet;
use App\Models\Currancy;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class walletController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $customer=Customer::get();
        $wallets=wallet::with("currancy","customer")->get();
        if($request->is("api/trading/wallet")){
            return response()->json(["data"=>$wallets],200);
        }

        return view('admin.Wallet.list',compact('customer','wallets'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'customer_id_' => 'required|exists:customers,id', // تأكد من وجود المستخدم
            'amount'      => 'required|numeric|min:0',
        ]);

        // البحث عن المحفظة
        $wallet = Wallet::where('customer_id', $request->customer_id_)->first();

        if (!$wallet) {
            $wallet = Wallet::create([
                'customer_id'   => $request->customer_id_,
                'current_amount' => $request->amount,
                'opend'         => $request->amount,
            ]);
        } else {
            $wallet->current_amount += $request->amount;
            $wallet->save();
            $wallet["add_amount"] = $request->amount;
        }


        // سجل التاريخ
        $wallet->history()->create([
            'action' => 'add balance ',
            'amount' => $request->amount,
        ]);
        if($request->is("api/trading/wallet")){
            return response()->json(["message"=>"success open wallet","data"=>$wallet],201);
        }
        return to_route('wallet.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

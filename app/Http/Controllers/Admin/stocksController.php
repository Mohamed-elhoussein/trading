<?php

namespace App\Http\Controllers\Admin;

use App\Models\tradingstock;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\tradingStockRequest;

class stocksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $stocks=tradingstock::get();
        return view("admin.Stocks.list");
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(tradingStockRequest $request)
    {

        $stocks=tradingstock::create($request->toArray());
        Toastr::success("successfully created");
        return response()->json([
            "date"=>$stocks->created_at->format('Y-m-d'),
            "id"=>$stocks->id,
        ]);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        tradingstock::where("id",$id)->update($request->except("_token","_method"));
        return to_route('stocks.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        tradingstock::where("id",$id)->delete();
    }
}

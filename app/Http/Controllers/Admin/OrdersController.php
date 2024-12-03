<?php

namespace App\Http\Controllers\Admin;

use Crypt;
use Carbon\Carbon;
// use App\Models\order;
use App\Models\Order;
use App\Models\Stock;
use App\Utils\helper;
use App\Models\wallet;
use App\Models\Customer;
use App\Models\tradingstock;
use Illuminate\Http\Request;
use App\Models\oredr_history;
use App\Models\walletHistory;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\OrderRequest;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;


class OrdersController extends Controller
{

    public function index(Request $request)
    {

        $customer=Customer::get();
        $orders=Order::get();
        if($request->is("api/trading/getOrder")){
            if ($orders->isEmpty()) {
                return response()->json([
                    'message' => 'No orders found'
                ], 404);
            }

            // إرجاع البيانات في استجابة JSON
            return response()->json([
                'data' => $orders
            ]);
        }else{
            return view('admin.orders.index',compact('customer',"orders"));

        }
    }



    public function getPriceStock($id){
        $priceStock = tradingstock::where("id", $id)->first("price");
        return response()->json($priceStock);

    }

    public function CurrentPriceStock($symbol)
    {
        $MT5_ID=env("MT5_ID");
        return $response=Http::get("https://mt5.mtapi.io/GetQuote?id={$MT5_ID}&symbol={$symbol}");

    }

    public function store(OrderRequest $request)
    {

        $symbol=$request["symbol"];
        $response=$this->CurrentPriceStock($symbol);
        $price=$response["ask"];
        $request["volume"]=$request->quantity/31.1035;
        $total = $request->total_price ?? $request["volume"]  * $price;
        $request["openPrice"]=$price;
        $request["total_price"] = $total;
        $request["operation"]="buy";
        $request["profit"]="0";
        $customer_id = $request->customer_id;

        // البحث عن المحفظة
        $dataUser=wallet::CheckAmountFound($request);

        $userAmount = $dataUser->current_amount;



        // التحقق مما إذا كان المستخدم لديه ما يكفي من المال
        if ($userAmount >= $total) {
            // استخدام المعاملات
            DB::transaction(function () use ($request, $dataUser, $total ,&$order) {
                // إنشاء الطلب
                $order = order::create($request->toArray());

                $newAmountUser = $dataUser->current_amount - $total;

                // تحديث المبلغ في المحفظة
                $dataUser->update(["current_amount" => $newAmountUser]);

                // إضافة سجل في تاريخ المحفظة
                walletHistory::create([
                    "wallet_id" => $dataUser->id,
                    "action" => "The amount was deducted to enter into a deal",
                    "amount" => $total
                ]);

                // إدخال تاريخ الطلب
                $trading_type="local";
                oredr_history::InsertHistory($order, $order->id ,$trading_type ,"open");

            });
            if($request->is("api/trading/CreateOrder")){
                return response()->json(["message" => "Create Order successfully","data"=>$order],201);
            }

            Toastr::success("success create Order");

        } else {


            if($request->is("api/trading/CreateOrder")){
                return response()->json(["message" => "Your amount is not enough to create an order"],404);
            }
            Toastr::error("Your amount is not enough to create an order.");

        }

    }







    public function update (Request $request)
    {
        // return $request;
        $orderStatus   =$request->order_status;
        $id            =$request->order_id;
        $data=order::where("id",$id);
        $order=$data->where("delivery","0")->first();

            if (!$order) {
            if($request->is("api/trading/UpdateOrder")){
            return response()->json(["message" => "Order not found or already delivered."],404);
            }
            return Toastr::error("Order not found or already delivered.");
            }

        $current_price =$request->current_price ?? $this->CurrentPriceStock($order["symbol"])["bid"] ;
        $price_bid=$order->volume * $current_price;
        $profit = $price_bid - $order->total_price; // حساب الربح


        if($orderStatus!=="closed"){
            if($request->is("api/trading/UpdateOrder")){
                return response()->json(["message" => "The order already Opening"],404);
            }
            return Toastr::error("The order already Opening");

        }

          if ($orderStatus == "closed") {
                $order->update([
                    'operation'=>'Sell',
                    'closePrice' => $current_price, // حفظ سعر الإغلاق
                    // 'total_price' => $current_price,
                    'profit' => $profit, // حفظ الربح
                    'order_status'=>'closed',
                    'delivery' => "1", // تحديث حالة التسليم
                ]);

            $newData = $order->fresh();
            wallet::WalletAccount($current_price , $profit , $order["customer_id"]);
            oredr_history::InsertHistory($newData , $id  , "local" , "closed");
            if($request->is("api/trading/UpdateOrder")){
                return response()->json(["message" => "successfully close order","data"=>$newData],201);
            }

            Toastr::success("successfully close order");
        }else{
            if($request->is("api/trading/UpdateOrder")){
                return response()->json(["message" =>"you have error"],404);
            }
            Toastr::error("You cannot modify the transaction. The transaction has expired");
        }


    }




    public function destroy($id)
    {
        $order=order::where("id",$id)->first();
        $oredrStatus="Deleted Order";
        if($order){
            $order->delete();
            Toastr::success("successfully Deleted Order");
            return to_route('orders.index');

        }else{
            Toastr::success("not found this order",'error');
            return to_route('orders.index');
        }

    }

}

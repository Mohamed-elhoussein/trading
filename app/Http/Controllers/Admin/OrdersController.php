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


class OrdersController extends Controller
{

    public function index(Request $request)
    {
        $customer=Customer::get();
        $orders=Order::get();
        return view('admin.orders.index',compact('customer',"orders"));
    }



    public function getPriceStock($id){
        $priceStock = tradingstock::where("id", $id)->first("price");
        return response()->json($priceStock);

    }



    public function store(OrderRequest $request)
    {


        $request["operation"]="buy";
        $customer_id = $request->customer_id;
        $total = $request->total_price;

        // البحث عن المحفظة
        $dataUser=wallet::CheckAmountFound($request);

        $userAmount = $dataUser->current_amount;


        // التحقق مما إذا كان المستخدم لديه ما يكفي من المال
        if ($userAmount >= $total) {
            // استخدام المعاملات
            DB::transaction(function () use ($request, $dataUser, $total) {
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

            Toastr::success("success create Order");

        } else {
            Toastr::error("Your amount is not enough to create an order.");

        }

    }







    public function update (Request $request)
    {
        // return $request;
        $orderStatus   =$request->order_status;
        $id            =$request->order_id;
        $current_price =$request->current_price;
        $data=order::where("id",$id);
        $order=$data->where("delivery","0")->first();

        if (!$order) {
            return Toastr::error("Order not found or already delivered.");
        }

        if($orderStatus!=="closed"){
            return Toastr::error("The order already Opening");

        }
            $closePrice = $current_price / $order->volume; // لحساب سعر الاونصه في حاله الغلق
            $profit     = $current_price - $order->total_price; // حساب الربح

          if ($orderStatus == "closed") {
                $order->update([
                    'operation'=>'Sell',
                    'closePrice' => $closePrice, // حفظ سعر الإغلاق
                    'total_price' => $current_price,
                    'profit' => $profit, // حفظ الربح
                    'order_status'=>'closed',
                    'delivery' => "1", // تحديث حالة التسليم
                ]);

            $newData = $order->fresh();
            wallet::WalletAccount($current_price , $profit );
            oredr_history::InsertHistory($newData , $id  , "local" , "closed");
            Toastr::success("successfully close order");
        }else{
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

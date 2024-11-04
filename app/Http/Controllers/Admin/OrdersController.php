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
        // $orders = Order::with(['customer', 'stock'])
        // ->selectRaw('*, (quantity * price) AS total_price')
        // ->get();
        $customer=Customer::get();
        $orders=Order::get();
        // $stock=tradingstock::get();
        // return view('admin.orders.index', ['orders' => $orders,'customer'=>$customer,"stock"=>$stock]);
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
        $dataUser = wallet::where("customer_id", $customer_id)->first();

        // التحقق من وجود المستخدم والمحفظة
        if (!$dataUser) {
         Toastr::error("user not found");
        }

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
                oredr_history::InsertHistory($order->id);
            });

            Toastr::error("success create Order");

        } else {
            Toastr::error("Your amount is not enough to create an order.");

        }

    }







    public function update (Request $request)
    {
        // return $request;
        $oredrStatus   =$request->order_status;
        $id            =$request->order_id;
        $current_price =$request->current_price;


        $delivery  = $oredrStatus=="closed"?"1":"0";
        $operation = $oredrStatus=="closed"?"sells":"buy";
        $request["delivery"]=$delivery;
        $request["total_price"]=$current_price;


        $oredr=order::where("id",$id)->where("delivery","0")->first();
        if($oredr){
            $oredr->update([
                "operation"=>$operation,
                "total_price"  =>$current_price,
                "order_status" =>$oredrStatus,
                "delivery"=>$delivery
            ]);

            oredr_history::InsertHistory($id,$oredrStatus);
            Toastr::success("successfully updated");
        }else{
            Toastr::error("You cannot modify the transaction. The transaction has expired");
        }


    }




    public function destroy($id)
    {
        $order=order::where("id",$id)->first();
        $oredrStatus="Deleted Order";
        oredr_history::InsertHistory($id,$oredrStatus);

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

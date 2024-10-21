<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Utils\helper;
// use App\Models\order;
use App\Models\PeroidGlobel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Redis;
use App\Http\Requests\OrderStatusChangeUpdateRequest;
// use App\Models\orderInstallment;
use Carbon\Carbon;

class OrdersController extends Controller
{
    public function index(Request $request)
    {
        // $baseQuery = Order::with(['period', 'status', 'bank', 'program_type','customer'])->get();
        // dd($baseQuery);
        $data = order::get();
        $transformedData = helper::transformDataByLanguage($data->toArray());

        return view('admin.orders.index', ['orderStatus' => $transformedData]);
    }

    // public function getData(Request $request)
    // {

    //     $query = Order::with(['period', 'status', 'bank', 'program_type']);

    //     if (isset($request->program_type_id) && $request->program_type_id != null) {
    //         $query->where('program_type_id', $request->program_type_id);
    //     }

    //     if (isset($request->order_status) &&  $request->order_status != null) {
    //         $query->where('order_status', $request->order_status);
    //     }

    //     if (isset($request->sort) &&  $request->sort != null) {
    //         $query->orderBy('created_at', $request->sort);
    //     }

    //     $data = $query->get()->toArray();
    //     $transformedData = helper::transformDataByLanguage($data);
    //     return response()->json([
    //         'data' => $data,
    //         'message' => 'found data'
    //     ]);
    // }
    public function getData(Request $request, $id = null)
    {
        $baseQuery = Order::with(['period', 'status', 'bank', 'program_type', 'customer']);

        if ($id !== null && $id != 0) {
            $baseQuery->where('order_status', $id);
        }

        // Define a unique cache key for the total count based on potential search terms
        $search = $request->input('search.value');

        if (!empty($search)) {
            $baseQuery->where(function ($query) use ($search) {
                $query->where('total', 'LIKE', "%{$search}%")
                    ->orWhere('interest', 'LIKE', "%{$search}%")
                    ->orWhere('full_account_name', 'LIKE', "%{$search}%")
                    ->orWhere('account_number', 'LIKE', "%{$search}%")
                    ->orWhere('created_at', 'LIKE', "%{$search}%")
                    ->orWhereHas('period', function ($query) use ($search) {
                        $query->where('title_ar', 'LIKE', "%{$search}%")
                            ->orWhere('title_en', 'LIKE', "%{$search}%");
                    })
                    ->orWhereHas('bank', function ($query) use ($search) {
                        $query->where('title_ar', 'LIKE', "%{$search}%")
                            ->orWhere('title_en', 'LIKE', "%{$search}%");
                    })
                    ->orWhereHas('program_type', function ($query) use ($search) {
                        $query->where('title_ar', 'LIKE', "%{$search}%")
                            ->orWhere('title_en', 'LIKE', "%{$search}%");
                    })
                    ->orWhereHas('status', function ($query) use ($search) {
                        $query->where('title_ar', 'LIKE', "%{$search}%")
                            ->orWhere('title_en', 'LIKE', "%{$search}%");
                    });
            });
            // Re-compute total data as search criteria changed
            $totalData = $baseQuery->count();
        } else {
            $totalData = $baseQuery->count();
        }

        // Sorting and pagination as per DataTables request
        $columns = ['interest', 'total', 'full_account_name', 'account_number', 'created_at', 'period.title_en', 'status.title_en', 'bank.title_en', 'customer.phone', 'id'];
        $orderColumnIndex = $request->input('order.0.column', 0);
        $orderDir = $request->input('order.0.dir', 'asc');
        $orderColumn = $columns[$orderColumnIndex] ?? 'created_at';  // Safe default if out of range
        $baseQuery->orderBy($orderColumn, $orderDir);

        $start = $request->input('start', 0);
        $length = $request->input('length', 10);
        $data = $baseQuery->offset($start)->limit($length)->get();

        return response()->json([
            'draw' => intval($request->draw),
            'recordsTotal' => $totalData,
            'recordsFiltered' => $totalData,
            'data' => $data
        ]);
    }

    public function order_details($id)
    {

        $baseQuery = Order::with(['period', 'status', 'bank', 'program_type', 'customer', 'installments', 'contracts.contract'])->where('id', $id)->first();
        $details = helper::transformDataByLanguage($baseQuery->toArray());

        $data = orderStatus::get();
        $transformedData = helper::transformDataByLanguage($data->toArray());


        return view('admin.orders.details', ['order_status' => $transformedData, 'details' => $details]);
    }

    public function order_status(OrderStatusChangeUpdateRequest $request, $id)
    {
        $order = Order::find($id);

        if (!$order) {
            Toastr::error(__('Order not found.'), __('Error'));
            return redirect()->back();
        }

        if ($order->order_status == 2) {
            Toastr::error(__('Sorry, this order has already been approved and its status cannot be changed.'), __('Error'));
            return redirect()->back();
        }

        if ($request->order_status == 2) {
            $period = PeroidGlobel::find($order->peroid_globle);

            if (!$period) {
                Toastr::error(__('Period information not found.'), __('Error'));
                return redirect()->back();
            }

            $order->order_status = 2;
            $order->save();

            $installmentValue = $order->total / $period->num_months;

            $installments = [];
            for ($i = 1; $i <= $period->num_months; $i++) {
                $installments[] = [
                    'piad_date' => now()->addMonths($i),
                    'value' => $installmentValue,
                    'status' => 0, // Unpaid
                    'order_id' => $order->id,
                    'parent_id' => 0,
                    'type' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            DB::table('order_installments')->insert($installments);
        } else {
            $order->order_status = $request->order_status;
            $order->save();
        }

        Toastr::success(__('Order status updated successfully.'), __('Success'));
        return redirect()->back();
    }
    public function installment(){
        return view('admin.orders.list_installment');

    }
    public function installment_datatable(){
        $month =  Carbon::now();
        $year =  Carbon::now();
        $data = OrderInstallment::with('order.customer')
        ->whereMonth('piad_date', $month)
        ->whereYear('piad_date', $year)
        ->get();
        return response()->json([
            'data' => $data,
            'message' => 'found data'
        ]);

    }
    public function installment_status($id){
      $data=  OrderInstallment::where('id',$id)->first();

      if($data){
        $data->status=!$data->status;
        $data->save();
        Toastr::success(__('successfully change status installment .'), __('Success'));
        return redirect()->back();
      }else{
        Toastr::error(__('Not Found this  .'), __('Error'));
        return redirect()->back();
      }
    }
    public function installment_history(){
        return view('admin.orders.installment_history');
    }
    public function installment_history_datatable(){
        $data = Order::with('order.customer')
        ->get();
        return response()->json([
            'data' => $data,
            'message' => 'found data'
        ]);

    }

}

<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Customer;
use App\Models\Countries;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Claims\Custom;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;

class CustomerController extends Controller
{
    public function index(){
          $county=Countries::get();
        return view('admin.Customers.list',compact('county'));
    }
    public function getData()
    {
        $data = Customer::with('country')->get();

        return response()->json([
            'data' => $data,
            'message' => 'found data'
        ]);
    }

    public function is_verified($id){
        $customer=Customer::find($id);
        if($customer){
            $customer->email_verified=!$customer->email_verified;
            $customer->save();

            Toastr::success(__('Successfully change verified'), __('Success'));

            return redirect()->back();

        }else{
            Toastr::error(__('not found this customer'), __('Error'));
            return redirect()->back();

        }

    }


    public function  store(Request $request)
    {
        Customer::create($request->toArray());
        Toastr::success("success create new user", __('Success'));
        return to_route('customer.index');
    }


    public function update(Request $request)
    {
        return $request;
        $id=$request->id;
        Customer::where("id",$id)->update($request->except("_token","submit"));
        return to_route('customer.index');

    }


    public function delete(Request $request)
    {
        $id=$request->customer_id;
        Customer::where("id",$id)->delete();
    }

}

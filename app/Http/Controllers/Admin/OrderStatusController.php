<?php

namespace App\Http\Controllers\Admin;

use App\Models\orderStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Requests\OrderStatusRequest;
use App\Http\Requests\OrderStatusUpdateRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class OrderStatusController extends Controller
{
    ///start types
    public function index()
    {

        return view('admin.orderstatus.list');
    }
    public function getData()
    {
        $data = orderStatus::all();

        return response()->json([
            'data' => $data,
            'message' => 'found data'
        ]);
    }

    public function store(OrderStatusRequest $request)
    {
        try {
            $requestData = $request->all();


            orderStatus::create($requestData);


            Toastr::success(__('Order Status Created Successfully'), __('Success'));

            return redirect()->back();
        } catch (\Throwable $th) {
            Toastr::error(__('Try Again'), __('Error'));
            return redirect()->back();
        }
    }

    public function update(OrderStatusUpdateRequest $request)
    {
        try {
            if ($request->input('id') > 3) {


                // Find the category by ID
                $Peroid = orderStatus::findOrFail($request->input('id'));

                // Get the validated data, excluding 'id'
                $requestData = $request->except('id');

                // Update the Peroid with the validated data
                $Peroid->update($requestData);

                // Display success message and redirect to index
                Toastr::success(__('Order Status Updated Successfully'), __('Success'));
                return redirect()->back();
            } else {
                Toastr::info(__('not allow'), __('Info'));
                return redirect()->back();
            }
        } catch (\Throwable $th) {
            // Display error message and redirect back
            Toastr::error(__('Try Again'), __('Error'));
            return redirect()->back();
        }
    }

    public function delete(orderStatus $orderStatu)
    {
        try {
            if ($orderStatu->id > 3) {

                $orderStatu->delete(); // Soft delete the Category

                Toastr::success(__('Order Status Deleted Successfully'), __('Success'));

                return redirect()->back();
            } else {
                Toastr::info(__('not allow'), __('Info'));
                return redirect()->back();
            }
        } catch (ModelNotFoundException $exception) {
            Toastr::error(__('Order Status Not Found'), __('Error'));
            return redirect()->back();
        } catch (\Throwable $th) {
            Toastr::error(__('Something went wrong. Please try again.'), __('Error'));
            return redirect()->back();
        }
    }
}

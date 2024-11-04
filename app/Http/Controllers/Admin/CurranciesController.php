<?php

namespace App\Http\Controllers\Admin;

use App\Models\Currancy;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Requests\CurrencyStoreRequest;
use App\Http\Requests\CurrencyUpdateRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CurranciesController extends Controller
{
    ///start types
    public function index()
    {

        return view('admin.currancy.list');
    }
    public function getData()
    {
        $data = Currancy::all();

        return response()->json([
            'data' => $data,
            'message' => 'found data'
        ]);
    }

    public function store(CurrencyStoreRequest $request)
    {
        try {
            $requestData = $request->all();


            Currancy::create($requestData);


            Toastr::success(__('Currency Created Successfully'), __('Success'));

            return redirect()->back();
        } catch (\Throwable $th) {
            Toastr::error(__('Try Again'), __('Error'));
            return redirect()->back();
        }
    }

    public function update(CurrencyUpdateRequest $request)
    {
        return "sds";
        try {
            // Find the category by ID
            $Currancy = Currancy::findOrFail($request->input('id'));
            // Get the validated data, excluding 'id'
            $requestData = $request->except('id');

            // Update the Peroid with the validated data
            $Currancy->update($requestData);

            // Display success message and redirect to index
            Toastr::success(__('Currancy Updated Successfully'), __('Success'));
            return redirect()->back();
        } catch (\Throwable $th) {
            // Display error message and redirect back
            Toastr::error(__('Try Again'), __('Error'));
            return redirect()->back();
        }
    }

    public function status(Request $request)
    {
        $dataval = $request->validate([
            'id' => 'required|exists:currancies,id'
        ]);


            $data = Currancy::where('id', '=', $dataval['id'])->first();
            if ($data) {

                $data->status = !$data->status;
                $data->update();
                $successMessage = $data->status == 1 ?
                    __('validation_custom.status_update_active') :
                    __('validation_custom.status_update_inactive');

                return $successMessage;

        }else{
            return response()->json(['status' => '404']);

        }

    }

}

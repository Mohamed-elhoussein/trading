<?php

namespace App\Http\Controllers\Admin;

use App\Models\Countries;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Requests\CountryStoreRequest;
use App\Http\Requests\CountryUpdateRequest;

class CountryController extends Controller
{
       ///start types
       public function index()
       {

           return view('admin.countries.list');
       }
       public function getData()
       {
           $data = Countries::all();

           return response()->json([
               'data' => $data,
               'message' => 'found data'
           ]);
       }

       public function store(CountryStoreRequest $request)
       {
           try {
               $requestData = $request->all();


               $data=Countries::create($requestData);


               Toastr::success(__('Country Created Successfully'), __('Success'));
                if($request->is("api/trading/country/store")){
                    return response()->json(["message"=>"Country Created Successfully","data"=> $data],201);
                }
               return redirect()->back();
           } catch (\Throwable $th) {
               Toastr::error(__('Try Again'), __('Error'));
               return redirect()->back();
           }
       }

       public function update(CountryUpdateRequest $request)
       {
           try {
               // Find the category by ID
               $Currancy = Countries::findOrFail($request->input('id'));

               // Get the validated data, excluding 'id'
               $requestData = $request->except('id');

               // Update the Peroid with the validated data
               $Currancy->update($requestData);

               // Display success message and redirect to index
               Toastr::success(__('Country Updated Successfully'), __('Success'));

               if($request->is("api/trading/country/update")){
                return response()->json(["message"=>"Country Updated Successfully"]);
            }
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
               'id' => 'required|exists:countries,id'
           ]);


               $data = Countries::where('id', '=', $dataval['id'])->first();
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

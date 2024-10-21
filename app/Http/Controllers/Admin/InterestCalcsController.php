<?php

namespace App\Http\Controllers\Admin;

use App\Utils\helper;
use App\Models\InterestCalc;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Requests\InterestCalcsStoreRequest;
use App\Http\Requests\InterestCalcsUpdateRequest;
use App\Models\PeroidGlobel;

class InterestCalcsController extends Controller
{
    public function index()
    {
        $Periods = PeroidGlobel::get();
        $transformedData = helper::transformDataByLanguage($Periods->toArray());

        return view('admin.interest_calcs.index', ['Periods' => $transformedData]);
    }

    public function getData()
    {
        $data = InterestCalc::with('period')
        ->join('peroid_globels', 'interest_calcs.period_globle_id', '=', 'peroid_globels.id')
        ->orderBy('peroid_globels.num_months', 'asc')
        ->select('interest_calcs.*') // Ensure to select fields from interest_calcs to avoid ambiguity
        ->get();
        $transformedData = helper::transformDataByLanguage($data->toArray());

        return response()->json([
            'data' => $transformedData,
            'message' => 'found data'
        ]);
    }
    public function store(InterestCalcsStoreRequest $InterestCalcs)
    {
        try {
            $requestData = $InterestCalcs->all();


            InterestCalc::create($requestData);


            Toastr::success(__('Interest Calculator Created Successfully'), __('Success'));

            return redirect()->back();
        } catch (\Throwable $th) {
            Toastr::error(__('Try Again'), __('Error'));
            return redirect()->back();
        }
    }
    public function update(InterestCalcsUpdateRequest $request)
    {
        try {
            // Find the category by ID
            $Peroid = InterestCalc::findOrFail($request->input('id'));

            // Get the validated data, excluding 'id'
            $requestData = $request->except('id');

            // Update the Peroid with the validated data
            $Peroid->update($requestData);

            // Display success message and redirect to index
            Toastr::success(__('Interest Calculator Updated Successfully'), __('Success'));
            return redirect()->back();
        } catch (\Throwable $th) {
            // Display error message and redirect back
            Toastr::error(__('Try Again'), __('Error'));
            return redirect()->back();
        }
    }
    public function delete(InterestCalc $InterestCalc)
    {
        if ($InterestCalc) {
            $InterestCalc->delete();
            Toastr::success(__('Interest Calculator Deleted Successfully'), __('Success'));
            return redirect()->back();
        } else {
            Toastr::error(__('sorry not found'), __('Error'));
            return redirect()->back();
        }
    }
}

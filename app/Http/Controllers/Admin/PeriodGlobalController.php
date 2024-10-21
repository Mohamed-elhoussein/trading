<?php

namespace App\Http\Controllers\Admin;

use App\Models\PeroidGlobel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Requests\PeroidGlobalStoreRequest;
use App\Http\Requests\PeroidGlobalUpdateRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PeriodGlobalController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('permission:ageRange');
    // }



    public function index()
    {

        return view('admin.period_global.index');
    }

    public function getData()
    {
        $data = PeroidGlobel::all()??"";

        return response()->json([
            'data' => $data,
            'message' => 'found data'
        ]);
    }

    public function create()
    {
        return view('admin.period_global.create');
    }

    public function store(PeroidGlobalStoreRequest $PeroidGlobalStore)
    {
        try {
            $requestData = $PeroidGlobalStore->all();


            PeroidGlobel::create($requestData);


            Toastr::success(__('Peroid Global Created Successfully'), __('Success'));

            return redirect()->route('period.global.index');
        } catch (\Throwable $th) {
            Toastr::error(__('Try Again'), __('Error'));
            return redirect()->back();
        }
    }

    public function edit(PeroidGlobel $PeroidGlobel)
    {

        return view('admin.period_global.edit', compact('PeroidGlobel'));
    }

    public function update(PeroidGlobalUpdateRequest $request)
{
    try {
        // Find the category by ID
        $Peroid = PeroidGlobel::findOrFail($request->input('id'));

        // Get the validated data, excluding 'id'
        $requestData = $request->except('id');

        // Update the Peroid with the validated data
        $Peroid->update($requestData);

        // Display success message and redirect to index
        Toastr::success(__('Peroid Global Updated Successfully'), __('Success'));
        return redirect()->route('period.global.index');
    } catch (\Throwable $th) {
        // Display error message and redirect back
        Toastr::error(__('Try Again'), __('Error'));
        return redirect()->back();
    }
}


public function archive(PeroidGlobel $PeroidGlobel)
{
    try {
        $PeroidGlobel->delete(); // Soft delete the Category

        Toastr::success(__('Peroid Global Archived Successfully'), __('Success'));

        return redirect()->back();
    } catch (ModelNotFoundException $exception) {
        Toastr::error(__('Peroid Global Not Found'), __('Error'));
        return redirect()->back();
    } catch (\Throwable $th) {
        Toastr::error(__('Something went wrong. Please try again.'), __('Error'));
        return redirect()->back();
    }
}

public function archiveList()
{

    return view('admin.period_global.archive');
}
public function getArchived()
{

    $data = PeroidGlobel::onlyTrashed()->get();


    return response()->json([
        'data' => $data,
        'message' => 'found data'
    ]);
}

public function restore($id)
{
    try {
        PeroidGlobel::withTrashed()
            ->where('id', $id)
            ->restore();
        Toastr::success(__('Peroid Global Restored Successfully'), __('Success'));

        return redirect()->route('period.global.index');
    } catch (ModelNotFoundException $exception) {
        Toastr::error(__('Peroid Global Not Found'), __('Error'));
        return redirect()->back();
    } catch (\Throwable $th) {
        Toastr::error(__('Something went wrong. Please try again.'), __('Error'));
        return redirect()->back();
    }
}


}

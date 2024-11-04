<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UsersCreateRequest;
use App\Http\Requests\UsersUpdateRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UsersController extends Controller
{

    ///start types
    public function index()
    {

        // return response()->json(User::all());
        return view('admin.Users.list');
    }
    public function getData()
    {
        $data = User::all();

        return response()->json([
            'data' => $data,
            'message' => 'found data'
        ]);
    }

    public function store(UsersCreateRequest $request)
    {
        try {
            $requestData = $request->all();

            // Handle file upload for the logo
            // Handle file upload for the logo
            if ($request->hasFile('logo') && $request->file('logo')->isValid()) {
                $logoName = time() . '.' . $request->logo->getClientOriginalExtension();
                $directory = 'logos'; // Change this to your desired directory name
                $request->logo->move(public_path($directory), $logoName);
                $logoPath = $directory . '/' . $logoName;
                $requestData['logo'] = $logoPath;
            }

            // Hash the password
            if (isset($requestData['password'])) {
                $requestData['password'] = Hash::make($requestData['password']);
            }

            // Create the user
            User::create($requestData);

            // Display success message
            Toastr::success(__('User Created Successfully'), __('Success'));

            return redirect()->back();
        } catch (\Throwable $th) {
            // Handle errors
            Toastr::error(__('Try Again'), __('Error'));
            return redirect()->back()->withInput();
        }
    }
    public function update(UsersUpdateRequest $request)
    {
        try {
            // Find the user by ID
            $user = User::findOrFail($request->input('id'));

            // Get the validated data from the request
            $requestData = $request->validated();

            // Handle file upload for the logo
            if ($request->hasFile('logo') && $request->file('logo')->isValid()) {
                $logoName = time() . '.' . $request->logo->getClientOriginalExtension();
                $directory = 'logos'; // Change this to your desired directory name
                $request->logo->move(public_path($directory), $logoName);
                $logoPath = $directory . '/' . $logoName;
                $requestData['logo'] = $logoPath;
            } elseif (!$request->hasFile('logo')) {
                unset($requestData['logo']);
            }

            // Hash the password
            if (isset($requestData['password'])) {
                $requestData['password'] = Hash::make($requestData['password']);
            } else {
                unset($requestData['password']);
            }

            // Update the user with the validated data
            $user->update($requestData);

            // Display success message and redirect back
            Toastr::success(__('User Updated Successfully'), __('Success'));
            return redirect()->back();
        } catch (\Throwable $th) {
            // Display error message and redirect back
            Toastr::error(__('Try Again'), __('Error'));
            return redirect()->back();
        }
    }

    public function delete(User $Banks)
    {
        try {
            $Banks->delete(); // Soft delete the Category

            Toastr::success(__('User Deleted Successfully'), __('Success'));

            return redirect()->back();
        } catch (ModelNotFoundException $exception) {
            Toastr::error(__('Bank Not Found'), __('Error'));
            return redirect()->back();
        } catch (\Throwable $th) {
            Toastr::error(__('Something went wrong. Please try again.'), __('Error'));
            return redirect()->back();
        }
    }
    public function status(Request $request)
    {
        $dataval = $request->validate([
            'id' => 'required|exists:users,id'
        ]);

        if($dataval['id'] !=1){
            $data = User::where('id', '=', $dataval['id'])->first();
            if ($data) {

                $data->status = !$data->status;
                $data->update();
                $successMessage = $data->status == 1 ?
                    __('validation_custom.status_update_active') :
                    __('validation_custom.status_update_inactive');

                return $successMessage;
            } else {
                return response()->json(['status' => '404']);
            }
        }else{
            return response()->json(['status' => '404']);

        }

    }
    public function unoth(){
        return view('errors.unoth');
    }
}

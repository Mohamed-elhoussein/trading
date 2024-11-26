<?php

namespace App\Http\Controllers\admin;

use App\Models\setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Requests\SettingRequest;

class settingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        if(setting::count()==1){
            $setting=setting::get();
            $setting[0]["logo"]= asset("storage/images/")."/".$setting[0]["logo"];
            return view('admin.setting.list',compact('setting'));

        }
        $setting=[];
        return view('admin.setting.list',compact('setting'));



        //  return response()->json([
        //     "message"=>"you dont have any settings"
        //  ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SettingRequest $request)
    {



        $count=setting::count();
        if($count==0){
            $logo=setting::SaveLogo($request);
                $data=new setting();
                    $data->logo=$logo;
                    $data->name=$request->name;
                    $data->description=$request->description;
                    $data->instagram=$request->instagram;
                    $data->whatsApp=$request->whatsApp;
                    $data->facebook=$request->facebook;
                    $data->snapchat=$request->snapchat;
                    $data->email=$request->email;
                    $data->phone=$request->phone;
                    $data->save();

                    Toastr::success("successfully created a new setting");
                    return to_route('setting.index');
                // return response()->json([
                //     "message"=>"success add setting ",
                //     "data"=>$data
                // ]);

        }

        Toastr::error("you have setting data you can update or delete and return add new data");
        return to_route('setting.index');
        // return response()->json([
        //     "message"=>"you have setting data you can update or delete and return add new data"
        // ]);


    }



    /**
     * Update the specified resource in storage.
     */
    public function update(SettingRequest $request, string $id)
    {
        $setting=setting::where("id",$id);

        if($setting->count()==1){


        if(isset($request->logo))
        {
        return setting::updateSettingWithFile($request,$id);
        }

        $update=setting::where("id", $id)
        ->update($request->except("_token","_method","submit"));

        return to_route('setting.index');

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data=setting::where("id", $id)->first();
        if($data){
            $data->delete();
            return to_route('setting.index');
        }
        Toastr::error("you have error",'error');
        return to_route('setting.index');


    }

}

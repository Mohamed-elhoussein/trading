<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class setting extends Model
{
    use HasFactory;
    protected $guarded=['id'];



    public static function DeleteLogo($id)
    {
        $oldLogo=setting::where('id', $id)->first("logo")["logo"];
        $fileDelete=storage_path("app/public/images/$oldLogo");
         unlink($fileDelete);
    }


    public static function SaveLogo($request)
    {
        if($request->hasFile('logo')) {
            $ex=pathinfo($request->logo->getClientOriginalName(),PATHINFO_EXTENSION);
            $imageName = md5(uniqid()).'.'.$ex;
            $pathlogo=asset("storage/images/$imageName");
            $request->logo->storeAs("public/images/$imageName");
            return $imageName;
        }

    }


    public static function updateSettingWithFile($request,$id)
    {
                setting::DeleteLogo($id);
                $newName=setting::SaveLogo($request);

                setting::where("id",$id)->update([

                "logo"       =>$newName,
                "name"       =>$request->name,
                "description"=>$request->description,
                "instagram"  =>$request->instagram,
                "whatsApp"   =>$request->whatsApp,
                "facebook"   =>$request->facebook,
                "snapchat"   =>$request->snapchat,
                "email"      =>$request->email,
                "phone"      =>$request->phone,
            ]);
            return to_route('setting.index');
            //    return response()->json([
            //    "message"=>"success update setting with file",
            //    ]);
    }

}

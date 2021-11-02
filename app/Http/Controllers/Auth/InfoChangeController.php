<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class InfoChangeController extends Controller
{

    public function infoChange(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'country' => 'required|string|max:255',
        ]);
        $user = Auth::user();
        $user->name = $request->input("name");
        $user->surname = $request->input("surname");
        $user->country = $request->input("country");
        $user->save();

        $intent = Auth::user()->createSetupIntent();

        Session::flash('message', "Informacija sėkmingai atnaujinta");
        return Redirect::to('dashboard/profile');
    }
    public function passwordChange(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8',
            'new_password' => 'required|string|confirmed|min:8',
        ]);
        $user = Auth::user();
        $intent = Auth::user()->createSetupIntent();
        if(Hash::check($request->input("password"), $user->password)){
            $user->password = Hash::make($request->input("new_password"));
        }else{
            return view("dashboard.profile")->with("message", "Jūsų dabartinis slaptažodis neteisingas")->with("intent", $intent);
        }
        $user->save();

        Session::flash('message', "Informacija sėkmingai atnaujinta");
        return Redirect::to('dashboard/profile');
    }
    public function photoChange(Request $request)
    {
        $intent = Auth::user()->createSetupIntent();

        foreach ($request->all() as $item => $value) {
            if(Str::startsWith($item, "student_")){
                $student_id = str_replace("student_", "", $item);
                $student = Student::find($student_id);
                if(!$student) {
                    return view("dashboard.profile")->with("message", "Studentas su ID " . $student_id . " nerastas.")->with("intent", $intent);
                }
                $studentName = $student->name;
                $students = Student::where("name", "LIKE", $studentName)->where("user_id", $student->user_id)->get();
                foreach ($students as $student) {
                    $file = $request->file($item);

                    $filename = $file->getClientOriginalName();

                    if($file->getSize() > 1024*1024*2) {
                        return view("dashboard.profile")->with("message", "Įkelto failo dydis per didelis. Max - 2 MB.")->with("intent", $intent);
                    }

                    if(!Str::endsWith($filename,".png") && !Str::endsWith($filename,".jpeg") && !Str::endsWith($filename,".jpg")) {
                        return view("dashboard.profile")->with("message", "Įkeltas netinkamas failas.")->with("intent", $intent);
                    }

                    $newfilename = Auth::user()->id . "-" . Str::random(16) . "." . $file->getClientOriginalExtension();

                    $file->storeAs("uploads/students", $newfilename);

                    $student->photo = $newfilename;
                    $student->save();
                }
                
            }
        }

        Session::flash('message', "Informacija sėkmingai atnaujinta");
        return Redirect::to('dashboard/profile');
    }


    public function profilePhotoChange(Request $request)
    {
        $request->validate([
            "file" => ["required","max:2048","mimes:jpg,png,jpeg"]
        ]);

        $intent = Auth::user()->createSetupIntent();

        $file = $request->file("file");

        $newfilename = Auth::user()->id . "-" . Str::random(16) . "." . $file->getClientOriginalExtension();

        $file->storeAs("uploads/users", $newfilename);

        $user = Auth::user();
        $user->photo = $newfilename;
        $user->save();

        Session::flash('message', "Informacija sėkmingai atnaujinta");
        return Redirect::to('dashboard/profile');
    }


    public function pagesNameChange(Request $request) {
        if(Auth::user()->role != "admin"){
            return view("dashboard.error")->with("error", "Neturite teisių pasiekti šį puslapį.");
        }

        $data = $request->except('_token');

        foreach ($data as $key => $value) {
            if($value){
                $newName = mb_strtolower(str_replace(" ","_",$value));
                $newName = preg_replace('@\?.*$@' , '', preg_replace('@\.{2,}@' , '', $newName));
                rename(env("APP_LOCATION")."/views/landing/".mb_strtolower(str_replace("_blade", "", $key)).".blade.php", env("APP_LOCATION")."/views/landing/".$newName.".blade.php");
            }
        }

        return json_encode(["status" => "success"]);
    }

    public function pageDelete(Request $request) {
        if(Auth::user()->role != "admin"){
            return view("dashboard.error")->with("error", "Neturite teisių pasiekti šį puslapį.");
        }

        if(!unlink($request->input("page"))){
            return json_encode(["status" => "error", "message" => "Could not unlink file"]);
        }

        return json_encode(["status" => "success"]);
    }

    public function fileUpload(Request $request) {
        if(Auth::user()->role != "admin"){
            return view("dashboard.error")->with("error", "Neturite teisių pasiekti šį puslapį.");
        }

        $file = $request->file("file");

        $newfilename = Auth::user()->id . "-" . Str::random(16) . "." . $file->getClientOriginalExtension();

        $file->storeAs("uploads/page-uploads", $newfilename);

        return \Config::get('app.url')."/uploads/page-uploads/".$newfilename;
    }

}
<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Introduction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\Image\Exceptions\InvalidManipulation;
use Spatie\Image\Image;

class IntroductionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        if(Auth::user()->role == "user"){
            return view("dashboard.error")->with("error", "Neturite teisių pasiekti šį puslapį.");
        }
        $introductions = Introduction::where("id", ">", 0);
        if($request->input("search")){
            $introductions = $introductions->where("name", "LIKE", "%" . $request->input("search") . "%");
        }

        $introductions = $introductions->orderBy("id", "ASC");
        return view("dashboard.introductions.index")->with("meetings", $introductions->paginate(15)->withQueryString());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        if(Auth::user()->role != "admin"){
            return view("dashboard.error")->with("error", "Neturite teisių pasiekti šį puslapį.");
        }
        return view("dashboard.introductions.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     * @throws InvalidManipulation
     */
    public function store(Request $request)
    {
        if(Auth::user()->role != "admin"){
            return view("dashboard.error")->with("error", "Neturite teisių pasiekti šį puslapį.");
        }
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'join_link' => 'required|string',
            'date_at' => 'required|string'
        ]);

        $introduction = new Introduction;

        $introduction->name = $request->input("name");
        $introduction->description = $request->input("description");
        $introduction->join_link = $request->input("join_link");
        $introduction->is_public = $request->input("is_public");
        $introduction->is_private = $request->input("is_private");
        $introduction->show_date = $request->input("show_date");

        $date = Carbon::createFromFormat("Y-m-d\TH:i", $request->input("date_at"));
        $isDst = Carbon::now()->timezone('Europe/London')->isDST();
        if($isDst){
            $date = $date->subHour();
        }
        
        $introduction->date_at = $date;

        $file = $request->file('file');
        if($file) {
            $newfilename = Auth::user()->id . "-" . Str::random(16) . "." . $file->getClientOriginalExtension();
            $file->storeAs("uploads/introductions", $newfilename);
            $introduction->photo = $newfilename;
            Image::load("uploads/introductions/".$newfilename)
                ->height(560, 840)
                ->save();
        }
        $introduction->save();

        Session::flash('message', "Susitikimas sėkmingai sukurtas");
        return Redirect::to('dashboard/introductions');
    }

    /**
     * Display the specified resource.
     *
     * @param Introduction $introduction
     * @return void
     */
    public function show(Introduction $introduction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Introduction $introduction
     * @return Response
     */
    public function edit(Introduction $introduction) {
        if(Auth::user()->role != "admin"){
            return view("dashboard.error")->with("error", "Neturite teisių pasiekti šį puslapį.");
        }
        return view("dashboard.introductions.edit")->with("meeting", $introduction);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Introduction $introduction
     * @return Response
     * @throws InvalidManipulation
     */
    public function update(Request $request, Introduction $introduction)
    {
        if(Auth::user()->role != "admin"){
            return view("dashboard.error")->with("error", "Neturite teisių pasiekti šį puslapį.");
        }
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'join_link' => 'required|string',
            'date_at' => 'required|string'
        ]);

        $introduction->name = $request->input("name");
        $introduction->description = $request->input("description");
        $introduction->join_link = $request->input("join_link");
        $introduction->is_public = $request->input("is_public");
        $introduction->is_private = $request->input("is_private");
        $introduction->show_date = $request->input("show_date");

        $date = Carbon::createFromFormat("Y-m-d\TH:i", $request->input("date_at"));
        $isDst = Carbon::now()->timezone('Europe/London')->isDST();
        if($isDst){
            $date = $date->subHour();
        }

        $introduction->date_at = $date;

        $file = $request->file('file');
        if($file) {
            if (!empty($introduction->photo)) {
                Storage::delete("uploads/pages/introduction/".$introduction->photo);
            }
            $newfilename = Auth::user()->id . "-" . Str::random(16) . "." . $file->getClientOriginalExtension();
            $file->storeAs("uploads/introductions", $newfilename);
            $introduction->photo = $newfilename;
            Image::load("uploads/introductions/".$newfilename)
                ->height(560, 840)
                ->save();
        }

        $introduction->save();

        Session::flash('message', "Susitikimas sėkmingai atnaujintas");
        return Redirect::to('dashboard/introductions');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Introduction $introduction
     * @return Response
     */
    public function destroy(Introduction $introduction)
    {
        if(Auth::user()->role != "admin"){
            return view("dashboard.error")->with("error", "Neturite teisių pasiekti šį puslapį.");
        }
        $introduction->delete();
        Session::flash('message', "Susitikimas sėkmingai ištrintas");
        return Redirect::to('dashboard/introductions');
    }
}

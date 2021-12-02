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
        $meetings = Introduction::where("id", ">", 0);
        if($request->input("search")){
            $meetings = $meetings->where("name", "LIKE", "%" . $request->input("search") . "%");
        }

        $meetings = $meetings->orderBy("id", "ASC");
        return view("dashboard.meetings_public.index")->with("meetings", $meetings->paginate(15)->withQueryString());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        if(Auth::user()->role != "admin"){
            return view("dashboard.error")->with("error", "Neturite teisių pasiekti šį puslapį.");
        }
        return view("dashboard.meetings_public.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
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

        $meeting = new Introduction;
        $meeting->name = $request->input("name");
        $meeting->description = $request->input("description");
        $meeting->join_link = $request->input("join_link");

        $date = Carbon::parse($request->input("date_at"), 'Europe/London');
        $date->setTimezone('GMT');

        $meeting->date_at = $date;

        $file = $request->file('file');
        if($file) {
            $newfilename = Auth::user()->id . "-" . Str::random(16) . "." . $file->getClientOriginalExtension();
            $file->storeAs("uploads/introductions", $newfilename);
            $meeting->photo = $newfilename;
            Image::load("uploads/introductions/".$newfilename)
                ->height(560)
                ->save();
        }
        $meeting->save();

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
    public function edit(Introduction $introduction)
    {
        if(Auth::user()->role != "admin"){
            return view("dashboard.error")->with("error", "Neturite teisių pasiekti šį puslapį.");
        }
        return view("dashboard.meetings_public.edit")->with("meeting", $introduction);
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

        $date = Carbon::parse($request->input("date_at"), 'Europe/London');
        $date->setTimezone('GMT');
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
                ->height(560)
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

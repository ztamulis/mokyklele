<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use App\TimeZoneUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class MeetingController extends Controller
{
    public function index(Request $request)
    {
        if(Auth::user()->role == "user"){
            return view("dashboard.error")->with("error", "Neturite teisių pasiekti šį puslapį.");
        }
        $meetings = Meeting::where("id", ">", 0);
        if($request->input("search")){
            $meetings = $meetings->where("name", "LIKE", "%" . $request->input("search") . "%");
        }

        $meetings = $meetings->orderBy("id", "ASC");
        return view("dashboard.meetings.index")->with("meetings", $meetings->paginate(15)->withQueryString());
    }

    public function create() {
        if(Auth::user()->role != "admin"){
            return view("dashboard.error")->with("error", "Neturite teisių pasiekti šį puslapį.");
        }
        return view("dashboard.meetings.create");
    }

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

        $meeting = new Meeting;
        $meeting->name = $request->input("name");
        $meeting->description = $request->input("description");
        $meeting->join_link = $request->input("join_link");
        $meeting->show_date = $request->input("show_date");

        $date = Carbon::parse($request->input("date_at"), 'Europe/London');

        $isDst = Carbon::now()->setTimezone('Europe/London')->isDST();
        if($isDst){
            $date = $date->subHour();
        }

        $meeting->date_at = $date;

        $file = $request->file('file');
        if($file) {
            $newfilename = Auth::user()->id . "-" . Str::random(16) . "." . $file->getClientOriginalExtension();
            $file->storeAs("uploads/meetings", $newfilename);
            $meeting->photo = $newfilename;
        }
        $meeting->save();

        Session::flash('message', "Susitikimas sėkmingai sukurtas");
        return Redirect::to('dashboard/meetings');
    }

    public function edit(Meeting $meeting)
    {
        if(Auth::user()->role != "admin"){
            return view("dashboard.error")->with("error", "Neturite teisių pasiekti šį puslapį.");
        }
        return view("dashboard.meetings.edit")->with("meeting", $meeting);
    }

    public function update(Request $request, Meeting $meeting)
    {
        if(Auth::user()->role != "admin") {
            return view("dashboard.error")->with("error", "Neturite teisių pasiekti šį puslapį.");
        }
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'join_link' => 'required|string',
            'date_at' => 'required|string'
        ]);

        $meeting->name = $request->input("name");
        $meeting->description = $request->input("description");
        $meeting->join_link = $request->input("join_link");
        $meeting->show_date = $request->input("show_date");

        $date = Carbon::parse($request->input("date_at"), 'Europe/London');

        $isDst = Carbon::now()->setTimezone('Europe/London')->isDST();
        if($isDst){
            $date = $date->subHour();
        }

        $meeting->date_at = $date;

        $file = $request->file('file');
        if($file) {
            $newfilename = Auth::user()->id . "-" . Str::random(16) . "." . $file->getClientOriginalExtension();
            $file->storeAs("uploads/meetings", $newfilename);
            $meeting->photo = $newfilename;
        }

        $meeting->save();

        Session::flash('message', "Susitikimas sėkmingai atnaujintas");
        return Redirect::to('dashboard/meetings');
    }

    public function destroy(Meeting $meeting)
    {
        if(Auth::user()->role != "admin"){
            return view("dashboard.error")->with("error", "Neturite teisių pasiekti šį puslapį.");
        }
        $meeting->delete();
        Session::flash('message', "Susitikimas sėkmingai ištrintas");
        return Redirect::to('dashboard/meetings');
    }

    public static function nextMeetingButton($meeting){
        $meet = $meeting->where("date_at", "<" ,\Carbon\Carbon::now('utc')->addMinutes(10))->where("date_at", "<" ,\Carbon\Carbon::now('utc')->endOfDay())->where("date_at", ">" ,\Carbon\Carbon::now('utc')->startOfDay())->first();
        if(isset($meet)){
            return $meet;
        }
        return null;
    }
}
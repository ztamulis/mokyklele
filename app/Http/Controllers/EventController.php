<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Student;
use App\Models\User;
use App\Models\Group;
use App\Models\Event;
use App\TimeZoneUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if(Auth::user()->role == "user"){
            return view("dashboard.error")->with("error", "Neturite teisių pasiekti šį puslapį.");
        }
        $events = Event::where("id", ">", 0)->with('teacher')
            ->with('groups');
        if($request->input("search")){
             $events = $events->where("name", "LIKE", "%" . $request->input("search") . "%");
        }
        if(Auth::user()->role == "teacher"){
            $events = $events->where("teacher_id", Auth::user()->id);
        }
        $events = $events->orderBy("id", "DESC");
        return view("dashboard.events.index")->with("events", $events->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->role != "admin"){
            return view("dashboard.error")->with("error", "Neturite teisių pasiekti šį puslapį.");
        }

        return view("dashboard.events.create")->with("groups", Group::all())->with("teachers", User::where("role","LIKE","teacher")->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::user()->role != "admin"){
            return view("dashboard.error")->with("error", "Neturite teisių pasiekti šį puslapį.");
        }
        $request->validate([
            'create_method' => 'required',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|string|max:255',
            'teacher_id' => 'required|int',
            'date_at' => 'required|string',
        ]);

        $create_method = $request->input("create_method");

        $date = Carbon::createFromFormat("Y-m-d\TH:i", $request->input("date_at"));
        $isDst = Carbon::now()->timezone('Europe/London')->isDST();
        if($isDst){
            $date = $date->subHour();
        }

        if($create_method == "multi"){
            $request->validate([
                'date_at_count' => 'required|int',
                'date_at_interval' => 'required|int',
            ]);
            for ($i = 0; $i < $request->input("date_at_count"); $i++) {
                $event = new Event;
                $event->name = $request->input("name");
                $event->description = $request->input("description");
                $event->type = $request->input("type");
                $event->author_id = Auth::user()->id;
                $event->teacher_id = $request->input("teacher_id");
                $event->join_link = $request->input("join_link");
                $event->date_at = $date;


                $event->save();
                $event->groups()->sync($request->input("groups"));
                $date = $date->addDays($request->input("date_at_interval"));
            }
        }else{
            $event = new Event;
            $event->name = $request->input("name");
            $event->description = $request->input("description");
            $event->type = $request->input("type");
            $event->author_id = Auth::user()->id;
            $event->teacher_id = $request->input("teacher_id");
            $event->join_link = $request->input("join_link");

            $event->date_at = $date;

            $event->save();

            $event->groups()->sync($request->input("groups"));
        }
        Session::flash('message', "Užsiėmimas sėkmingai pridėtas");
        return Redirect::to('dashboard/events');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {

        if(Auth::user()->role != "admin"){
            return view("dashboard.error")->with("error", "Neturite teisių pasiekti šį puslapį.");
        }
        return view("dashboard.events.show")->with("group", $event);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event) {

        if(Auth::user()->role != "admin"){
            return view("dashboard.error")->with("error", "Neturite teisių pasiekti šį puslapį.");
        }
        return view("dashboard.events.edit")->with("event", $event)->with("groups", Group::all())->with("teachers", User::where("role","LIKE","teacher")->get());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        if(Auth::user()->role != "admin"){
            return view("dashboard.error")->with("error", "Neturite teisių pasiekti šį puslapį.");
        }
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|string|max:255',
            'teacher_id' => 'required|int',
            'date_at' => 'required|string',
        ]);

        $event->name = $request->input("name");
        $event->description = $request->input("description");
        $event->type = $request->input("type");
        $event->author_id = Auth::user()->id;
        $event->teacher_id = $request->input("teacher_id");
        $event->join_link = $request->input("join_link");

        $date = Carbon::createFromFormat("Y-m-d\TH:i", $request->input("date_at"));

        $isDst = Carbon::now()->timezone('Europe/London')->isDST();
        if($isDst){
            $date = $date->subHour();
        }

        $event->date_at = $date;

        $event->save();

        $event->groups()->sync($request->input("groups"));

        Session::flash('message', "Užsiėmimas sėkmingai atnaujintas");
        return Redirect::to('dashboard/events');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        if(Auth::user()->role != "admin"){
            return view("dashboard.error")->with("error", "Neturite teisių pasiekti šį puslapį.");
        }
        $event->delete();
        Session::flash('message', "Užsiėmimas sėkmingai ištrintas");
        return Redirect::to('dashboard/events');
    }

    public function clone(Request $request, $id) {
        if(Auth::user()->role != "admin"){
            return view("dashboard.error")->with("error", "Neturite teisių pasiekti šį puslapį.");
        }
        $event = Event::find($id);
        if(!$event) {
            return view("dashboard.error")->with("error", "Užsiėmimas nerastas.");
        }

        $new_event = $event->replicate();
        $new_event->save();
        foreach ($event->groups as $group){
            $new_event->groups()->attach($group->id);
        }

        return redirect("/dashboard/events/".$new_event->id."/edit");
    }

    public function attendances(Request $request, $id) {
        if(Auth::user()->role == "user"){
            return view("dashboard.error")->with("error", "Neturite teisių pasiekti šį puslapį.");
        }

        $event = Event::find($id);
        if(!$event){
            return view("dashboard.error")->with("message", "Užsiėmimas nerastas");
        }

        $students = [];
        foreach ($event->groups as $group) {
            foreach ($group->students as $student){
                $students[] = $student;
            }
        }

        return view("dashboard.events.attendances")->with("students", $students)->with("event", $event);
    }

    public function attendancesPost(Request $request, $id) {
        if(Auth::user()->role == "user"){
            return view("dashboard.error")->with("error", "Neturite teisių pasiekti šį puslapį.");
        }

        $event = Event::find($id);
        if(!$event){
            return view("dashboard.error")->with("message", "Užsiėmimas nerastas");
        }

        Attendance::where("event_id", $event->id)->delete();

        $students = $request->input("students");
        if(!$students) {
            Session::flash('message', "Užsiėmimo lankomumas sėkmingai atnaujintas");
            return Redirect::to('dashboard/events');
        }
//        $studentsReturn = [];
        foreach ($students as $student) {
            $student = Student::find($student);
            if(!$student)
                continue;
            $attendance = new Attendance;
            $attendance->student_id = $student->id;
            $attendance->event_id = $event->id;
            $attendance->save();
//            $studentsReturn[] = $student;
        }

//        $studentsReturn = [];
//        foreach ($event->groups as $group) {
//            foreach ($group->students as $student){
//                $studentsReturn[] = $student;
//            }
//        }

//        return view("dashboard.events.attendances")->with("students", $studentsReturn)->with("event", $event)->with("message", "Įrašyta!");
        Session::flash('message', "Užsiėmimo lankomumas sėkmingai atnaujintas");
        return Redirect::to('dashboard/events');
    }

    public function calendar(Request $request) {
        $daysInMonth = \Carbon\Carbon::now()->daysInMonth;
        $startDate = \Carbon\Carbon::now()->startOfMonth();
        $endDate = \Carbon\Carbon::now()->endOfMonth();
        if($request->input("date")) {
            $daysInMonth = \Carbon\Carbon::parse($request->input("date"))->daysInMonth;
            $startDate = \Carbon\Carbon::parse($request->input("date"))->startOfMonth();
            $endDate = \Carbon\Carbon::parse($request->input("date"))->endOfMonth();
        }

        if(Auth::user()->role == "teacher" || Auth::user()->role == "user") {
            $allStudents = [];
            foreach(Auth::user()->getGroups() as $group){
                foreach($group->students()->pluck("id") as $studentId) {
                    if(!in_array($studentId, $allStudents)){
                        $allStudents[] = $studentId;
                    }
                }
            }
            $allStudents = Student::find($allStudents);
        }else{
            $allStudents = Student::all();
        }

        $students = [];
        foreach ($allStudents as $student) {
            $days = [];
            foreach (Attendance::where("student_id", $student->id)->where("created_at", ">", $startDate)->where("created_at", "<", $endDate)->get() as $attendance) {
                if(!$attendance->event)
                    continue;
                $days[] = $attendance->event->date_at->format("d");
            }
            $students[$student->name."|".($student->group ? $student->group->id : -1)] = $days;
        }

        setlocale(LC_TIME, 'lt_LT');
        \Carbon\Carbon::setLocale('lt');

        return view("dashboard.attendance")->with("daysInMonth", $daysInMonth)->with("students", $students)->with("startDate", $startDate);
    }

    public function teacherCalendar(Request $request) {
        $daysInMonth = \Carbon\Carbon::now()->daysInMonth;
        $startDate = \Carbon\Carbon::now()->startOfMonth();
        $endDate = \Carbon\Carbon::now()->endOfMonth();
        if($request->input("date")) {
            $daysInMonth = \Carbon\Carbon::parse($request->input("date"))->daysInMonth;
            $startDate = \Carbon\Carbon::parse($request->input("date"))->startOfMonth();
            $endDate = \Carbon\Carbon::parse($request->input("date"))->endOfMonth();
        }

        $teachers = [];
        foreach (User::where("role", "teacher")->get() as $teacher) {
            $days = [];
            foreach (Event::where("teacher_id", $teacher->id)->where("date_at", ">", $startDate)->where("date_at", "<", $endDate)->get() as $event) {
                $days[] = $event->date_at->format("d")."|".$event->type;
            }
            $teachers[$teacher->name." ".$teacher->surname] = $days;
        }
        // dd($teachers);

        setlocale(LC_TIME, 'lt_LT');
        \Carbon\Carbon::setLocale('lt');

        return view("dashboard.teacher_statistics")->with("daysInMonth", $daysInMonth)->with("teachers", $teachers)->with("startDate", $startDate);
    }

    public function createZoomMetting(Request $request, $id) {
        if(Auth::user()->role == "user"){
            return view("dashboard.error")->with("error", "Not allowed");
        }

        session(["zoom_group_meeting" => $id]);
        return redirect("https://zoom.us/oauth/authorize?response_type=code&client_id=".env("ZOOM_CLIENT_ID")."&redirect_uri=".url("/dashboard/profile/zoom"));
    }

    public function zoom(Request $request, Event $event) {
        return view("dashboard.groups.zoom")->with("event", $event);
    }

    public function zoomLeave(Request $request) {
        return view("dashboard.groups.zoom_leave");
    }

    /*public function deleteEvent(){
        foreach(Input::get('check') as $eventID) {
            $event = Event::find($eventID);
            $event->delete();
        }
    }*/

}

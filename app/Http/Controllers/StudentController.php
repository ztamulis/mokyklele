<?php

namespace App\Http\Controllers;

use App\Http\Traits\NotificationsTrait;
use App\Models\Student;
use App\Models\Group;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    use NotificationsTrait;

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        if(Auth::user()->role != "admin"){
            return view("dashboard.error")->with("error", "Neturite teisių pasiekti šį puslapį.");
        }
        $students = Student::where("id", ">", 0);
        if($request->input("search")){
            $students = $students->where("name", "LIKE", "%" . $request->input("search") . "%");
        }
        if($request->input("user_id")){
            $students = $students->where("user_id", $request->input("user_id"));
        }

        $students->orderBy('id', 'desc');

        return view("dashboard.students.index")->with("students", $students->paginate(15)->withQueryString());
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
        return view("dashboard.students.create")->with("groups", Group::all())->with("users", User::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request) {
        if(Auth::user()->role != "admin"){
            return view("dashboard.error")->with("error", "Neturite teisių pasiekti šį puslapį.");
        }
        $request->validate([
            'name' => 'required|string|max:255',
            'group_id' => 'required',
            'user_id' => 'required',
        ]);

        $student = new Student;
        $student->name = $request->input("name");
        $student->user_id = $request->input("user_id");
        $student->group_id = $request->input("group_id");

        if($request->input("birthday")) {
            $student->birthday = Carbon::parse($request->input("birthday"));
        }

        $student->save();
        $group = $student->group()->first();
        $user = $student->user()->first();
        if ($group->type !== 'individual') {
            $this->insertUserNotification($user, $group);
        }
        $students = Student::where("id", ">", 0);
        if($request->input("user_id")){
            $students = $students->where("user_id", $request->input("user_id"));
        }
        return view("dashboard.students.index")->with("message", "Mokinys sėkmingai pridėtas")->with("students", $students->paginate(15)->withQueryString());
    }

    /**
     * Display the specified resource.
     *
     * @param Student $student
     * @return Response
     */
    public function show(Student $student) {
        if(Auth::user()->role != "admin"){
            return view("dashboard.error")->with("error", "Neturite teisių pasiekti šį puslapį.");
        }
        return view("dashboard.students.show")->with("student", $student);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Student $student
     * @return Response
     */
    public function edit(Student $student) {
        if(Auth::user()->role != "admin"){
            return view("dashboard.error")->with("error", "Neturite teisių pasiekti šį puslapį.");
        }
        return view("dashboard.students.edit")->with("student", $student)->with("groups", Group::all())->with("users", User::all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Student $student
     * @return Response
     */
    public function update(Request $request, Student $student) {
        if(Auth::user()->role != "admin"){
            return view("dashboard.error")->with("error", "Neturite teisių pasiekti šį puslapį.");
        }
        $request->validate([
            'name' => 'required|string|max:255',
            'group_id' => 'required',
            'user_id' => 'required'
        ]);
        $oldStudentGroupId = $student->group_id;

        $student->name = $request->input("name");
        $student->user_id = $request->input("user_id");
        $student->group_id = $request->input("group_id");

        if($request->input("birthday")) {
            $student->birthday = Carbon::parse($request->input("birthday"));
        }

        $student->save();
        $group = $student->group()->first();
        if ($oldStudentGroupId !== (int)$request->input("group_id")
            && !empty($group)
            && $group->type !== 'individual') {
            $this->changeOrInsertStudentNotification($student, $oldStudentGroupId);
        }
        $students = Student::where("id", ">", 0);
        if($request->input("user_id")){
            $students = $students->where("user_id", $request->input("user_id"));
        }
        return view("dashboard.students.index")->with("message", "Mokinys sėkmingai atnaujintas")->with("students", $students->paginate(15)->withQueryString());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param Student $student
     * @return Response
     */
    public function destroy(Request $request, Student $student)
    {
        if(Auth::user()->role != "admin"){
            return view("dashboard.error")->with("error", "Neturite teisių pasiekti šį puslapį.");
        }
        $this->deleteUserNotification($student);
        $student->delete();
        $students = Student::where("id", ">", 0);
        if($request->input("user_id")){
            $students = $students->where("user_id", $request->input("user_id"));
        }
        return view("dashboard.students.index")->with("message", "Mokinys sėkmingai ištrintas")->with("students", $students->paginate(15)->withQueryString());
    }
}

<?php

namespace App\Models;

use App\Http\Controllers\Auth\Notifications\ResetPasswordNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Cashier\Billable;
use tizis\laraComments\Traits\Commenter;

class User extends Authenticatable
{
    use HasFactory, Notifiable, Billable, Commenter;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'surname',
        'email',
        'password',
        'country',
        'terms',
        'newsletter'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function students() {
        return $this->hasMany(Student::class);
    }

    public function rewards(){
        return $this->belongsToMany(Reward::class)->withTimestamps();
    }

    public function messages() {
        return $this->hasMany(Message::class);
    }

    public function fullName() {
        return $this->name . " " . $this->surname;
    }

    public function sentMessages() {
        return Message::where("author_id", $this->id);
    }
    public function getSentMessagesAttribute() {
        return $this->sentMessages()->get();
    }


    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function roleText() {
        if($this->role == "admin") {
            return "Administratorius";
        }
        if($this->role == "teacher") {
            return "Mokytojas";
        }
        if($this->role == "user") {
            return "Narys";
        }
    }

    public function checkGroup($gid){
        if($this->role == "teacher"){
            foreach(Event::where("teacher_id",$this->id)->get() as $event) {
                foreach ($event->groups as $group){
                    if($group->id == $gid){
                        return true;
                    }
                }
            }
        }
        foreach ($this->students as $student){
            if($student->group && $student->group->id == $gid){
                return true;
            }
        }
        return false;
    }

    public function getGroups(){
        if($this->role == "admin") {
            return Group::all();
        }
        if($this->role == "teacher"){
            $group_ids = [];
            foreach(Event::where("teacher_id",$this->id)->with('groups')->get() as $event) {
                foreach ($event->groups as $group){
                    if(!in_array($group->id, $group_ids)){
                        $group_ids[] = $group->id;
                    }
                }
            }
            return Group::find($group_ids);
        }
        return Group::find($this->students()->pluck("group_id"));
    }


    public function getGroupsPlain(){
        if($this->role == "admin") {
            return Group::all();
        }
        if($this->role == "teacher"){
            $group_ids = [];
            foreach(Event::where("teacher_id",$this->id)->get() as $event) {
                foreach ($event->groups as $group){
                    if(!in_array($group->id, $group_ids)){
                        $group_ids[] = $group->id;
                    }
                }
            }
            return Group::find($group_ids);
        }
        return Group::find($this->students()->groupBy("group_id")->pluck("group_id"));
    }

    public function getGroupedCoursesGroups(){
        if($this->role == "admin") {
            return $this->groupByWeekDays(Group::where('type', '!=', 'bilingualism_consultation')->get());
        }

        if($this->role == "teacher"){
            $group_ids = [];
            foreach(Event::where("teacher_id",$this->id)->get() as $event) {
                foreach ($event->groups as $group){
                    if(!in_array($group->id, $group_ids)){
                        $group_ids[] = $group->id;
                    }
                }
            }

            return $this->groupByWeekDays(Group::whereIn($group_ids)->where('type', '!=',  'bilingualism_consultation')->get());
        }

        $groupIds = $this->students()->groupBy("group_id")->pluck("group_id");
        return $this->groupByWeekDays(Group::whereIn($groupIds)->where('type', '!=',  'bilingualism_consultation')->get());
    }

    public function getGroupedConsultationGroups(){
        if($this->role == "admin") {
            return $this->groupByWeekDays(Group::where('type', '=', 'bilingualism_consultation')->get());
        }

        if($this->role == "teacher"){
            $group_ids = [];
            foreach(Event::where("teacher_id",$this->id)->get() as $event) {
                foreach ($event->groups as $group){
                    if(!in_array($group->id, $group_ids)){
                        $group_ids[] = $group->id;
                    }
                }
            }

            return $this->groupByWeekDays(Group::whereIn($group_ids)->where('type', '=',  'bilingualism_consultation')->get());
        }

        $groupIds = $this->students()->groupBy("group_id")->pluck("group_id");
        return $this->groupByWeekDays(Group::whereIn($groupIds)->where('type', '=',  'bilingualism_consultation')->get());
    }

    private function groupByWeekDays($groups) {
        if (empty($groups)) {
            return [];
        }
        $data = [];
        foreach($groups as $group) {
            $event = $group->events()->where("date_at", ">" ,\Carbon\Carbon::now('utc'))->orderBy("date_at","ASC")->first();
            if (!isset($event->date_at->dayOfWeek)) {
                $data[8][] = $group;
                continue;
            }

            $key = $event->date_at->dayOfWeek;
            if ($key == 0) {
                $key = 7;
            }
            $data[$key][] = $group;
        }

        ksort($data);
        return $data;
    }

    public function getWeekDayName($key) {
        $weekMap = [
            1 => 'Pirmadienis',
            2 => 'Antradienis',
            3 => 'Trečiadienis',
            4 => 'Ketvirtadienis',
            5 => 'Penktadienis',
            6 => 'Šeštadienis',
            0 => 'Sekmadienis',
        ];

        return $weekMap[$key];
    }

    public function studentsInGroup($group) {
        $students = [];
        foreach($this->students as $student) {
            if($student->group_id == $group->id) {
                $students[] = $student;
            }
        }
        return $students;
    }

    public function getUsersListToSend($userTo=null) {
        if (!empty($userTo)) {
            return User::where('id', '=', $userTo)->get();
        }
        if ($this->role === 'admin') {
            return User::where('id', '!=', $this->id)->get();
        }

        if ($this->role === 'teacher') {
            $groups = $this->getGroups();
            if (!empty($groups)) {
                foreach ($groups as $group) {
                    if (!empty($usersId)) {
                        $usersId = array_merge($usersId, $group->students()->get()->pluck('user_id')->toArray());
                    } else {
                        $usersId = $group->students()->get()->pluck('user_id')->toArray();
                    }

                }
            }
            $usersId[] = 23;
            $users = User::whereIn('id', $usersId)->get();


            return $users;
        }
        if ($this->role === 'user') {
            $groups = $this->getGroups();
            if (!empty($groups)) {
                foreach ($groups as $group) {
                    if (!empty($usersId)) {
                        $usersId = array_merge($usersId, $group->students()->get()->pluck('user_id')->toArray());
                    } else {
                        $usersId = $group->students()->get()->pluck('user_id')->toArray();
                    }
                    $usersId = array_merge($usersId, $this->getTeachersids($group));

                }
            }
                //admin id
            $usersId[] = 23;
            $usersIdsUnique = array_unique($usersId);
            $usersIdsFliped = array_flip($usersIdsUnique);
            if (isset($usersIdsFliped[Auth::user()->id])) {
                unset($usersIdsFliped[Auth::user()->id]);
            }

            $users = User::whereIn('id', array_flip($usersIdsFliped))->get();

            return $users;
        }
    }

    public function getTeachersids($group) {
        if (empty($group->events())) {
            return [];

        }

        $lessons = $group->events()->get();
        $teachers = [];
        foreach ($lessons as $lesson) {
            $teacher = $lesson->teacher()->first()->toArray();
            if (!isset($teachers[$teacher['id']])) {
                $teachers[] = $teacher['id'];
            }
        }
        return $teachers;
    }
}

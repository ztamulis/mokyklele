<?php

namespace App\Http\Controllers;

use App\Models\Reward;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class RewardController extends Controller
{
    public function index(Request $request)
    {
        if(Auth::user()->role == "user"){
            return view("dashboard.error")->with("error", "Neturite teisių pasiekti šį puslapį.");
        }
        $reward = Reward::where("id", ">", 0);
        if($request->input("search")){
            $reward->where("name", "LIKE", "%" . $request->input("search") . "%");
        }

        $rewards = $reward->orderBy("id", "DESC");
        return view("dashboard.rewards.index")->with("rewards", $rewards->paginate(15)->withQueryString());
    }

    public function create()
    {
        if(Auth::user()->role != "admin"){
            return view("dashboard.error")->with("error", "Neturite teisių pasiekti šį puslapį.");
        }
        return view("dashboard.rewards.create");
    }

    public function store(Request $request)
    {
        if(Auth::user()->role != "admin"){
            return view("dashboard.error")->with("error", "Neturite teisių pasiekti šį puslapį.");
        }
        $request->validate([
            'name' => 'required|string|max:64',
            'description' => 'required|string|max:512',
            'file' => 'required|max:10000|mimes:jpg,png,svg,gif',
            'attendance_to_get_reward' => 'required|int'
        ]);

        $reward = new Reward;
        $reward->name = $request->input("name");
        $reward->description = $request->input("description");
        $reward->attendance_to_get_reward = $request->input("attendance_to_get_reward");

        $file = $request->file('file');
        $newfilename = Auth::user()->id . "-" . Str::random(16) . "." . $file->getClientOriginalExtension();
        $file->storeAs("uploads/rewards", $newfilename);

        $reward->file = $newfilename;
        $reward->save();

        Session::flash('message', "Apdovanojimas sėkmingai sukurtas");
        return Redirect::to('dashboard/rewards');
    }

    public function edit(Reward $reward)
    {
        if(Auth::user()->role != "admin"){
            return view("dashboard.error")->with("error", "Neturite teisių pasiekti šį puslapį.");
        }
        return view("dashboard.rewards.edit")->with("reward", $reward);
    }

    public function update(Request $request, Reward $reward)
    {
        if(Auth::user()->role != "admin"){
            return view("dashboard.error")->with("error", "Neturite teisių pasiekti šį puslapį.");
        }

        $request->validate([
            'name' => 'required|string|max:64',
            'description' => 'required|string|max:512',
            'file' => 'max:10000|mimes:jpg,png,svg',
            'attendance_to_get_reward' => 'required|int'
        ]);

        $reward->name = $request->input("name");
        $reward->description = $request->input("description");
        $reward->attendance_to_get_reward = $request->input("attendance_to_get_reward");

        if($request->file('file')) {
            $file = $request->file('file');
            $newfilename = Auth::user()->id . "-" . Str::random(16) . "." . $file->getClientOriginalExtension();
            $file->storeAs("uploads/rewards", $newfilename);
            $reward->file = $newfilename;
        }

        $reward->save();

        Session::flash('message', "Apdovanojimas sėkmingai atnaujintas");
        return Redirect::to('dashboard/rewards');
    }

    public function destroy(Reward $reward)
    {
        if(Auth::user()->role != "admin"){
            return view("dashboard.error")->with("error", "Neturite teisių pasiekti šį puslapį.");
        }
        $reward->delete();
        Session::flash('message', "Apdovanojimas sėkmingai ištrintas");
        return Redirect::to('dashboard/rewards');
    }

    public function userRewards(Request $request) {
        return view("dashboard.rewards.current_user_rewards")->with("rewards", Auth::user()->rewards);
    }

    public function adminUserRewards(Request $request, User $user) {
        if(Auth::user()->role != "admin" && Auth::user()->role != "teacher"){
            return view("dashboard.error")->with("error", "Neturite teisių pasiekti šį puslapį.");
        }

        return view("dashboard.rewards.user_rewards")->with("user", $user);
    }

    public function adminUserRewardsPost(Request $request, User $user) {
        if(Auth::user()->role != "admin" && Auth::user()->role != "teacher"){
            return view("dashboard.error")->with("error", "Neturite teisių pasiekti šį puslapį.");
        }

        $user->rewards()->sync($request->input("rewards"));

//        return view("dashboard.rewards.user_rewards")->with("user", $user)->with("message", "Sėkmingai išsaugota.");
        Session::flash('message', "Apdovanojimų priskyrimas sėkmingai atnaujintas.");
        return Redirect::to('dashboard/users');
    }

}
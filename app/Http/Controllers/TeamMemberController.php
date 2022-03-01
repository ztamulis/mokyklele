<?php

namespace App\Http\Controllers;

use App\Models\TeamMember;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\Image\Image;

class TeamMemberController extends Controller {
    public function index() {
        if(Auth::user()->role != "admin"){
            return view("dashboard.error")->with("error", "Neturite teisių pasiekti šį puslapį.");
        }

        $teamMember = TeamMember::latest('created_at')->paginate(15)->withQueryString();
        return view("dashboard.team_member.index")->with("teamMember", $teamMember);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create() {
        if(Auth::user()->role != "admin"){
            return view("dashboard.error")->with("error", "Neturite teisių pasiekti šį puslapį.");
        }

        return view("dashboard.team_member.create");
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request) {
        if(Auth::user()->role != "admin"){
            return view("dashboard.error")->with("error", "Neturite teisių pasiekti šį puslapį.");
        }
        $request->validate([
            'full_name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $teamMember = new TeamMember();
        $teamMember->full_name = $request->input("full_name");
        $teamMember->description = $request->input("description");



        $file = $request->file('img');
        if($file) {
            $newfilename = Auth::user()->id . "-" . Str::random(16) . "." . $file->getClientOriginalExtension();
            $file->storeAs("uploads/team_member/", $newfilename);
            $teamMember->img = $newfilename;
        }
        $teamMember->save();

        Session::flash('message', "Komandos narys sukurtas sėkmingai");
        return Redirect::to(route('pages.team-member.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param TeamMember $teamMember
     * @return void
     */
    public function show(TeamMember $teamMember) {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param TeamMember $teamMember
     * @return void
     */
    public function edit(TeamMember $teamMember) {
        if(Auth::user()->role != "admin"){
            return view("dashboard.error")->with("error", "Neturite teisių pasiekti šį puslapį.");
        }
        return view("dashboard.team_member.edit")->with("teamMember", $teamMember);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param TeamMember $teamMember
     * @return RedirectResponse
     */
    public function update(Request $request, TeamMember $teamMember) {

        if(Auth::user()->role != "admin"){
            return view("dashboard.error")->with("error", "Neturite teisių pasiekti šį puslapį.");
        }
        $request->validate([
            'full_name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $teamMember->full_name = $request->input("full_name");
        $teamMember->description = $request->input("description");


        $file = $request->file('img');
        if($file) {
            $newfilename = Auth::user()->id . "-" . Str::random(16) . "." . $file->getClientOriginalExtension();
            $file->storeAs("uploads/team_member/", $newfilename);
            $teamMember->img = $newfilename;
            Image::load("uploads/team_member/".$newfilename)
                ->height(400)
                ->width(400)
                ->save();
        }
        $teamMember->save();

        Session::flash('message', "Komandos narys sukurtas sėkmingai");
        return Redirect::to(route('pages.team-member.index'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param TeamMember $teamMember
     * @return RedirectResponse
     */
    public function destroy(TeamMember $teamMember) {
        if(Auth::user()->role != "admin"){
            return view("dashboard.error")->with("error", "Neturite teisių pasiekti šį puslapį.");
        }
        Storage::delete('/uploads/team_member/'.$teamMember->img);
        $teamMember->delete();
        Session::flash('message', "Komandos narys ištrinti sėkmingai");
        return Redirect::to(route('pages.team-member.index'));
    }
}

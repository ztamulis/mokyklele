<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\SettingsModels\MeetingPageContent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\Image\Exceptions\InvalidManipulation;
use Spatie\Image\Image;

class MeetingsPageController extends Controller {
    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit() {
        if(Auth::user()->role != "admin"){
            return view("dashboard.error")->with("error", "Neturite teisių pasiekti šį puslapį.");
        }
        return view("dashboard.generalsettings.edit")->with("pageContent", app(MeetingPageContent::class)->getPageContent());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param MeetingPageContent $meetingsPageContent
     * @return RedirectResponse
     * @throws InvalidManipulation
     */
    public function update(Request $request, MeetingPageContent $meetingsPageContent) {
        $meetingsPageContent->site_name = $request->input('name');
        $meetingsPageContent->description = $request->input('description');
        $file = $request->file('file');
        if($file) {
            if (!empty($meetingsPageContent->img)) {
                Storage::delete("uploads/pages/introduction/".$meetingsPageContent->img);
            }

            $newfilename = Auth::user()->id . "-" . Str::random(16) . "." . $file->getClientOriginalExtension();
            $file->storeAs("uploads/pages/introduction", $newfilename);
            $meetingsPageContent->img = $newfilename;
            Image::load("uploads/pages/introduction/".$newfilename)
                ->height(560, 840)
                ->save();
        }
        $meetingsPageContent->save();
        Session::flash('message', "Susitikimų puslapis sėkmingai atnaujintas");
        return Redirect::to('dashboard/introductions');
    }
}

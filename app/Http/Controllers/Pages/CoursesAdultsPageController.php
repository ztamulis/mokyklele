<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\SettingsModels\CoursesAdultsPageContent;
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

class CoursesAdultsPageController extends Controller {
    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit() {
        if (Auth::user()->role != "admin") {
            return view("dashboard.error")->with("error", "Neturite teisių pasiekti šį puslapį.");
        }
        return view("dashboard.cms-pages.courses_adults.edit")->with("coursesPageContent",
            app(CoursesAdultsPageContent::class)->getPageContent());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  CoursesAdultsPageContent  $coursesAdultsPageContent
     * @return RedirectResponse
     * @throws InvalidManipulation
     */
    public function update(Request $request, CoursesAdultsPageContent $coursesAdultsPageContent) {

        $coursesAdultsPageContent->main_title = !empty($request->input('main_title')) ? $request->input('main_title') : '';
        $coursesAdultsPageContent->main_description = !empty($request->input('main_description')) ? $request->input('main_description') : '';
        $coursesAdultsPageContent->main_component = !empty($request->input('main_component')) ? $request->input('main_component') : '';
        $coursesAdultsPageContent->second_component = !empty($request->input('second_component')) ? $request->input('second_component') : '';
        $coursesAdultsPageContent->bottom_description = !empty($request->input('bottom_description')) ? $request->input('bottom_description') : '';


        $file = $request->file('file');
        if ($file) {
            if (!empty($coursesAdultsPageContent->main_img)) {
                Storage::delete("uploads/pages/courses_adults/".$coursesAdultsPageContent->main_img);
            }

            $newfilename = Auth::user()->id."-".Str::random(16).".".$file->getClientOriginalExtension();
            $file->storeAs("uploads/pages/courses_adults", $newfilename);
            $coursesAdultsPageContent->main_img = $newfilename;
            Image::load("uploads/pages/courses_adults/".$newfilename)
                ->height(560, 840)
                ->save();
        }
        $coursesAdultsPageContent->save();
        Session::flash('message', "Pagrindinis puslapis sėkmingai atnaujintas");
        return Redirect::route('pages.index');
    }
}

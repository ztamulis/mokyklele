<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\SettingsModels\FreeLessonPageContent;
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

class FreeLessonPageController extends Controller {
    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit() {
        if(Auth::user()->role != "admin"){
            return view("dashboard.error")->with("error", "Neturite teisių pasiekti šį puslapį.");
        }
        return view("dashboard.free_lesson.edit")->with("freeLessonPageContent", app(FreeLessonPageContent::class)->getPageContent());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param FreeLessonPageContent $freeLessonPageContent
     * @return RedirectResponse
     * @throws InvalidManipulation
     */
    public function update(Request $request, FreeLessonPageContent $freeLessonPageContent) {

        $freeLessonPageContent->main_title = !empty($request->input('main_title')) ? $request->input('main_title') : '';
        $freeLessonPageContent->main_description = !empty($request->input('main_description')) ? $request->input('main_description') : '';
        $freeLessonPageContent->main_component = !empty($request->input('main_component')) ? $request->input('main_component') : '';
        $freeLessonPageContent->lower_description = !empty($request->input('lower_description')) ? $request->input('lower_description') : '';


        $file = $request->file('file');
        if($file) {
            if (!empty($freeLessonPageContent->main_img)) {
                Storage::delete("uploads/pages/courses_adults/".$freeLessonPageContent->main_img);
            }

            $newfilename = Auth::user()->id . "-" . Str::random(16) . "." . $file->getClientOriginalExtension();
            $file->storeAs("uploads/pages/free_lesson", $newfilename);
            $freeLessonPageContent->main_img = $newfilename;
            Image::load("uploads/pages/free_lesson/".$newfilename)
                ->height(560, 840)
                ->save();
        }
        $freeLessonPageContent->save();
        Session::flash('message', "Nemokamos pamokos puslapis sėkmingai atnaujintas");
        return Redirect::route('pages.index');
    }
}

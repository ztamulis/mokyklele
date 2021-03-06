<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\SettingsModels\LithuanianLanguagePageContent;
use App\Models\Suggestion;
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

class LithuanianCoursesController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        if (Auth::user()->role != "admin") {
            return view("dashboard.error")->with("error", "Neturite teisių pasiekti šį puslapį.");
        }

        return view("dashboard.cms-pages.lithuanian_language.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create() {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @return void
     */
    public function store() {

    }

    /**
     * Display the specified resource.
     *
     * @param  Suggestion  $suggestion
     * @return Response
     */
    public function show(Suggestion $suggestion) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  LithuanianLanguagePageContent  $lithuanianLanguagePageContent
     * @return Response
     */
    public function edit(LithuanianLanguagePageContent $lithuanianLanguagePageContent) {
        if (Auth::user()->role != "admin") {
            return view("dashboard.error")->with("error", "Neturite teisių pasiekti šį puslapį.");
        }
        return view('dashboard.cms-pages.lithuanian_language.edit')->with("lithuanianLanguagePageContent",
            $lithuanianLanguagePageContent);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @return RedirectResponse
     * @throws InvalidManipulation
     */
    public function update(Request $request) {
        $lithuanianLanguagePageContent = new LithuanianLanguagePageContent();
        $lithuanianLanguagePageContent->site_name = !empty($request->all()['site_name']) ? $request->all()['site_name'] : '';
        $lithuanianLanguagePageContent->description = !empty($request->all()['description']) ? $request->all()['description'] : '';

        $file = $request->file('file');
        if ($file) {
            if (!empty($lithuanianLanguagePageContent->img)) {
                Storage::delete("uploads/pages/languagecourses/".$lithuanianLanguagePageContent->img);
            }

            $newfilename = Auth::user()->id."-".Str::random(16).".".$file->getClientOriginalExtension();
            $file->storeAs("uploads/pages/languagecourses", $newfilename);
            $lithuanianLanguagePageContent->img = $newfilename;
            Image::load("uploads/pages/languagecourses/".$newfilename)
                ->height(560, 840)
                ->save();
        }
        $lithuanianLanguagePageContent->first_box_title = !empty($request->all()['first_box_title']) ? $request->all()['first_box_title'] : '';
        $lithuanianLanguagePageContent->first_box_array = $request->all()['first_box_array'];
        $lithuanianLanguagePageContent->second_box_title = !empty($request->all()['second_box_title']) ? $request->all()['second_box_title'] : '';
        $lithuanianLanguagePageContent->second_box_description = !empty($request->all()['second_box_description']) ? $request->all()['second_box_description'] : '';
        $lithuanianLanguagePageContent->second_box_name = !empty($request->all()['second_box_name']) ? $request->all()['second_box_name'] : '';
        $lithuanianLanguagePageContent->second_box_content = $request->all()['second_box_content'];
        $lithuanianLanguagePageContent->third_box_name = !empty($request->all()['third_box_name']) ? $request->all()['third_box_name'] : '';
        $lithuanianLanguagePageContent->third_box_title = !empty($request->all()['third_box_title']) ? $request->all()['third_box_title'] : '';
        $lithuanianLanguagePageContent->third_box_content = $request->all()['third_box_content'];
        $lithuanianLanguagePageContent->main_component_questions = !empty($request->all()['main_component_questions']) ? $request->all()['main_component_questions'] : '';
        $lithuanianLanguagePageContent->main_component_courses = !empty($request->all()['main_component_courses']) ? $request->all()['main_component_courses'] : '';
        $lithuanianLanguagePageContent->save();
        Session::flash('message', "Lietuvių kalbos puslapis sėkmingai readaguotas");
        return Redirect::route('pages.index');
    }
}

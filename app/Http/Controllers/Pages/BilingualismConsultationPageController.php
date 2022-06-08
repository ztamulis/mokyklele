<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\SettingsModels\BilingualismConsultationPageContent;
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

class BilingualismConsultationPageController extends Controller {
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
     * @param  BilingualismConsultationPageContent  $bilingualismConsultationPageContent
     * @return Response
     */
    public function edit(BilingualismConsultationPageContent $bilingualismConsultationPageContent) {
        if (Auth::user()->role != "admin") {
            return view("dashboard.error")->with("error", "Neturite teisių pasiekti šį puslapį.");
        }
        return view('dashboard.cms-pages.bilingualism_consultation.edit')->with("bilingualismConsultationPageContent",
            $bilingualismConsultationPageContent);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @return RedirectResponse
     * @throws InvalidManipulation
     */
    public function update(Request $request) {
        $bilingualismConsultationPageContent = new BilingualismConsultationPageContent();
        $bilingualismConsultationPageContent->site_name = !empty($request->all()['site_name']) ? $request->all()['site_name'] : '';
        $bilingualismConsultationPageContent->description = !empty($request->all()['description']) ? $request->all()['description'] : '';
        $file = $request->file('file');
        if ($file) {
            if (!empty($bilingualismConsultationPageContent->img)) {
                Storage::delete("uploads/pages/bilingualismconsultation/".$bilingualismConsultationPageContent->img);
            }

            $newfilename = Auth::user()->id."-".Str::random(16).".".$file->getClientOriginalExtension();
            $file->storeAs("uploads/pages/bilingualismconsultation", $newfilename);
            $bilingualismConsultationPageContent->img = $newfilename;
            Image::load("uploads/pages/bilingualismconsultation/".$newfilename)
                ->height(560, 840)
                ->save();
        }
        $bilingualismConsultationPageContent->first_box_title = !empty($request->all()['first_box_title']) ? $request->all()['first_box_title'] : '';
        $bilingualismConsultationPageContent->first_box_array = $request->all()['first_box_array'];
        $bilingualismConsultationPageContent->third_box_name = !empty($request->all()['third_box_name']) ? $request->all()['third_box_name'] : '';
        $bilingualismConsultationPageContent->third_box_title = !empty($request->all()['third_box_title']) ? $request->all()['third_box_title'] : '';
        $bilingualismConsultationPageContent->third_box_content = $request->all()['third_box_content'];
        $bilingualismConsultationPageContent->main_component_courses = !empty($request->all()['main_component_courses']) ? $request->all()['main_component_courses'] : '';
        $bilingualismConsultationPageContent->save();
        Session::flash('message', "Dvikalbystės konsultacijų puslapis sėkmingai readaguotas");
        return Redirect::route('pages.index');
    }
}

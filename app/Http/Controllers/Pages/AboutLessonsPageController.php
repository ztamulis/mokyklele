<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\SettingsModels\AboutLessonPageContent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class AboutLessonsPageController extends Controller {
    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit() {
        if (Auth::user()->role != "admin") {
            return view("dashboard.error")->with("error", "Neturite teisių pasiekti šį puslapį.");
        }

        return view("dashboard.cms-pages.about-lessons.edit")->with("aboutUsPageContent",
            app(AboutLessonPageContent::class)->getPageContent());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  AboutLessonPageContent  $aboutUsPageContent
     * @return RedirectResponse
     */
    public function update(Request $request, AboutLessonPageContent $aboutUsPageContent) {

        $aboutUsPageContent->main_title = !empty($request->input('main_title')) ? $request->input('main_title') : '';
        $aboutUsPageContent->main_description = !empty($request->input('main_description')) ? $request->input('main_description') : '';
        $aboutUsPageContent->first_block_title = !empty($request->input('first_block_title')) ? $request->input('first_block_title') : '';
        $aboutUsPageContent->first_block_first_description = !empty($request->input('first_block_first_description')) ? $request->input('first_block_first_description') : '';
        $aboutUsPageContent->first_block_second_description = !empty($request->input('first_block_second_description')) ? $request->input('first_block_second_description') : '';
        $aboutUsPageContent->first_block_third_description = !empty($request->input('first_block_third_description')) ? $request->input('first_block_third_description') : '';
        $aboutUsPageContent->first_block_fourth_description = !empty($request->input('first_block_fourth_description')) ? $request->input('first_block_fourth_description') : '';
        $aboutUsPageContent->first_block_first_url = !empty($request->input('first_block_first_url')) ? $request->input('first_block_first_url') : '';
        $aboutUsPageContent->first_block_second_url = !empty($request->input('first_block_second_url')) ? $request->input('first_block_second_url') : '';
        $aboutUsPageContent->first_block_third_url = !empty($request->input('first_block_third_url')) ? $request->input('first_block_third_url') : '';
        $aboutUsPageContent->first_block_fourth_url = !empty($request->input('first_block_fourth_url')) ? $request->input('first_block_fourth_url') : '';
        $aboutUsPageContent->video_url = !empty($request->input('video_url')) ? $request->input('video_url') : '';
        $aboutUsPageContent->second_block_title = !empty($request->input('second_block_title')) ? $request->input('second_block_title') : '';
        $aboutUsPageContent->second_block_first_left = !empty($request->input('second_block_first_left')) ? $request->input('second_block_first_left') : '';
        $aboutUsPageContent->second_block_first_right = !empty($request->input('second_block_first_right')) ? $request->input('second_block_first_right') : '';
        $aboutUsPageContent->second_block_second_left = !empty($request->input('second_block_second_left')) ? $request->input('second_block_second_left') : '';
        $aboutUsPageContent->second_block_second_right = !empty($request->input('second_block_second_right')) ? $request->input('second_block_second_right') : '';
        $aboutUsPageContent->second_block_third_left = !empty($request->input('second_block_third_left')) ? $request->input('second_block_third_left') : '';
        $aboutUsPageContent->second_block_third_right = !empty($request->input('second_block_third_right')) ? $request->input('second_block_third_right') : '';


        $aboutUsPageContent->save();
        Session::flash('message', "Apie pamokamas puslapis sėkmingai atnaujintas");
        return Redirect::route('pages.index');
    }
}

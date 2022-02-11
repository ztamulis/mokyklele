<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\SettingsModels\HomePageContent;
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

class HomePageController extends Controller {
    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit() {
        if(Auth::user()->role != "admin"){
            return view("dashboard.error")->with("error", "Neturite teisių pasiekti šį puslapį.");
        }
        return view("dashboard.home.edit")->with("homePageContent", app(HomePageContent::class)->getPageContent());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param HomePageContent $homePageContent
     * @return RedirectResponse
     * @throws InvalidManipulation
     */
    public function update(Request $request, HomePageContent $homePageContent) {

        $homePageContent->main_title = !empty($request->input('main_title')) ? $request->input('main_title') : '';
        $homePageContent->main_description = !empty($request->input('main_description')) ? $request->input('main_description') : '';
        $homePageContent->main_button_text = !empty($request->input('main_button_text')) ? $request->input('main_button_text') : '';
        $homePageContent->main_button_url = !empty($request->input('main_button_url')) ? $request->input('main_button_url') : '';
        $homePageContent->first_block_title = !empty($request->input('first_block_title')) ? $request->input('first_block_title') : '';
        $homePageContent->first_block_description = !empty($request->input('first_block_description')) ? $request->input('first_block_description') : '';
        $homePageContent->first_block_button_text = !empty($request->input('first_block_button_text')) ? $request->input('first_block_button_text') : '';
        $homePageContent->first_block_button_url = !empty($request->input('first_block_button_url')) ? $request->input('first_block_button_url') : '';
        $homePageContent->second_block_title = !empty($request->input('second_block_title')) ? $request->input('second_block_title') : '';
        $homePageContent->second_block_description = !empty($request->input('second_block_description')) ? $request->input('second_block_description') : '';
        $homePageContent->second_block_button_text = !empty($request->input('second_block_button_text')) ? $request->input('second_block_button_text') : '';
        $homePageContent->second_block_button_url = !empty($request->input('second_block_button_url')) ? $request->input('second_block_button_url') : '';
        $homePageContent->third_block_title = !empty($request->input('third_block_title')) ? $request->input('third_block_title') : '';
        $homePageContent->third_block_description = !empty($request->input('third_block_description')) ? $request->input('third_block_description') : '';
        $homePageContent->third_block_button_text = !empty($request->input('third_block_button_text')) ? $request->input('third_block_button_text') : '';
        $homePageContent->third_block_button_url = !empty($request->input('third_block_button_url')) ? $request->input('third_block_button_url') : '';

        $file = $request->file('main_img');
        if($file) {
            if (!empty($homePageContent->main_img)) {
                Storage::delete("uploads/pages/home/".$homePageContent->main_img);
            }

            $newfilename = Auth::user()->id . "-" . Str::random(16) . "." . $file->getClientOriginalExtension();
            $file->storeAs("uploads/pages/home", $newfilename);
            $homePageContent->main_img = $newfilename;
            Image::load("uploads/pages/home/".$newfilename)
                ->height(560, 840)
                ->save();
        }
        $homePageContent->save();
        Session::flash('message', "Pagrindinis puslapis sėkmingai atnaujintas");
        return Redirect::route('pages.index');
    }
}

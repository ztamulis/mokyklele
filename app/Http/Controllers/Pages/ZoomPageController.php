<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\SettingsModels\ZoomPageContent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class ZoomPageController extends Controller {
    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit() {
        if(Auth::user()->role != "admin"){
            return view("dashboard.error")->with("error", "Neturite teisių pasiekti šį puslapį.");
        }

        return view("dashboard.zoom.edit")->with("zoomPageContent", app(ZoomPageContent::class)->getPageContent());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param ZoomPageContent $contactsPageContent
     * @return RedirectResponse
     */
    public function update(Request $request, ZoomPageContent $contactsPageContent) {

        $contactsPageContent->main_title = !empty($request->input('main_title')) ? $request->input('main_title') : '';
        $contactsPageContent->first_block_left = !empty($request->input('first_block_left')) ? $request->input('first_block_left') : '';
        $contactsPageContent->first_block_right = !empty($request->input('first_block_right')) ? $request->input('first_block_right') : '';
        $contactsPageContent->second_block_right = !empty($request->input('second_block_right')) ? $request->input('second_block_right') : '';
        $contactsPageContent->second_block_left = !empty($request->input('second_block_left')) ? $request->input('second_block_left') : '';
        $contactsPageContent->video_url = !empty($request->input('video_url')) ? $request->input('video_url') : '';

        

        $contactsPageContent->save();
        Session::flash('message', "Kontaktų puslapis sėkmingai atnaujintas");
        return Redirect::route('pages.index');
    }
}

<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\SettingsModels\SuggestionPageContent;
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

class SuggestionsPageController extends Controller {
    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit() {
        if(Auth::user()->role != "admin"){
            return view("dashboard.error")->with("error", "Neturite teisių pasiekti šį puslapį.");
        }
        return view("dashboard.suggestions.edit")->with("pageContent", app(SuggestionPageContent::class)->getPageContent());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param SuggestionPageContent $suggestionPageContent
     * @return RedirectResponse
     * @throws InvalidManipulation
     */
    public function update(Request $request, SuggestionPageContent $suggestionPageContent) {
        $suggestionPageContent->site_name = $request->input('name');
        $suggestionPageContent->description = $request->input('description');
        $file = $request->file('file');
        if($file) {
            if (!empty($suggestionPageContent->img)) {
                Storage::delete("uploads/pages/suggestions/".$suggestionPageContent->img);
            }

            $newfilename = Auth::user()->id . "-" . Str::random(16) . "." . $file->getClientOriginalExtension();
            $file->storeAs("uploads/pages/suggestions", $newfilename);
            $suggestionPageContent->img = $newfilename;
            Image::load("uploads/pages/suggestions/".$newfilename)
                ->height(560, 840)
                ->save();
        }
        $suggestionPageContent->save();
        Session::flash('message', "Patarimų puslapis sėkmingai atnaujintas");
        return Redirect::route('pages.suggestions-config.list.index');
    }
}

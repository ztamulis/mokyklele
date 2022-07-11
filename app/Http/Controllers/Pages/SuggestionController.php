<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSuggestionRequest;
use App\Http\Requests\UpdateSuggestionRequest;
use App\Models\SettingsModels\SuggestionPageContent;
use App\Models\Suggestion;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class SuggestionController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @param  SuggestionPageContent  $suggestionPageContent
     * @return Response
     */
    public function index(SuggestionPageContent $suggestionPageContent) {
        if (Auth::user()->role != "admin") {
            return view("dashboard.error")->with("error", "Neturite teisių pasiekti šį puslapį.");
        }
        $suggestions = Suggestion::orderBy("created_at", "desc")->get();

        return view("suggestions.index")->with("suggestions", $suggestions)->with("suggestionPageContent",
            $suggestionPageContent);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        if (Auth::user()->role != "admin") {
            return view("dashboard.error")->with("error", "Neturite teisių pasiekti šį puslapį.");
        }
        return view('suggestions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreSuggestionRequest  $storeSuggestionRequest
     * @return RedirectResponse
     */
    public function store(StoreSuggestionRequest $storeSuggestionRequest) {
        $suggestion = new Suggestion();
        $suggestion->title = $storeSuggestionRequest->validated()['title'];
        $suggestion->description = $storeSuggestionRequest->validated()['description'];
        $suggestion->save();

        Session::flash('message', "Patarimas sėkmingai sukurtas");
        return Redirect::route('pages.suggestions-config.list.index');
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
     * @param $id
     * @return Response
     */
    public function edit($id) {
        if (Auth::user()->role != "admin") {
            return view("dashboard.error")->with("error", "Neturite teisių pasiekti šį puslapį.");
        }
        $suggestion = Suggestion::findOrFail($id);
        return view('suggestions.edit')->with("suggestion", $suggestion);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateSuggestionRequest  $updateSuggestionRequest
     * @param $id
     * @return RedirectResponse
     */
    public function update(UpdateSuggestionRequest $updateSuggestionRequest, $id) {
        $suggestion = Suggestion::findOrFail($id);
        $suggestion->update($updateSuggestionRequest->validated());
        Session::flash('message', "Patarimas sėkmingai readaguotas");
        return Redirect::route('pages.suggestions-config.list.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return RedirectResponse
     */
    public function destroy($id) {
        Suggestion::findOrFail($id)->delete();

        Session::flash('message', "Patarimas sėkmingai ištrintas");
        return Redirect::route('pages.suggestions-config.list.index');
    }
}

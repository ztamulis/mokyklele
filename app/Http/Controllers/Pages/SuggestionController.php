<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSuggestionRequest;
use App\Http\Requests\UpdateSuggestionRequest;
use App\Models\SettingsModels\SuggestionPageContent;
use App\Models\Suggestion;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class SuggestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param SuggestionPageContent $suggestionPageContent
     * @return Response
     */
    public function index(SuggestionPageContent $suggestionPageContent)
    {
        if(Auth::user()->role != "admin"){
            return view("dashboard.error")->with("error", "Neturite teisių pasiekti šį puslapį.");
        }
        $suggestions = Suggestion::orderBy("updated_at", "ASC")->get();

        return view("suggestions.index")->with("suggestions", $suggestions)->with("suggestionPageContent", $suggestionPageContent);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        if(Auth::user()->role != "admin"){
            return view("dashboard.error")->with("error", "Neturite teisių pasiekti šį puslapį.");
        }
        return view('suggestions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreSuggestionRequest $storeSuggestionRequest
     * @return void
     */
    public function store(StoreSuggestionRequest $storeSuggestionRequest) {
        $suggestion = new Suggestion();
        $suggestion->title = $storeSuggestionRequest->validated()['title'];
        $suggestion->description = $storeSuggestionRequest->validated()['description'];

        Session::flash('message', "Patarimas sėkmingai sukurtas");
        return Redirect::to('dashboard/suggestions');
    }

    /**
     * Display the specified resource.
     *
     * @param Suggestion $suggestion
     * @return Response
     */
    public function show(Suggestion $suggestion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Suggestion $suggestion
     * @return Response
     */
    public function edit(Suggestion $suggestion)
    {
        if(Auth::user()->role != "admin"){
            return view("dashboard.error")->with("error", "Neturite teisių pasiekti šį puslapį.");
        }
        return view('suggestions.edit')->with("suggestion", $suggestion);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateSuggestionRequest $updateSuggestionRequest
     * @param Suggestion $suggestion
     * @return void
     */
    public function update(UpdateSuggestionRequest $updateSuggestionRequest, Suggestion $suggestion)
    {
        $suggestion->update($updateSuggestionRequest->validated());
        Session::flash('message', "Patarimas sėkmingai readaguotas");
        return Redirect::to('dashboard/suggestions');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Suggestion $suggestion
     * @return Response
     */
    public function destroy(Suggestion $suggestion) {
        $suggestion->delete();

        Session::flash('message', "Patarimas sėkmingai ištrintas");
        return Redirect::to('dashboard/suggestions');
    }
}
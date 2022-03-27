<?php

namespace App\Http\Controllers;

use App\Models\QuestionForm;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;


class QuestionFormController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        if(Auth::user()->role != "admin"){
            return view("dashboard.error")->with("error", "Neturite teisių pasiekti šį puslapį.");
        }

        $questions = QuestionForm::latest('created_at')->get();
        return view("dashboard.question-form.index")->with("questions", $questions);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        QuestionForm::create($request->all());
        $modal_title = "Jūs sėkmingai užsiregistravote!";
        $modal_content = "Netrukus susisieksime. Ačiū, kad domitės Pasaka!";

        Session::flash('modal_title', $modal_title);
        Session::flash('modal_content', $modal_content);
        return Redirect::back();
    }

    /**
     * Display the specified resource.
     *
     * @param QuestionForm $questionForm
     * @return void
     */
    public function show(QuestionForm $questionForm)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param QuestionForm $questionForm
     * @return Response
     */
    public function edit(QuestionForm $questionForm)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param QuestionForm $questionForm
     * @return Response
     */
    public function update(Request $request, QuestionForm $questionForm)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param QuestionForm $questionForm
     * @return Response
     */
    public function destroy(QuestionForm $questionForm)
    {
        //
    }
}

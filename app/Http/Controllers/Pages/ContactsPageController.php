<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\SettingsModels\ContactsPageContent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class ContactsPageController extends Controller {
    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit() {
        if (Auth::user()->role != "admin") {
            return view("dashboard.error")->with("error", "Neturite teisių pasiekti šį puslapį.");
        }
        return view("dashboard.cms-pages.contacts.edit")->with("contactsPageContent",
            app(ContactsPageContent::class)->getPageContent());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  ContactsPageContent  $contactsPageContent
     * @return RedirectResponse
     */
    public function update(Request $request, ContactsPageContent $contactsPageContent) {

        $contactsPageContent->first_block_first_content = !empty($request->input('first_block_first_content')) ? $request->input('first_block_first_content') : '';
        $contactsPageContent->first_block_second_content = !empty($request->input('first_block_second_content')) ? $request->input('first_block_second_content') : '';
        $contactsPageContent->second_block_first_content = !empty($request->input('second_block_first_content')) ? $request->input('second_block_first_content') : '';
        $contactsPageContent->second_block_second_content = !empty($request->input('second_block_second_content')) ? $request->input('second_block_second_content') : '';
        $contactsPageContent->second_block_third_content = !empty($request->input('second_block_third_content')) ? $request->input('second_block_third_content') : '';
        $contactsPageContent->end_text = !empty($request->input('end_text')) ? $request->input('end_text') : '';


        $contactsPageContent->save();
        Session::flash('message', "Kontaktų puslapis sėkmingai atnaujintas");
        return Redirect::route('pages.index');
    }
}

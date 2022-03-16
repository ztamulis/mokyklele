<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\SettingsModels\PricePageContent;
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

class PricePageController extends Controller {
    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit() {
        if(Auth::user()->role != "admin"){
            return view("dashboard.error")->with("error", "Neturite teisių pasiekti šį puslapį.");
        }
        return view("dashboard.price.edit")->with("pricePageContent", app(PricePageContent::class)->getPageContent());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param PricePageContent $pricePageContent
     * @return RedirectResponse
     * @throws InvalidManipulation
     */
    public function update(Request $request, PricePageContent $pricePageContent) {

        $pricePageContent->first_block_first_content = !empty($request->input('first_block_first_content')) ? $request->input('first_block_first_content') : '';
        $pricePageContent->first_block_second_content = !empty($request->input('first_block_second_content')) ? $request->input('first_block_second_content') : '';
        $pricePageContent->first_block_third_content = !empty($request->input('first_block_third_content')) ? $request->input('first_block_third_content') : '';
        $pricePageContent->second_block_first_content = !empty($request->input('second_block_first_content')) ? $request->input('second_block_first_content') : '';
        $pricePageContent->second_block_second_content = !empty($request->input('second_block_second_content')) ? $request->input('second_block_second_content') : '';
        $pricePageContent->second_block_third_content = !empty($request->input('second_block_third_content')) ? $request->input('second_block_third_content') : '';
        $pricePageContent->end_text = !empty($request->input('end_text')) ? $request->input('end_text') : '';


        $firstFile = $request->file('first_block_first_img');
        if($firstFile) {
            if (!empty($pricePageContent->main_img)) {
                Storage::delete("uploads/pages/price/".$pricePageContent->first_block_first_img);
            }

            $newfilename = Auth::user()->id . "-" . Str::random(16) . "." . $firstFile->getClientOriginalExtension();
            $firstFile->storeAs("uploads/pages/price", $newfilename);
            $pricePageContent->first_block_first_img = $newfilename;
            Image::load("uploads/pages/price/".$newfilename)
                ->height(250, 250)
                ->save();
        }

        $secondFile = $request->file('first_block_second_img');
        if($secondFile) {
            if (!empty($pricePageContent->first_block_second_img)) {
                Storage::delete("uploads/pages/price/".$pricePageContent->first_block_second_img);
            }

            $newfilename = Auth::user()->id . "-" . Str::random(16) . "." . $secondFile->getClientOriginalExtension();
            $secondFile->storeAs("uploads/pages/price", $newfilename);
            $pricePageContent->first_block_second_img = $newfilename;
            Image::load("uploads/pages/price/".$newfilename)
                ->height(250, 250)
                ->save();
        }

        $thirdFile = $request->file('first_block_third_img');
        if($thirdFile) {
            if (!empty($pricePageContent->first_block_third_img)) {
                Storage::delete("uploads/pages/price/".$pricePageContent->first_block_third_img);
            }

            $newfilename = Auth::user()->id . "-" . Str::random(16) . "." . $thirdFile->getClientOriginalExtension();
            $thirdFile->storeAs("uploads/pages/price", $newfilename);
            $pricePageContent->first_block_third_img = $newfilename;
            Image::load("uploads/pages/price/".$newfilename)
                ->height(250, 250)
                ->save();
        }

        $pricePageContent->save();
        Session::flash('message', "Kainų puslapis sėkmingai atnaujintas");
        return Redirect::route('pages.index');
    }
}

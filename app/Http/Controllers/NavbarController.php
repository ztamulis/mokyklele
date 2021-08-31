<?php

namespace App\Http\Controllers;

use App\Models\Navbar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class NavbarController extends Controller
{
    public function save(Request $request){

        $nav = Navbar::find(1);

        $nav->json = $request->input("json");
        $nav->save();
    }

}
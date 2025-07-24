<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;


class MainController extends Controller
{

    public function dashboard()
    {
        $celebrity = auth('celebrity')->user();


        return view('celebrity.index', compact('celebrity'));
    }
    public function profile()
    {
        $celebrity = auth('celebrity')->user();


        return view('celebrity.profile', compact('celebrity'));
    }



}

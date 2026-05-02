<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DirectoryController extends Controller
{
    public function about()
    {
        return view('main.about');
    }

    public function contact()
    {
        return view('main.contact');
    }
}

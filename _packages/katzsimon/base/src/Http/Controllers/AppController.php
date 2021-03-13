<?php

namespace Katzsimon\Base\Http\Controllers;


use Illuminate\Http\Request;

class AppController extends Controller
{

    public function home(Request $request)
    {

        return view('katzsimon::pages.app.home');

    }



    public function account(Request $request) {

        return view('katzsimon::pages.app.account');

    }

}

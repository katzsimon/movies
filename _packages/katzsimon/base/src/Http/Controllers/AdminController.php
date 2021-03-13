<?php

namespace Katzsimon\Base\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;

class AdminController extends Controller
{

    protected $admin = true;

    public function admin(Request $request) {
        if (Auth::check()) {
            return $this->redirect(['route'=>'admin.dashboard']);
        }
        return $this->redirect(['route'=>'admin.login']);
    }



    public function dashboard(Request $request) {
        if (Auth::check()) {
            return view('katzsimon::pages.admin.dashboard');
        }
        return redirect()->route('admin.login');
    }

}

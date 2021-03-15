<?php

namespace Katzsimon\Base\Http\Controllers;


use Illuminate\Http\Request;


/**
 * Only allow access to the site, after a password check
 * Password is set in the .env file: PROTECT_PASSWORD
 * Class ProtectController
 * @package Katzsimon\Base\Http\Controllers
 */
class ProtectController extends Controller
{

    /**
     * Show the Password Request page
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function protect(Request $request) {
        return view('katzsimon::protect');
    }


    /**
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function protectHandle(Request $request) {


        $name = $request->get('name');
        $password = $request->get('password');

        // Honey pot - name must be empty.
        if (!empty($name)) return redirect()->route('app.protect');


        // Set a session variable if the password check passes
        if ($password===config('settings.protect.password', null)) {
            $url = session()->get('protect-url');
            session()->forget('protect-url');
            session()->put('protected', true);
            return redirect($url);
        }

        return redirect()->route('app.protect');
    }
}

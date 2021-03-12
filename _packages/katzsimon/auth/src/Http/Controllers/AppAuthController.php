<?php

namespace Katzsimon\Auth\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Http\Requests\AppLoginRequest;
use App\Http\Requests\AppRegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AppAuthController extends Controller
{


    public function login(Request $request)
    {
        return view('katzsimon::app.login');
    }


    public function handleLogin(AppLoginRequest $request) {

        if (Auth::attempt($request->validated())) {
            return redirect()->route('account');
        }

        return redirect()->route('login');

    }



    public function register(Request $request)
    {
        return view('katzsimon::app.register');
    }


    public function handleRegister(AppRegisterRequest $request) {


        $user = User::create([
            'name'=>$request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        Auth::login($user);

        return redirect()->route('account');
    }


    public function logout(Request $request) {

        Auth::logout();

        return redirect()->route('home');

    }

}

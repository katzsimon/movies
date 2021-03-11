<?php

namespace Katzsimon\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminLoginRequest;
use App\Http\Requests\AdminRegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AdminAuthController extends Controller
{


    public function register()
    {
        return view('katzsimon::admin.register');
    }



    public function handleRegister(AdminRegisterRequest $request) {

        $user = User::create([
            'name'=>$request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        Auth::login($user);

        return redirect()->route('admin.dashboard');
    }



    public function login(Request $request) {

        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('admin.login');
    }



    public function handleLogin(AdminLoginRequest $request) {

        if (Auth::attempt($request->only(['email', 'password']))) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('admin.login');
    }



    public function logout(Request $request) {


        Auth::logout();

        return redirect()->route('admin.login');

    }

}

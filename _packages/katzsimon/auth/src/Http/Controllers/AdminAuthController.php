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

        $data = [
            'user'=>$user
        ];

        return redirect()->route('admin.dashboard');
    }



    public function login(Request $request, User $item) {

        if (Auth::check()) {
            return $this->redirect(['route'=>'admin.dashboard']);
        }

        return view('katzsimon::admin.login', ['item'=>$item]);
    }



    public function handleLogin(AdminLoginRequest $request, User $item) {

        if (Auth::attempt($request->only(['email', 'password']))) {
            return $this->redirect(['route'=>'admin.dashboard']);
        }

        return redirect()->route('admin.login');
    }



    public function logout(Request $request) {


        Auth::logout();

        return redirect()->route('admin.login');

    }

}

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

    protected $admin = true;

    public function register()
    {
        return $this->output(['view'=>'katzsimon::admin.register']);
    }



    public function handleRegister(AdminRegisterRequest $request) {

        $user = User::create([
            'name'=>$request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        Auth::login($user);

        return $this->redirect(['route'=>'admin.dashboard', 'message'=>'Login Successful']);
    }



    public function login(Request $request, User $item) {



        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        return $this->output(['view'=>'katzsimon::admin.login', 'item'=>$item]);
    }



    public function handleLogin(AdminLoginRequest $request) {

        if (Auth::attempt($request->only(['email', 'password']))) {
            return redirect()->route('admin.dashboard');
        }

        return $this->redirect(['route'=>'admin.login', 'with'=>['message'=>['title'=>'Error!', 'message'=>'Incorrect Login Details', 'context'=>'danger']]]);
    }



    public function logout(Request $request) {


        Auth::logout();

        return $this->redirect(['route'=>'admin.login']);

    }

}

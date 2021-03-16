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

    /**
     * Shows the Admin Registration form
     *
     * @return false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Inertia\Response|string
     */
    public function register()
    {
        return $this->output(['view'=>'katzsimon::admin.register']);
    }


    /**
     * Attempts to Register a User
     *
     * @param AdminRegisterRequest $request
     * @return false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|string
     */
    public function handleRegister(AdminRegisterRequest $request) {

        $user = User::create([
            'name'=>$request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        Auth::login($user);

        return $this->redirect(['route'=>'admin.dashboard', 'message'=>'Login Successful']);
    }


    /**
     * Shows the Admin Login form
     *
     * @param Request $request
     * @param User $item
     * @return false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Inertia\Response|string
     */
    public function login(Request $request, User $item) {



        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        return $this->output(['view'=>'katzsimon::admin.login', 'item'=>$item]);
    }


    /**
     * Attempts to login a User to the Admin CRUD
     *
     * @param AdminLoginRequest $request
     * @return false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|string
     */
    public function handleLogin(AdminLoginRequest $request) {

        if (Auth::attempt($request->only(['email', 'password']))) {
            return redirect()->route('admin.dashboard');
        }

        return $this->redirect(['route'=>'admin.login', 'with'=>['message'=>['title'=>'Error!', 'message'=>'Incorrect Login Details', 'context'=>'danger']]]);
    }


    /**
     * Logs the User out of the Admin CRUD
     *
     * @param Request $request
     * @return false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|string
     */
    public function logout(Request $request) {


        Auth::logout();

        return $this->redirect(['route'=>'admin.login']);

    }

}

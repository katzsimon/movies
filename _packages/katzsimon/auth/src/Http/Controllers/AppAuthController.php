<?php

namespace Katzsimon\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\AppLoginRequest;
use App\Http\Requests\AppRegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AppAuthController extends Controller
{
    //

    /**
     * Show the Login page
     *
     * @param Request $request
     * @return false|\Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Inertia\Response|mixed|string|null
     */
    public function login(Request $request)
    {
        return $this->output(['view'=>'katzsimon::app.login']);
    }

    /**
     * Handle a login attempt from a User
     *
     * @param AppLoginRequest $request
     * @return false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|string
     * @throws ValidationException
     */
    public function handleLogin(AppLoginRequest $request) {

        $user = User::where('id', '>', 0)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        Auth::login($user);

        if (config('settings.api_guard')==='sanctum') {
            $token = $user->createToken(Str::random(10))->plainTextToken;
        } elseif (config('settings.api_guard')==='passport') {
            $token = $user->createToken(Str::random(10))->accessToken;
        }

        $data = [
            'user'=>$user,
            'token'=>$token??''
        ];

        return $this->redirect(['route'=>'account', 'data'=>$data]);

    }


    /**
     * Show the Registration page
     *
     * @param Request $request
     * @return false|\Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Inertia\Response|mixed|string|null
     */
    public function register(Request $request)
    {
        return $this->output(['view'=>'katzsimon::app.register']);
    }



    /**
     * Handle the Registration of a new User
     *
     * @param AppRegisterRequest $request
     * @return false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|string
     */
    public function handleRegister(AppRegisterRequest $request) {


        $user = User::create([
            'name'=>$request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        Auth::login($user);

        $token = '';
        if (config('settings.api_guard')==='sanctum') {
            $token = $user->createToken(Str::random(10))->plainTextToken;
        } elseif (config('settings.api_guard')==='passport') {
            $token = $user->createToken(Str::random(10))->accessToken;
        }

        $data = [
            'user'=>$user,
            'token'=>$token??''
        ];

        return $this->redirect(['route'=>'account', 'message'=>'Login Successful', 'data'=>$data]);
    }

    /**
     * Logout the User from the app & delete access tokens if they exist
     *
     * @param Request $request
     * @return false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|string
     */
    public function logout(Request $request) {

        $user = $request->user();

        if (!empty($user)) {
            $user->tokens()->delete();
        }

        Auth::logout();

        return $this->redirect(['route'=>'home']);

    }


}

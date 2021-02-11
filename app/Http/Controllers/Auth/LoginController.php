<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function getToken(Request $request)
    {
        //Client Secret PC
        //$clientSecret = "w96Ge6Z88SeBKdu8dOuP73v3qT1iXEWuhQeyKxWl";
        //Client Secret Laptop
        //$clientSecret = "KuELHUiunuZixN7C4BpbZc9CHcxieExs84GfIw8z";
        //ClientSecret Prod
        $clientSecret = "r5AIHaFQXA8v6VwRhzRlvHgSJ3kazR8AVGq0nMVS";
        $request->request->add([
            "grant_type" => "password",
            "client_id" => 2,
            "client_secret" => $clientSecret,
            "username" => $request->username,
            "password" => $request->password
        ]);

        $requestToken = Request::create(env("APP_URL") . "/oauth/token", 'post');
        $response = Route::dispatch($requestToken);

        return $response;
    }
}

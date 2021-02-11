<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class LoginController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);
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

    public function destroy(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->noContent();
    }
}

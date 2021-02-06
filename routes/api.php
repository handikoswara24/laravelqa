<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/token', [LoginController::class, 'getToken']);
Route::get('/questions', "App\Http\Controllers\Api\QuestionsController@index");
Route::get("/questions/{question}-{slug}", "App\Http\Controllers\Api\QuestionDetailsController");
Route::middleware(['auth:api'])->group(function () {
    Route::apiResource('/questions', 'App\Http\Controllers\Api\QuestionsController')->except('index');
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

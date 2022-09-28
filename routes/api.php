<?php

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


Route::post('login', 'App\Http\Controllers\API\UserController@login');
Route::post('register', 'App\Http\Controllers\API\UserController@register');
Route::group(['middleware' => 'auth:api'], function(){
    //Route::post('details', 'App\Http\Controllers\API\UserController@details');
    Route::get('get-user', [App\Http\Controllers\API\UserController::class, 'details']);
    Route::get('industries',[App\Http\Controllers\API\IndustryController::class, 'getAllIndustries']);
});
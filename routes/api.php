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

Route::prefix('/companies')->group( function(){
    Route::get('/all', 'CompanyController@index')->middleware('auth:api');
    Route::get('/show/{company}', 'CompanyController@show')->middleware('auth:api');
    Route::post('/add', 'CompanyController@store')->middleware('auth:api');
    Route::put('/update/{company}', 'CompanyController@update')->middleware('auth:api');
    Route::delete('/delete/{company}', 'CompanyController@delete')->middleware('auth:api');
});

Route::prefix('/subscriptions')->group( function(){
    Route::post('/add/{plan}', 'CreateSubscriptionController@create')->middleware('auth:api');
});

Route::prefix('/user')->group( function(){
    Route::post('/login', 'Auth\LoginController@login');
    Route::post('/register', 'Auth\RegisterController@register');
});
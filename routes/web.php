<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/', function () {  return view('login');});
Route::get('/dashboard', ['uses' => 'DashboardController@index']);
Route::get('/signup', function () { return view('signup');});
Route::post('/login', ['uses' => 'AuthController@login']);
Route::get('/logout', ['uses' => 'AuthController@logout']);
Route::post('/signup', ['uses' => 'SignupController@signup']);
Route::get('/test', ['uses' => 'TestController@index']);

//Usuarios
Route::get('/usuarios', ['uses' => 'UserController@index']);

//menus
Route::get('/menus', ['uses' => 'MenuController@index']);
Route::get('/menus/nuevo', ['uses' => 'MenuController@new']);
Route::post('/menus/save', ['uses' => 'MenuController@save']);

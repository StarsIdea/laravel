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

Route::get('/', function () {
    session('redirectTo', 'home');
    return view('home');
});

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('dashboard', 'UserController@dashboard')->name('dashboard');
});

Route::post('login', 'LoginController@authenticate')->name('login');
Route::get('about', 'HomeController@about')->name('about');
Route::get('playing', 'HomeController@playing')->name('playing');

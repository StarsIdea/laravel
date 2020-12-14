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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/auth/login', 'AuthController@login');
Route::post('/auth/register', 'AuthController@register');
Route::post('/auth/refresh', 'AuthController@refresh');

Route::group([
        'middleware' => 'jwt.verify',
        'prefix' => 'auth'
    ],
    function ($router) {
        // Route::post('/login', 'AuthController@login');
        // Route::post('/register', 'AuthController@register');
        Route::post('/logout', 'AuthController@logout');
        // Route::post('/refresh', 'AuthController@refresh');
        Route::get('/user-profile', 'AuthController@userProfile');
    }
);

Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('/app/rstream', 'RStreamController@getData');
});

// Route::post('register', 'AuthController@register');
// Route::post('login', 'AuthController@authenticate');
// Route::get('open', 'DataController@open');

// Route::group(['middleware' => ['jwt.verify']], function() {
//     Route::get('user', 'AuthController@getAuthenticatedUser');
//     Route::get('closed', 'DataController@closed');
// });

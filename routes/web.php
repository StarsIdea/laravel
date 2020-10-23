<?php

use Illuminate\Support\Facades\Route;
use Aws\S3\PostObjectV4;
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
Auth::routes();

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
Route::get('terms', 'HomeController@terms')->name('terms');
// Route::get('audition', 'AuditionController@index')->name('audition');

// Route::post('/audition', function() {
//     $file = request()->file;
//     $filename = uniqid(time()."-") . "." . $file->extension();
//     // $path = $file->store('public', $filename);
//     $path = $file->storePubliclyAs('private', $filename);
//     return redirect("/show?path=$path");
// });

Route::get('show', function() {

    $path = request()->query('path');
    // $path = request()->query('key');
    $url = "/file?path=$path";
    // $url = Storage::temporaryUrl($path, '+10 minutes');
    // $url = \Storage::url($path);

    return view('show', compact('url'));
    
});

Route::get('audition', function() {
    $adapter = Storage::getAdapter();
    $client = $adapter->getClient();
    $bucket = $adapter->getBucket();
    $prefix = 'uploads/';
    $acl = 'private';
    $expires = '+10 minutes';
    $redirectUrl = url('/show');
    $formInputs = [
        'acl' => $acl,
        'key' => $prefix . '${filename}',
        'success_action_redirect' => $redirectUrl,
    ];
    $options = [
        ['acl' => $acl],
        ['bucket' => $bucket],
        ['starts-with', '$key', $prefix],
        ['eq', '$success_action_redirect', $redirectUrl],
    ];
    $postObject = new PostObjectV4($client, $bucket, $formInputs, $options, $expires);
    $attributes = $postObject->getFormAttributes();
    $inputs = $postObject->getFormInputs();
    return view('audition', compact(['attributes', 'inputs']));
});

Route::get('file', function() {
    // $path = request()->query('path');
    // $full_path = storage_path('app') . "/$path";

    // return response()->file($full_path);
    $path = request()->query('path');

    $fs = Storage::getDriver();
    $stream = $fs->readStream($path);

    $headers = [
        'Content-Type' => $fs->getMimetype($path),
        'Content-Length' => $fs->getSize($path),
    ];

    return response()->stream(function() use ($stream) {
        fpassthru($stream);
    }, 200, $headers);
});

Route::post('subscribe', 'UserController@subscribe')->name('subscribe');

Route::get('/images', 'VideoController@getImages')->name('videos');
Route::post('/audition/upload', 'VideoController@postUpload')->name('uploadfile');
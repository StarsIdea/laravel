<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
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
// Auth::routes(['verify' => true]);
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware(['auth'])->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('status', 'verification-link-sent');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('/', function () {
    session('redirectTo', 'home');
    return view('home');
});

// Route::get('profile', function(){

// })->middleware('verified');

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('dashboard', 'UserController@dashboard')->name('dashboard')->middleware('verified');
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
    $redirectUrl = url('/success?mode=upload');
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
})->name('audition');

// Route::get('file', function() {
//     // $path = request()->query('path');
//     // $full_path = storage_path('app') . "/$path";

//     // return response()->file($full_path);
//     $path = request()->query('path');

//     $fs = Storage::getDriver();
//     $stream = $fs->readStream($path);

//     $headers = [
//         'Content-Type' => $fs->getMimetype($path),
//         'Content-Length' => $fs->getSize($path),
//     ];

//     return response()->stream(function() use ($stream) {
//         fpassthru($stream);
//     }, 200, $headers);
// });

Route::post('subscribe', 'UserController@subscribe')->name('subscribe');

Route::get('/images', 'VideoController@getImages')->name('videos');
Route::post('/audition/upload', 'VideoController@postUpload')->name('uploadfile');
Route::get('success',function(Request $request){
    $mode = $request->input('mode');
    return view('success',compact('mode'));
});
Route::get('/userType',function(){
    return view('/auth/userType');
})->name('userType');

Route::get('/dashboard','HomeController@dashboard')->name('dashboard');
Route::get('/download/{id}','HomeController@download');
// Route::get('/admin/performer',function(){
//     return view('admin.performer-list');
// });
Route::get('/admin/audition','HomeController@auditionList');
Route::get('/admin/performer','HomeController@performerList');
Route::get('/admin/venue','HomeController@venueList');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/verify','Auth\RegisterController@verifyUser')->name('verify.user');
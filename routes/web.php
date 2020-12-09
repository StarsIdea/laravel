<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Aws\S3\PostObjectV4;
use App\Http\Controllers\AuthController;
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

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('dashboard', 'UserController@dashboard')->name('dashboard')->middleware('verified');
});

Route::post('login', 'LoginController@authenticate')->name('login');
// Route::get('about', 'HomeController@about')->name('about');
// Route::get('playing', 'HomeController@playing')->name('playing');
Route::get('about', function(){
    return view('about');
})->name('about');

Route::get('playing', function(){
    return view('playing');
})->name('playing');

Route::get('faq', function () {
    return view('faq');
})->name('faq');

Route::get('support', 'HomeController@support')->name('support');
Route::get('terms', 'HomeController@terms')->name('terms');

Route::get('show', function() {

    $path = request()->query('path');
    $url = "/file?path=$path";
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

Route::get('/dashboard','HomeController@dashboard')->name('dashboard')->middleware('auth');
Route::get('/download/{id}','HomeController@download');
Route::get('/check_verification_code', 'AuditionController@check_verification_code');

Route::group([
        'middleware' => 'auth',
        'prefix' => 'admin'
    ],
    function ($router) {
        Route::get('/audition','AuditionController@auditionList');
        Route::get('/performer','HomeController@performerList')->name('performerList');
        Route::get('/venue','HomeController@venueList')->name('venueList');
        Route::get('/audition/approve/{id}', 'AuditionController@auditionApprove');
        Route::get('/stream_key_code', 'UserController@streamKeyCode');
        Route::post('/update_stream_key_code', 'UserController@updateStreamKeyCode');
        Route::get('/eventList/{eventType}', 'UserController@eventList');
        Route::get('/addEvent', 'UserController@addEventForm');
        Route::get('/editEvent/{id}', 'UserController@editEventForm');
        Route::post('/addEvent', 'UserController@addEvent');
        Route::post('/editEvent/{id}', 'UserController@editEvent');
        Route::get('/userProfile', 'UserController@profile')->name('current_user_profile');
        Route::get('/userPublicPage', 'UserController@userPublicPage')->name('user-public-page');
        Route::post('/updateProfile', 'UserController@updateProfile')->name('updateProfile');
        Route::post('/updatePassword', 'UserController@updatePassword')->name('updatePassword');
        Route::get('/allow/{userType}/{id}','AdminController@allowed');
    }
);

Route::get('/getEventStream', 'StreamEvent@getEventStream');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/verify','Auth\RegisterController@verifyUser')->name('verify.user');

Route::get('/test', 'AuthController@auth_test');

Route::get('forget-password','Auth\ForgotPasswordController@getEmail')->name('forget-password');
Route::post('forget-password', 'Auth\ForgotPasswordController@postEmail')->name('forget-password');

Route::get('reset-password/{token}', 'Auth\ResetPasswordController@getPassword');
Route::post('reset-password', 'Auth\ResetPasswordController@updatePassword')->name('reset-password');



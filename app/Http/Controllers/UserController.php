<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\StreamEvent;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Aws\S3\PostObjectV4;
use Illuminate\Support\Facades\Hash;

use App\Models\Subscribe;

class UserController extends Controller
{
    public function dashboard() {
        return view('dashboard');
    }

    public function streamKeyCode(){
        $streamKeyCode = Auth::user()->stream_key;
        // echo $streamKeyCode;
        return view('profile.stream-key-code',compact('streamKeyCode'));
    }

    public function updateStreamKeyCode(Request $request){
        $user = Auth::user();
        $user->stream_key = $request->input('streamkeycode');
        $user->save();

        $streamKeyCode = Auth::user()->stream_key;
        return view('profile.stream-key-code',compact('streamKeyCode'));
    }

    public function eventList($eventType){
        if($eventType == "upcoming"){
            $eventList = StreamEvent::where('actual_end','=',null)->where('userkey', '=', Auth::user()->id)->get();
        }
        else if($eventType == "prev"){
            $eventList = StreamEvent::where('actual_end','!=',null)->where('userkey', '=', Auth::user()->id)->get();
        }

        return view('profile.event-list', compact('eventList','eventType'));
    }

    public function addEventForm(){
        $action = "add";
        return view('profile.event', compact('action'));
    }

    public function editEventForm($id){
        $action = "edit";
        $event = StreamEvent::where('id', '=', $id)->first();
        return view('profile.event', compact('action', 'event'));
    }

    public function addEvent(Request $request){
        StreamEvent::create([
            'userkey' => Auth::user()->id,
            'start_time' => Carbon::now(),
            'localtz' => '',
            'description' => $request->input('description'),
            'actual_start' => null,
            'actual_end' => null,
            'playlist' => '',
            'imgcap' => ''
        ]);
        // // return view('profile.event', compact('action'));
        return Redirect::to("/admin/eventList/upcoming");
        // echo Auth::user();
        // echo '<br />';
        // echo Auth::user()->id;
    }

    public function editEvent($id, Request $request){
        // print_r($request->all());
        $event = StreamEvent::where('id', '=', $id)->first();
        $event->description = $request->input('description');
        $event->save();
        // return view('profile.event', compact('action'));
        return Redirect::to("/admin/eventList/upcoming");
    }

    public function profile(){
        $adapter = Storage::getAdapter();
        $client = $adapter->getClient();
        $bucket = $adapter->getBucket();
        $prefix = 'avatars/';
        $acl = 'private';
        $expires = '+10 minutes';
        $redirectUrl = url('/admin/userProfile');
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
        $userType = Auth::user()->userType;
        return view('profile.user-profile', compact(['attributes', 'inputs', 'userType']));
    }

    public function userPublicPage(){
        $eventList = StreamEvent::where('actual_end','=',null)->where('userkey', '=', Auth::user()->id)->get();
        $oldEventList = StreamEvent::where('actual_end','!=',null)->where('userkey', '=', Auth::user()->id)->get();
        return view('profile.user-public-page', compact('eventList', 'oldEventList'));
    }

    public function updateProfile(Request $request){
        $user = Auth::user();
        $userType = $request->input('userType');
        if($userType == "talent"){

            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                // 'email' => ['required', 'string', 'email', 'max:255'],
                // 'password' => ['required', 'string', 'min:8', 'confirmed'],
                'city' => ['required', 'string', 'max:255'],
                'state' => ['required', 'string', 'max:255'],
                'zip' => ['required', 'string', 'max:255'],
                'telephone' => ['required', 'string', 'max:255'],
                'band' => ['required', 'string', 'max:255'],
                'genre' => ['required', 'string', 'max:255'],
                'location' => ['required', 'string', 'max:255']
            ]);
            $request->merge([
                'allowed' => false
            ]);
        }
        else if($userType == "venue"){
            $validator = Validator::make($request->all(), [
                'contactName' => ['required', 'string', 'max:255'],
                // 'email' => ['required', 'string', 'email', 'max:255'],
                // 'password' => ['required', 'string', 'min:8', 'confirmed'],
                'city' => ['required', 'string', 'max:255'],
                'state' => ['required', 'string', 'max:255'],
                'zip' => ['required', 'string', 'max:255'],
                'telephone' => ['required', 'string', 'max:255'],
                'venueName' => ['required', 'string', 'max:255'],
                'genre' => ['required', 'string', 'max:255'],
                'location' => ['required', 'string', 'max:255'],
            ]);
            $request->merge([
                'paypal' => '',
                'venmo' => '',
                'cashapp' => '',
                'allowed' => false
            ]);
        }
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 200);
        }

        if($request->input('photo') != ''){
            $user->photo  = '/avatar/'.$request->input('photo');
        }
        if($userType == "talent"){
            $user->name = $request->input('name');
            $user->band = $request->input('band');
        }
        else if($userType == "venue"){
            $user->name = $request->input('contactName');
            $user->band = $request->input('venueName');
        }
        // $user->email = $request('email');
        // $user->password = $request('password');
        $user->city = $request->input('city');
        $user->state = $request->input('state');
        $user->zip = $request->input('zip');
        $user->telephone = $request->input('telephone');
        $user->genre = $request->input('genre');
        $user->location = $request->input('location');
        $user->website = $request->input('website');
        $user->facebook = $request->input('facebook');
        $user->instagram = $request->input('instagram');
        $user->twitter = $request->input('twitter');
        $user->paypal = $request->input('paypal');
        $user->venmo = $request->input('venmo');
        $user->cashapp = $request->input('cashapp');
        $user->allowed = $request->input('allowed');
        $user->userType = $request->input('userType');
        $user->save();

        echo json_encode("success");
    }

    public function updatePassword(Request $request){
        $validator = Validator::make($request->all(), [
                'password' => ['required', 'string', 'min:8', 'confirmed']
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 200);
        }

        $user = Auth::user();
        $user->password = Hash::make($request->input('password'));
        $user->save();
        Auth::logout();

        return redirect('/login');
    }

    public function personalPage($url){
        $user = User::where('public_url', '=', $url)->first();
        $eventList = StreamEvent::where('actual_end','=',null)->where('userkey','=',$user->id)->get();
        return view('profile.publicPersonalPage', compact(['user', 'eventList']));
    }

    public function subscribe(Request $request) {

        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:100|unique:subscribes',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = Subscribe::create($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'The email has been subscribed',
        ], 201);
    }
}

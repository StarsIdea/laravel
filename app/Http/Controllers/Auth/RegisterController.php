<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Video;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Storage;
use Aws\S3\PostObjectV4;

use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\MailController;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'city' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'max:255'],
            'zip' => ['required', 'string', 'max:255'],
            'telephone' => ['required', 'string', 'max:255'],
            'band' => ['required', 'string', 'max:255'],
            'genre' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        // $path = Storage::disk('s3')->put('avatar/originals', $request->file);
        $path  = '/avatar/'.$data['photo'];
        if($data['userType'] == "talent"){
            $name = $data['name'];
            $band = $data['band'];
        }
        else if($data['userType'] == "venue"){
            $name = $data['contactName'];
            $band = $data['venueName'];
        }
        return User::create([
            'name' => $name,
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'verification_code' => sha1(time()),
            'city' => $data['city'],
            'state' => $data['state'],
            'zip' => $data['zip'],
            'telephone' => $data['telephone'],
            'band' => $band,
            'genre' => $data['genre'],
            'location' => $data['location'],
            'photo' => $path,
            'website' => $data['website'],
            'facebook' => $data['facebook'],
            'instagram' => $data['instagram'],
            'twitter' => $data['twitter'],
            'paypal' => $data['paypal'],
            'venmo' => $data['venmo'],
            'cashapp' => $data['cashapp'],
            'allowed' => $data['allowed'],
            'userType' => $data['userType'],
            'stream_key' => $data['stream_key']
        ]);
    }

    public function showRegistrationForm(Request $request)
    {
        $adapter = Storage::getAdapter();
        $client = $adapter->getClient();
        $bucket = $adapter->getBucket();
        $prefix = 'avatars/';
        $acl = 'private';
        $expires = '+10 minutes';
        $redirectUrl = url('/dashboard');
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
        $userType = $request->input('userType');
        return view('auth.register', compact(['attributes', 'inputs', 'userType']));
    }
    public function register(Request $request){
        // $validator = $this->validator($request->all())->validate();
        $userType = $request->input('userType');
        if($userType == "talent"){

            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'city' => ['required', 'string', 'max:255'],
                'state' => ['required', 'string', 'max:255'],
                'zip' => ['required', 'string', 'max:255'],
                'telephone' => ['required', 'string', 'max:255'],
                'band' => ['required', 'string', 'max:255'],
                'genre' => ['required', 'string', 'max:255'],
                'location' => ['required', 'string', 'max:255'],
                'verification_code' => ['required', 'string', 'max:255'],
            ]);
            $request->merge([
                'allowed' => false,
                'stream_key' => bin2hex(openssl_random_pseudo_bytes(10))
            ]);
            $video = Video::where('email', '=', $request->input('email'))->where('verification_code', '=', $request->input('verification_code'))->first();
            if($video == null){
                return response()->json(json_encode('incorrect_verification_code'), 200);
            }
        }
        else if($userType == "venue"){
            $validator = Validator::make($request->all(), [
                'contactName' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
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
                'allowed' => false,
                'verification_code' => '',
                'stream_key' => bin2hex(openssl_random_pseudo_bytes(10))
            ]);
        }
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 200);
        }

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        echo json_encode("success");
    }

    public function verifyUser(Request $request){
        $verification_code = $request->input('code');
        $user = User::where(['verification_code' => $verification_code])->first();
        if($user != null){
            $user->is_verified = 1;
            $user->save();
            return redirect()->route('login')->with(session()->flash('alert-success', 'Your account is verified. Please login!'));
        }
        return redirect()->route('login')->with(session()->flash('alert-danger', 'Invalid verification code!'));
    }

    public function genkey() {
        return bin2hex(openssl_random_pseudo_bytes(10));
    }
}

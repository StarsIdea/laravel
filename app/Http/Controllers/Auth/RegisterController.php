<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Storage;
use Aws\S3\PostObjectV4;

use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'city' => $data['city'],
            'state' => $data['state'],
            'zip' => $data['zip'],
            'telephone' => $data['telephone'],
            'band' => $data['band'],
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
        ]);
    }

    public function showRegistrationForm()
    {
        $adapter = Storage::getAdapter();
        $client = $adapter->getClient();
        $bucket = $adapter->getBucket();
        $prefix = 'avatars/';
        $acl = 'private';
        $expires = '+10 minutes';
        $redirectUrl = url('/login');
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
        return view('auth.register', compact(['attributes', 'inputs']));
    }
    public function register(Request $request){
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        if ($response = $this->registered($request, $user)) {
            return $response;
        }

        return $request->wantsJson()
                    ? new JsonResponse([], 201)
                    : redirect($this->redirectPath());
    }
}

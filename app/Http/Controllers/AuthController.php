<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Spatie\ArrayToXml\ArrayToXml;
use Illuminate\Http\Response;
// use JWTAuth;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        // $this->middleware('auth:api', ['except' => ['login', 'register', 'auth_test']]);
        if($request->input('status') == 'expired'){
            $content = ['error' => ' ', 'new' => $this->createNewToken(JWTAuth::refresh())];
            $result = ArrayToXml::convert($content);
            return response($result, 200)->header('Content-Type', 'text/xml');
        }
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);


        Log::channel('stderr')->info('Something happened!  login');
        // $xml = new SimpleXMLElement('<root/>');

        if ($validator->fails()) {
            $content = ['error' => $validator->errors()->toArray()];
            // $content = ['error' => $validator->errors()];
            $result = ArrayToXml::convert($content);
            return response($result, 200)->header('Content-Type', 'text/xml');

            // return response()->json($validator->errors(), 200);
        }
        // if (!$token =auth('api')->attempt($credentials)) {
        if (!$token =JWTAuth::attempt($credentials)) {
            $content = ['error' => 'Unauthorized'];
            $result = ArrayToXml::convert($content);
            return response($result, 200)->header('Content-Type', 'text/xml');
            // return response()->json(['error' => 'Unauthorized'], 200);
        }

        $content = [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60 ,
            // 'expires_in' => JWTAuth::factory()->getTTL() * 60,
            // 'user' => auth('api')->user(),
            'user' => JWTAuth::user()->toArray()
        ];
        $result = ArrayToXml::convert($content);
        return response($result, 200)->header('Content-Type', 'text/xml');
    }

    public function me()
    {
        // return response()->json($this->guard()->user(), 200);
        $content = ['user' => $this->guard()->user()];
        $result = ArrayToXml::convert($content);
        return response($result, 200)->header('Content-Type', 'text/xml');
    }

    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|confirmed|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::create(array_merge(
            $validator->validated(),
            ['password' => bcrypt($request->password)]
        ));

        // return response()->json([
        //     'message' => 'User successfully registered',
        //     'user' => $user
        // ], 201);
        $content = [
            'message' => 'User successfully registered',
            'user' => $user
        ];
        $result = ArrayToXml::convert($content);
        return response($result, 200)->header('Content-Type', 'text/xml');
    }


    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {
        // auth('api')->logout();
        JWTAuth::logout();

        // return response()->json(['message' => 'User successfully signed out']);
        $content = ['message' => 'User successfully signed out'];
        $result = ArrayToXml::convert($content);
        return response($result, 200)->header('Content-Type', 'text/xml');
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh() {
        // return $this->createNewToken(auth('api')->refresh());
        // return $this->createNewToken(JWTAuth::refresh());
        $result = ArrayToXml::convert($this->createNewToken(JWTAuth::refresh()));
        return response($result, 200)->header('Content-Type', 'text/xml');
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile()
    {
        // return response()->json(auth()->user());
        try {

                if (! $user = JWTAuth::parseToken()->authenticate()) {
                    // return response()->json(['user_not_found'], 404);
                    $content = ['error' => 'user_not_found'];
                    $result = ArrayToXml::convert($content);
                    return response($result, 200)->header('Content-Type', 'text/xml');
                }

        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

                // return response()->json(['token_expired'], $e->getStatusCode());
            $content = ['error' => 'token_expired'];
            $result = ArrayToXml::convert($content);
            return response($result, 200)->header('Content-Type', 'text/xml');

        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

                // return response()->json(['token_invalid'], $e->getStatusCode());
            $content = ['error' => 'token_invalid'];
            $result = ArrayToXml::convert($content);
            return response($result, 200)->header('Content-Type', 'text/xml');

        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {

                // return response()->json(['token_absent'], $e->getStatusCode());
            $content = ['error' => 'token_absent'];
            $result = ArrayToXml::convert($content);
            return response($result, 200)->header('Content-Type', 'text/xml');

        }

        // return response()->json(compact('user'));
        $content = ['user' => $user];
        $result = ArrayToXml::convert($content);
        return response($result, 200)->header('Content-Type', 'text/xml');
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token){
        Log::channel('stderr')->info(JWTAuth::user()->refreshTTL);
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60,
            // 'user' => auth('api')->user(),
            'user' => JWTAuth::user()->toArray()
        ];
        // if($type == 'new'){
        //     return [
        //         'access_token' => $token,
        //         'token_type' => 'bearer',
        //         'expires_in' => JWTAuth::factory()->getTTL() * 60,
        //         'user' => JWTAuth::user()->toArray(),
        //     ];
        // }
        // else if($type == 'refresh'){
            // return [
            //     'access_token' => $token,
            //     'token_type' => 'bearer',
            //     'expires_in' => JWTAuth::factory()->getRefreshTTL(),
            //     'user' => JWTAuth::user()->toArray(),
            // ];
        // }

    }

    public function auth_test()
    {
        echo json_encode(Auth::check());
    }

    public function guard()
    {
        // return Auth::guard('api');
        return JWTAuth::user()->toArray();
    }
}

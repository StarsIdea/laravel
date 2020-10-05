<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Models\Subscribe;

class UserController extends Controller
{
    public function dashboard() {
        return view('dashboard');
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

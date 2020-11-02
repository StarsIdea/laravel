<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    public function allowed($userType, $id){
        $user = User::where(['id' => $id])->first();
        // print_r($user);
        if($user != null){
            $user->allowed = true;
            $user->save();
        }
        if($userType == "performer")
            return redirect()->route('performerList');
        else if($userType == "venue")
            return redirect()->route('venueList');
    }
}
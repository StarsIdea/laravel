<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuditionController extends Controller
{
    public function __construct(){
        // $this->middleware('auth');
    }

    public function index() {
        return view('audition');
    }

    public function audition_list(){
        return view('images')->with('images', auth()->user()->images);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function about() {
        return view('about');
    }

    public function playing() {
        return view('playing');
    }

    public function terms() {
        return view('terms');
    }

    public function audition() {
        return view('audition');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Aws\S3\PostObjectV4;

class AuditionController extends Controller
{
    public function __construct(){
        // $this->middleware('auth');
    }

    public function index() {
        $adapter = Storage::getAdapter();
        $client = $adapter->getClient();
        $bucket = $adapter->getBucket();
        $prefix = 'uploads/';
        $acl = 'private';
        $expires = '+10 minutes';
        $redirectUrl = url('.');
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
    }

    public function audition_list(){
        return view('images')->with('images', auth()->user()->images);
    }
}

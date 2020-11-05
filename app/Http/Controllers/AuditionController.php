<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Aws\S3\PostObjectV4;
use App\Models\Video;
use Illuminate\Support\Facades\Redirect;

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

    public function auditionList(){
        $videos = Video::all();
        return view('admin.audition-list', compact('videos'));
    }

    public function auditionApprove($id){
        $generated_code = md5(uniqid(rand(), true));
        $video = Video::where('id', '=', $id)->first();
        $video->verification_code = $generated_code;
        $video->save();
        $result = MailController::sendVerificationCode($video->name, $video->email, $video->verification_code);
        if($result){
            echo json_encode("success");
        }
        else{
            echo json_encode("something went wrong");
        }
        return Redirect::to('/admin/audition');
    }

    public function check_verification_code(Request $request)
    {
        $code = $request->input('verification_code');
        $video = Video::where('verification_code', '=', $code)->first();
        if ($video != null) {
            echo json_encode('exist');
        } else {
            echo json_encode('empty');
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;
use App\Http\Requests\StoreVideo;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    private $video;
    public function __construct(Video $video)
    {
        $this->video = $video;
    }

    public function getVideos()
    {
        return view('videos')->with('videos', auth()->user()->video);
    }

    public function postUpload(Request $request)
    {
        // $path = Storage::disk('s3')->put('videos/originals', $request->file);
        $request->merge([
            'size' => ' ',
            'path' => 'uploads/'.$request->input('filename')
        ]);
        // $this->video->create($request->only('name', 'email', 'telephone', 'band', 'genre', 'location', 'path', 'size'));
        $this->video->create($request->only('name', 'email', 'telephone', 'band', 'genre', 'location', 'path', 'size'));

        MailController::newSubmission();

        // return back()->with('success', 'Video Successfully Saved');
        echo json_encode("success");
    }
}

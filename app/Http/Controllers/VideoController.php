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
        return view('videos')->with('videos', auth()->user()->Video);
    }

    public function postUpload(StoreVideo $request)
    {
        $path = Storage::disk('s3')->put('videos/originals', $request->file);
        $request->merge([
            'size' => $request->file->getSize(),
            'title'=> 'test',
            'path' => $path
        ]);
        $this->video->create($request->only('path', 'title', 'size'));
        // return back()->with('success', 'Video Successfully Saved');
        echo "result";
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Video;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class HomeController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

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

    public function dashboard(){
        // $s3 = \Storage::disk('s3');
        // $client = $s3->getDriver()->getAdapter()->getClient();
        // $expiry = "+10 minutes";

        // // $key = encodeKey("avatars/1603678741025_mp4.gif");
        // $command = $client->getCommand('GetObject', [
        //     'Bucket' => \Config::get('filesystems.disks.s3.bucket'),
        //     'Key'    => "avatars/1603678741025_mp4.gif"
        // ]);

        // $request = $client->createPresignedRequest($command, $expiry);

        $videos = Video::all();

        // for($i = 0; $i < count($videos); $i ++){
        //     $command = $client->getCommand('GetObject', [
        //         'Bucket' => \Config::get('filesystems.disks.s3.bucket'),
        //         'Key'    => $videos[$i]['path']
        //     ]);
        //     // print_r($command);
        //     $videos[$i]['link'] = $client->createPresignedRequest($command, $expiry);
        // }
        return view('dashboard', compact('videos'));
    }

    public function download($id){
        $video = DB::table('videos')->where('id', $id)->first();
        $s3 = \Storage::disk('s3');
        $client = $s3->getDriver()->getAdapter()->getClient();
        $expiry = "+10 minutes";
        // $path = "videos/originals/vud2adzFIeL3iq7yyMfGGnK0Bnux28IHbT3lriAM.mp4";
        $path = $video->path;
        $command = $client->getCommand('GetObject', [
            'Bucket' => \Config::get('filesystems.disks.s3.bucket'),
            // 'Key'    => $video->path
            'Key' => $path 
        ]);
        echo ($client->createPresignedRequest($command, $expiry)->getUri());
        return Redirect::to($client->createPresignedRequest($command, $expiry)->getUri());
        // return $client->createPresignedRequest($command, $expiry)->getUri();
    }

    public function performerList(){
        $users = User::where('userType', '=', 'talent')->get();
        return view('admin.performer-list', compact('users'));
    }

    public function venueList(){
        $users = User::where('userType', '=', 'venue')->get();
        return view('admin.venue-list', compact('users'));
    }
}

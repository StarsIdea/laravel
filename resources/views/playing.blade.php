@extends('layouts.blank')
@section('content')

    <link href="https://unpkg.com/video.js/dist/video-js.min.css" rel="stylesheet">
    <script src="https://unpkg.com/video.js/dist/video.min.js"></script>

    <style>
        body {
            background: url('{{ asset("images/bg01.jpg")}}');
            color: white;
        }
    </style>

    <div class="container my-5">
        <h1 class="text-center">Playing</h1>
        <p class="mt-4">
            Building a website is, in many ways, an exercise of willpower. It’s tempting to get distracted by the bells and whistles of the design process, and forget all about creating compelling content.

            It's that compelling content that's crucial to making inbound marketing work for your business.

            So how do you balance your remarkable content creation with your web design needs? It all starts with the "About Us" page.
            For a remarkable about page, all you need to do is figure out your company's unique identity, and then share it with the world. Easy, right? Of course not. Your "About Us" page is one of the most important pages on your website, and it needs to be well crafted. This profile also happens to be one of the most commonly overlooked pages, which is why you should make it stand out.
        </p>
    
        <video
            id="my-player"
            class="video-js"
            controls
            preload="auto"
            poster="//vjs.zencdn.net/v/oceans.png"
            data-setup='{}'
            style="width: 100%; height: 480px; border-radius: 10px;"    
        >
            <source src="https://bitdash-a.akamaihd.net/content/sintel/hls/playlist.m3u8" type="application/x-mpegURL"></source>
            <p class="vjs-no-js">
                To view this video please enable JavaScript, and consider upgrading to a
                web browser that
                <a href="https://videojs.com/html5-video-support/" target="_blank">
                supports HTML5 video
                </a>
            </p>
        </video>
        <p class="mt-2 text-center">Sample video</p>
    </div>
@endsection
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>LiveShow - @yield('title')</title>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"
            integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog=="
            crossorigin="anonymous" />
        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.7.0/dist/alpine.js" defer></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        <style>
            .py-12.content {
                min-height: calc(100vh - 250px);
                justify-content: center;
                display: flex;
                flex-direction: column;
            }

            .category {
                min-width: 500px;
            }

            @media only screen and (max-width: 600px) {
                .category {
                    min-width: 300px;
                }
            }

            body {
                background-repeat: no-repeat;
                background-size: cover;
                /* background: url({{ asset('images/bg01.jpg')}}); */
            }

            .content .dashboard .category {
                background-color: #fff;
            }
            .personal-info{
                display:block;
                color: #0f75bc;
                font-weight: 600;
                max-width: 800px;
                margin: auto;
            }
            .personal-info .col-md-12.header-section{
                margin-bottom: 50px;
            }
            .personal-info .col-md-12.header-section, .sub-item{
                display: flex;
                font-size: 24px;
                text-align: center;
            }
            .sub-item ul{
                display: flex;
                list-style: none;
                margin-top: 8px;
                margin-bottom: 20px;
            }
            .sub-item ul li{
                padding: 0px 10px;
                background-color: #0f75bc;
                border-radius: 5px;
                color: #fff;
                margin: 0px 5px;
                font-size: 18px;
            }
            .sub-title{
                font-size: 32px;
            }
            .band-name{
                font-size: 42px;
                justify-content: center;
                align-content: center;
                display: grid;
            }
            body{
                background-color: #fff !important;
            }
            .img-user{
                background-color: #999;
                height: calc(33vw - 34px);
            }
            @media only screen and (min-width: 800px) {
                .header-section .img-user{
                    height: 200px;
                }
            }
            .upcoming .sub-item table{
                display:flex;
            }
            .upcoming .sub-item table,
            .upcoming .sub-item table td,
            .upcoming .sub-item table tr{
                border: 0px;
            }

        </style>
    </head>

    <body>
        <div class="py-12 content">
            <div class="col-md-12 personal-info">
                <div class="col-md-12 header-section">
                    <div class="col-md-4 img-user">
                        <img src="{!! Storage::disk('s3')->url($user->photo) !!}" alt="{{ $user->name }}" class="rounded-full h-20 w-20 object-cover">
                    </div>
                    <div class="col-md-4 band-name">{{ $user->band}}</div>
                    <div class="col-md-4 logo"><img src="{{ asset('images/blue-logo.png') }}" /></div>
                </div>
                <div class="col-md-12">
                    <div class="sub-title">Virtual Tip Jar</div>
                    <div class="col-md-12 sub-item">
                        Cashapp
                        <ul>
                            <li>$1</li>
                            <li>$3</li>
                            <li>$5</li>
                            <li>$10</li>
                            <li>Other</li>
                        </ul>
                    </div>
                    <div class="col-md-12 sub-item">
                        PayPal
                        <ul>
                            <li>$1</li>
                            <li>$3</li>
                            <li>$5</li>
                            <li>$10</li>
                            <li>Other</li>
                        </ul>
                    </div>
                    <div class="col-md-12 sub-item">
                        Venmo
                        <ul>
                            <li>$1</li>
                            <li>$3</li>
                            <li>$5</li>
                            <li>$10</li>
                            <li>Other</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="sub-title">Social Media</div>
                    <div class="col-md-12 sub-item">
                        Website: <span>{{ $user->website }}</span>
                    </div>
                    <div class="col-md-12 sub-item">
                        Instagram: <span>{{ $user->instagram }}</span>
                    </div>
                    <div class="col-md-12 sub-item">
                        Facebook: <span>{{ $user->facebook }}</span>
                    </div>
                    <div class="col-md-12 sub-item">
                        Twitter: <span>{{ $user->twitter }}</span>
                    </div>
                </div>
                <div class="col-md-12 upcoming">
                    <div class="sub-title">Upcoming Shows</div>
                    <div class="col-md-12 sub-item">
                        <table>
                            @foreach($eventList as $key => $event)
                            <tr>
                                <td>{{ $event->start_time }}</td>
                                <td>{{ $event->description }}</td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </body>

</html>


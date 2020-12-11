@extends('layouts.blank')
@section('extra-css')
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
            background: url({{ asset('images/bg01.jpg')}});
        }

        .content .dashboard .category {
            background-color: #fff;
        }

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
                font-weight: 500;
                /* max-width: 800px; */
                margin: auto;
                background-color: #fff;
                border-radius: 10px;
                padding: 30px 10px;
            }
            .personal-info a{
                color: #0f75bc;
            }
            .personal-info>div{
                margin-bottom: 20px;
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
                font-size: 24px;
            }
            .band-name{
                font-size: 42px;
                justify-content: center;
                align-content: center;
                font-weight: bold;
                /* display: grid */
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
            .upcoming .sub-item table,
            .previous .sub-item table{
                display:flex;
            }
            .upcoming .sub-item table,
            .upcoming .sub-item table td,
            .upcoming .sub-item table tr,
            .previous .sub-item table,
            .previous .sub-item table td,
            .previous .sub-item table tr{
                border: 0px;
            }
            .link-edit a{
                font-size: 16px;
                font-weight: bold;
            }
            .stream-key{
                display: flex;
            }
            .upcoming .sub-item:first-child{
                padding: 0px;
            }
            .stream-key a, .upcoming .sub-item:first-child a, .previous .sub-item:first-child a{
                padding: 0px 20px;
                background-color: #0f75bc;
                color: #fff;
                line-height: 20px;
                margin-left: auto;
            }
            .upcoming .btn-edit{
                color: #fff;
                background-color:#0452a7;
                padding: 0px 10px;
                font-size: 14px;
            }
            .upcoming .btn-delete{
                color: #fff;
                background-color:#cc0133;
                padding: 0px 10px;
                font-size: 14px;
            }
            .previous .btn-view{
                color: #fff;
                background-color:#0452a7;
                padding: 0px 10px;
                font-size: 14px;
            }
            .upcoming table, .previous table{
                margin-left: 50px;
            }
            .public-page-url a{
                text-decoration: underline;
            }

    </style>
    <link rel="stylesheet" href="{{ asset('css/home.css') }}" />
@endsection
@section('content')
    <div class="py-12 content">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 dashboard">
            <div class="col-md-12 personal-info">
                <div class="col-md-12 header-section">
                    <div class="col-md-4 img-user">
                        <img src="{!! Storage::disk('s3')->url(Auth::user()->photo) !!}" alt="{{ Auth::user()->name }}" class="rounded-full h-20 w-20 object-cover">
                    </div>
                    <div class="col-md-4 band-name">{{ Auth::user()->band}}</div>
                    <div class="col-md-4 link-edit"><a href="{{ route('current_user_profile') }}">Edit Account Info</a></div>
                </div>
                <div class="col-md-12 public-page-url">
                    <div class="sub-title">Public Page: <a href="{{ url('/talent') }}/{{Auth::user()->public_url}}">{{ url('/talent') }}/{{Auth::user()->public_url}}</a></div>
                </div>
                <div class="col-md-12 stream-key">
                    <div class="sub-title">Stream Key: {{ Auth::user()->stream_key }}</div>
                    <a href="/admin/stream_key_code" class="btn btn-change">Change</a>
                </div>
                <div class="col-md-12 upcoming">
                    <div class="col-md-12 sub-item">
                        <div class="sub-title">Upcoming Shows</div>
                        <a href="/admin/eventList/upcoming" class="btn btn-change">Add Show</a>
                    </div>
                    <div class="col-md-12 sub-item">
                        <table>
                            @foreach($eventList as $key => $event)
                            <tr>
                                <td>{{ $event->start_time }}</td>
                                <td>{{ $event->description }}</td>
                                <td><a href="/admin/editEvent/{{ $event->id }}" class="btn btn-edit">Edit</a></td>
                                <td><a href="/admin/deleteEvent/{{ $event->id }}" class="btn btn-delete">Delete</a></td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>

                <div class="col-md-12 previous">
                    <div class="sub-title">Event History</div>
                    <div class="col-md-12 sub-item">
                        <table>
                            @foreach($oldEventList as $key => $event)
                            <tr>
                                <td>{{ $event->start_time }}</td>
                                <td>{{ $event->description }}</td>
                                <td><a href="/admin/eventList/prev" class="btn btn-view">View Show</a></td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

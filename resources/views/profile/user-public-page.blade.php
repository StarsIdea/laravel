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

    </style>
    <link rel="stylesheet" href="{{ asset('css/home.css') }}" />
@endsection
@section('content')
    <div class="py-12 content">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 dashboard">
            <h4> <a href="{{ route('current_user_profile') }}">Edit Profile</a></h4>
            <div class="col-md-12">
                <div class="col-md-12">
                    <h3>{{ Auth::user()->name }}</h3>
                </div>
                <div class="col-md-12">
                    <img src="{!! Storage::disk('s3')->url(Auth::user()->photo) !!}" alt="{{ Auth::user()->name }}" class="rounded-full h-20 w-20 object-cover">
                </div>
                <div class="col-md-12">
                    <h2>Upcoming Event List</h2>
                    <table>
                        <thead>
                            <th>No</th>
                            <th>Start Time</th>
                            <th>Description</th>
                            <th>Actual Start</th>
                            <th>Actual End</th>
                            <th>PlayList</th>
                        </thead>
                        <tbody>
                            @foreach($eventList as $key => $event)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $event->start_time }}</td>
                                <td>{{ $event->description }}</td>
                                <td>{{ $event->actual_start }}</td>
                                <td>{{ $event->actual_end }}</td>
                                <td>{{ $event->playlist }}</td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                <div class="col-md-12">
                    <ul>
                        <li><a href="https://venmo.com/">venmo</a></li>
                        <li><a href="https://www.paypal.com/">paypal</a></li>
                        <li><a href="https://cash.app/">cashapp</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

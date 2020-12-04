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
            <input type="submit" onclick="window.location.href='/admin/addEvent'" class="btn" value="New Event">
            <h1>Event List</h1>
            <ul>
                <li><a href="/admin/eventList/upcoming">Upcoming Event</a></li>
                <li><a href="/admin/eventList/prev">Previous events</a></li>
            </ul>
            <table>
                <thead>
                    <th>No</th>
                    <th>Start Time</th>
                    <th>Description</th>
                    <th>Actual Start</th>
                    <th>Actual End</th>
                    <th>PlayList</th>
                    @if($eventType == 'upcoming')
                    <th>Action</th>
                    @endif
                </thead>
                <tbody>
                    @foreach($eventList as $key => $event)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        @if($eventType == 'upcoming')
                            <td>{{ $event->start_time }}</td>
                            <td>{{ $event->description }}</td>
                            <td>{{ $event->actual_start }}</td>
                            <td>{{ $event->actual_end }}</td>
                            <td>{{ $event->playlist }}</td>
                            <td><a href="/admin/editEvent/{{ $event->id }}">Edit</a></td>
                        @else
                            <td>{{ $event->start_time }}</td>
                            <td>{{ $event->description }}</td>
                            <td>{{ $event->actual_start }}</td>
                            <td>{{ $event->actual_end }}</td>
                            <td>{{ $event->playlist }}</td>
                        @endif
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
@endsection

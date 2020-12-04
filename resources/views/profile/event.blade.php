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
            @if($action == 'add')
            <h1> New Event </h1>
            @elseif($action == 'edit')
            <h1> Edit Event </h1>
            @endif
            <form action="@if($action == 'add')/admin/addEvent @elseif($action == 'edit') /admin/editEvent/{{ $event->id }} @endif" id="frm_subscribe" method="POST">
                @csrf
                <textarea name="description">@if($action == 'add')@elseif($action == 'edit'){{ $event->description }}@endif</textarea>
                {{-- <input type="text" name="playlist" value="@if($action == 'add')@elseif($action == 'edit'){{ $event->playlist }}@endif"> --}}
                <input type="submit" value="Submit">
            </form>
        </div>
    </div>
@endsection

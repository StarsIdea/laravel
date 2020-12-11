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
        .content .dashboard{
            max-width: 1200px;
            width: 100%;
        }
        .content .dashboard form#frm_subscribe{
            display: block;
        }
        .content .dashboard form#frm_subscribe div{
            margin-bottom: 30px;
        }
        form input, form select{
            color:#000;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/home.css') }}" />
@endsection
@section('content')
    <div class="py-12 content">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 dashboard">
            <div class="col-md-12">
                @if($action == 'add')
                <h1> New Event </h1>
                @elseif($action == 'edit')
                <h1> Edit Event </h1>
                @endif
            </div>
            <form action="@if($action == 'add')/admin/addEvent @elseif($action == 'edit') /admin/editEvent/{{ $event->id }} @endif" id="frm_subscribe" method="POST">
                @csrf
                {{-- <div class="col-md-12">
                    <input type="date" name="date" />
                    <input type="time" name="time" />
                </div> --}}
                <div class="col-md-12">
                    <textarea name="description">@if($action == 'add')@elseif($action == 'edit'){{ $event->description }}@endif</textarea>
                </div>
                <div class="col-md-12">
                    <input type="submit" value="Submit">
                </div>
                {{-- <input type="text" name="playlist" value="@if($action == 'add')@elseif($action == 'edit'){{ $event->playlist }}@endif"> --}}
            </form>
        </div>
    </div>
@endsection

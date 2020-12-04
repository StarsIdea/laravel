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
            <h1> Stream Key </h1>
            <h4>{{ $streamKeyCode }}</h4>
            <form action="/admin/update_stream_key_code" id="frm_subscribe" method="POST">
                @csrf
                <input type="text" name="streamkeycode" value="{{ $streamKeyCode }}">
                <input type="submit" value="Update">
            </form>
        </div>
    </div>
@endsection

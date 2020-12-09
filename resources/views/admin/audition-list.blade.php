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

        td, th{
            color: #000;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/home.css') }}" />
@endsection
@section('content')
    <div class="py-12 content">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 dashboard">
            <h4> {{ __('Audition List') }}</h4>
            <div>
                <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                    <div class="py-12">
                        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                                <table class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                                    <thead>
                                        <th>name</th>
                                        <th>email</th>
                                        <th>telephone</th>
                                        <th>band</th>
                                        <th>genre</th>
                                        <th>location</th>
                                        <th>created at</th>
                                        <th>updated at</th>
                                        <th>approve</th>
                                    </thead>
                                    <tbody>
                                    @foreach ($videos as $video)
                                        <tr>
                                            <td>{{ $video->name }}</td>
                                            <td>{{ $video->email }}</td>
                                            <td>{{ $video->telephone }}</td>
                                            <td>{{ $video->band }}</td>
                                            <td>{{ $video->genre }}</td>
                                            <td>{{ $video->location }}</td>
                                            <td>{{ $video->created_at }}</td>
                                            <td>{{ $video->updated_at }}</td>
                                            <td>
                                                @if($video->verification_code != null)
                                                    <i class="fa fa-check"></i>
                                                @else
                                                    @if(Auth::user()->userType == 'talent')
                                                        <a class="btn" href="/admin/audition/approve/{{ $video->id }}">
                                                            <x-jet-button class="ml-4">
                                                                Approve
                                                            </x-jet-button>
                                                        </a>
                                                    @else
                                                        <i class="fa fa-minus"></i>
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Audition List') }}
        </h2>
    </x-slot>
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
</x-app-layout>

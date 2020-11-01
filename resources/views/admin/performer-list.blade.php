<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Performer List') }}
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
                                <th>Allowed</th>
                                <th>Allow</th>
                            </thead>
                            <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->telephone }}</td>
                                    <td>{{ $user->band }}</td>
                                    <td>{{ $user->genre }}</td>
                                    <td>{{ $user->location }}</td>
                                    <td>
                                        @if($user->allowed)
                                            <i class="fa fa-check"></i>
                                        @else
                                            <i class="fa fa-minus"></i>
                                        @endif
                                    </td>
                                    <td>
                                        <a class="btn" href="/allow/{{ $user->id }}" target="_blank">
                                            <x-jet-button class="ml-4">Allow
                                            </x-jet-button>
                                        </a>
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
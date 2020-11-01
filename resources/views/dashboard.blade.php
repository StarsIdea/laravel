<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 dashboard">
            <div class="category"><a href="/admin/audition">Uploaded Auditions</a></div>
            <div class="category"><a href="/admin/performer">Performer List</a></div>
            <div class="category"><a href="/admin/venue">Venue List</a></div>
        </div>
    </div>
</x-app-layout>
